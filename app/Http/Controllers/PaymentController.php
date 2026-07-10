<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Travel\Settings;
use Illuminate\Http\Request;
use App\Payments\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;


class PaymentController extends Controller
{
    public function stripeCreate(Request $request): array
    {
        return (new Stripe($request->get('order_id')))->create();
    }

    private function success($object)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $customer = \Stripe\Customer::retrieve($object->customer);

        $orderId = $customer->metadata['order_id'];
        $order = Order::find($orderId);

        $order->is_paid = true;
        $order->save();
    }

    public function stripeSuccess(Request $request)
    {
        $error = false;
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $signature, config('services.stripe.webhook')
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->success($event->data->object);
                    break;
                default:
                    $error = 'Unknown event: ' . $event->type;
            }

            file_put_contents(__DIR__ . '/log.txt', print_r($event, true), FILE_APPEND);
        } catch (SignatureVerificationException $exception) {
            file_put_contents(__DIR__ . '/log.txt', print_r(
                [
                    'message' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'content' => $payload,
                    'sign' => $signature
                ], true
            ), FILE_APPEND);
            $error = 'Unknown: ' . $exception->getMessage();
        }

        if (!$error) {
            return ['done' => true];
        } else {
            return response($error, 400);
        }
    }
}
