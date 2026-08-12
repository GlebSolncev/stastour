<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Travel\Settings;
use Illuminate\Http\Request;
use App\Payments\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Services\Bokun\BokunBookingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Stripe\Exception\ApiErrorException;


class PaymentController extends Controller
{
    public function stripeCreate(Request $request): array
    {
        return (new Stripe($request->get('order_id')))->create();
    }

    private function success($object, BokunBookingService $bokun): void
    {
        $orderId = $object->metadata->order_id ?? null;
        if (!$orderId && isset($object->customer)) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $customer = \Stripe\Customer::retrieve($object->customer);
            $orderId = $customer->metadata['order_id'] ?? null;
        }
        $transactionId = (string) ($object->payment_intent ?? $object->id);
        $this->confirmPaidOrder((int) $orderId, $transactionId, $bokun);
    }

    private function confirmPaidOrder(int $orderId, string $transactionId, BokunBookingService $bokun): Order
    {
        return Cache::lock('stripe-bokun-confirm-' . $orderId, 30)->block(10, function () use ($orderId, $transactionId, $bokun) {
            $order = Order::findOrFail($orderId);
            if ($order->is_paid) {
                return $order;
            }

            $order->update([
                'status' => 'payment_received',
                'stripe_payment_intent_id' => $transactionId,
            ]);

            if (!$order->bokun_confirmation_code) {
                $order->update([
                    'is_paid' => true,
                    'paid_at' => now(),
                    'status' => 'paid',
                ]);

                return $order->refresh();
            }

            try {
                $confirmation = $bokun->confirmReserved(
                    $order->bokun_confirmation_code,
                    (float) $order->amount,
                    $order->currency,
                    $transactionId
                );

                $order->update([
                    'is_paid' => true,
                    'paid_at' => now(),
                    'status' => 'paid',
                    'bokun_status' => 'confirmed_paid',
                    'bokun_payload' => $confirmation,
                ]);
            } catch (\Throwable $exception) {
                $order->update(['status' => 'payment_sync_failed', 'bokun_status' => 'confirm_failed']);
                Log::critical('Stripe paid but Bokun confirmation failed', [
                    'order_id' => $order->id,
                    'message' => $exception->getMessage(),
                ]);
                throw $exception;
            }

            return $order->refresh();
        });
    }

    public function checkoutSuccess(Request $request, BokunBookingService $bokun)
    {
        $sessionId = (string) $request->query('session_id', '');
        if (!preg_match('/^cs_(test|live)_[A-Za-z0-9]+$/', $sessionId)) {
            return response()->view('page.payment-success', [
                'confirmed' => false,
                'message' => 'Invalid or missing Stripe session ID.',
            ], 422);
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $orderId = (int) ($session->metadata->order_id ?? 0);
            $order = Order::find($orderId);

            if (!$order || !$order->stripe_session_id || !hash_equals($order->stripe_session_id, $session->id)) {
                throw new \RuntimeException('Stripe session does not belong to this order.');
            }
            if ($session->payment_status !== 'paid') {
                throw new \RuntimeException('Stripe has not confirmed this payment as paid.');
            }
            if ((int) $session->amount_total !== (int) round((float) $order->amount * 100)) {
                throw new \RuntimeException('Stripe payment amount does not match the order.');
            }
            if (strtoupper((string) $session->currency) !== strtoupper((string) $order->currency)) {
                throw new \RuntimeException('Stripe payment currency does not match the order.');
            }

            $transactionId = is_object($session->payment_intent)
                ? (string) $session->payment_intent->id
                : (string) ($session->payment_intent ?: $session->id);
            $order = $this->confirmPaidOrder($order->id, $transactionId, $bokun);

            return view('page.payment-success', [
                'confirmed' => true,
                'message' => 'Payment and booking confirmed successfully.',
                'order' => $order,
            ]);
        } catch (ApiErrorException $exception) {
            Log::error('Unable to verify Stripe Checkout session', [
                'session_id' => $sessionId,
                'message' => $exception->getMessage(),
            ]);

            return response()->view('page.payment-success', [
                'confirmed' => false,
                'message' => 'Unable to verify the payment with Stripe. Please contact support.',
            ], 502);
        } catch (\Throwable $exception) {
            Log::error('Unable to complete checkout return', [
                'session_id' => $sessionId,
                'message' => $exception->getMessage(),
            ]);

            return response()->view('page.payment-success', [
                'confirmed' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    private function expired($object, BokunBookingService $bokun): void
    {
        $orderId = $object->metadata->order_id ?? null;
        $order = Order::find($orderId);
        if (!$order || $order->is_paid) return;

        if (!$order->bokun_confirmation_code) {
            $order->update(['status' => 'expired']);
            return;
        }

        try {
            $bokun->abortReserved($order->bokun_confirmation_code);
        } catch (\Throwable $exception) {
            Log::warning('Unable to abort expired Bokun reservation', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);
        }

        $order->update(['status' => 'expired', 'bokun_status' => 'expired']);
    }

    public function stripeSuccess(Request $request, BokunBookingService $bokun)
    {
        $error = false;
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $signature, config('services.stripe.webhook')
            );

            switch ($event->type) {
                case 'checkout.session.completed':
                case 'payment_intent.succeeded':
                    $this->success($event->data->object, $bokun);
                    break;
                case 'checkout.session.expired':
                    $this->expired($event->data->object, $bokun);
                    break;
                default:
                    Log::info('Ignored Stripe webhook event', ['type' => $event->type]);
            }

        } catch (SignatureVerificationException $exception) {
            Log::warning('Invalid Stripe webhook signature', ['message' => $exception->getMessage()]);
            $error = 'Unknown: ' . $exception->getMessage();
        }

        if (!$error) {
            return ['done' => true];
        } else {
            return response($error, 400);
        }
    }
}
