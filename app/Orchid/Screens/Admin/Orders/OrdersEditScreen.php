<?php

namespace App\Orchid\Screens\Admin\Orders;

use App\Orchid\Layouts\Admin\Orders\OrderTotalBlockLayout;
use Orchid\Screen\Screen;
use App\Models\Order;
use App\Models\Basket;
use App\Models\BasketItem;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Admin\Orders\OrderPersonalInfoLayout;
use App\Orchid\Layouts\Admin\Orders\OrderDeliveryInfoLayout;
use App\Orchid\Layouts\Admin\Orders\OrderBasketInfoLayout;

class OrdersEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Order view';
    }

    public function query($id): array
    {
        $order = Order::find($id);
        $basket = Basket::where('order_id', $order->id)->first();
        $basketItems = BasketItem::where('basket_id', $basket->id)->get();

        return [
            'order' => $order,
            'basket' => $basket,
            'basketItems' => $basketItems
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::tabs(
                [
                    'Client info' => OrderPersonalInfoLayout::class,
                    'Order info' => OrderDeliveryInfoLayout::class,
                    'Basket' => OrderBasketInfoLayout::class
                ]
            ),
//            Layout::block(OrderTotalBlockLayout::class)
//                ->title('Total info')
        ];
    }
}
