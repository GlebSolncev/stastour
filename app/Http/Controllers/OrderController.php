<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Travel\Form\OrderForm;

class OrderController
{
    public static function register()
    {
        $basketItems = BasketController::getSessionBasketItems();

        if (!$basketItems || !count($basketItems->items)) {
            return redirect()->route('mainpage');
        }

        $tourItem = null;
        foreach ($basketItems->items as $basketItem) {
            if ($basketItem->is_tour) {
                $tourItem = $basketItem;
            }
        }

        $form = OrderForm::fromRequest();

        $order = new Order($form->toArray());

        if ($tourItem) {
            $order['timeslot_id'] = $tourItem->properties['timeslot_id'];
            $order['timeslot_date'] = $tourItem->properties['timeslot_date'];
            $order['timeslot_count'] = $tourItem->quantity;
        }

        $order->save();

        $basket = Basket::loadBasket();
        $basket->order_id = $order->id;
        $basket->session = 'order_' . $order->id;
        $basket->save();

        return [
            'done' => true,
            'data' => (object)[
                'id' => $order->id
            ]
        ];
    }
}
