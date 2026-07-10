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
        $basket = $this->getBasketItems();

        if (!$basket['success']) {
            return $basket;
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


        $customer = \Stripe\Customer::create(['metadata' => ['order_id' => $this->orderId]]);
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                $basket['items']
            ],
            'mode' => 'payment',
            'success_url' => $_SERVER['APP_URL'],
            'cancel_url' => $_SERVER['APP_URL'],
            'customer' => $customer->id
        ]);

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
