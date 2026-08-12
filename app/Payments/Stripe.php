<?php

namespace App\Payments;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Order;
use App\Models\Tours;
use App\Travel\Settings;

class Stripe
{
    protected int $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function create(): array
    {
        $order = Order::find($this->orderId);
        if (!$order || $order->status !== 'awaiting_payment') {
            return ['message' => 'Order is not ready for payment', 'success' => false];
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


        $customer = \Stripe\Customer::create([
            'email' => $order->email,
            'name' => $order->name,
            'metadata' => ['order_id' => $this->orderId],
        ]);
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($order->currency),
                    'product_data' => ['name' => 'Tour booking #' . $order->id],
                    'unit_amount' => (int) round(((float) $order->amount) * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'expires_at' => now()->addMinutes(30)->timestamp,
            'success_url' => url('/checkout/payment/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/checkout/?payment=cancelled'),
            'customer' => $customer->id,
            'metadata' => ['order_id' => (string) $order->id],
            'payment_intent_data' => [
                'metadata' => ['order_id' => (string) $order->id],
            ],
        ]);

        $order->update(['stripe_session_id' => $session->id, 'status' => 'payment_pending']);

        return ['url' => $session->url];
    }

    protected function getBasketItems(): array
    {
        $order = Order::find($this->orderId);

        if (!isset($order->id)) {
            return ['message' => 'Order not found', 'success' => false];
        }

        $basket = Basket::where('order_id', $order->id)->first();

        if (!isset($basket->id)) {
            return ['message' => 'Basket not found', 'success' => false];
        }

        $basketItems = BasketItem::where('basket_id', $basket->id)->get();

        if (empty($basketItems)) {
            return ['message' => 'Basket items not found', 'success' => false];
        }

        $result = [];

        foreach ($basketItems as $item) {
            if ($item->is_tour) {
                $tour = Tours::find($item->ext_id);
                $name = $tour->name;
            } else {
                // TODO shop
                $name = '';
            }

            $result[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $name
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity
            ];

        }

        return ['items' => $result, 'success' => true];
    }
}
