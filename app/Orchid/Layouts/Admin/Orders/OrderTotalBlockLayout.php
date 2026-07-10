<?php

namespace App\Orchid\Layouts\Admin\Orders;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderTotalBlockLayout extends Table
{

    protected $target = 'order';

    protected function prepareTotal(): array
    {
        $itemsTotal = 0;

        $basket = $this->query->toArray()['basketItems'];

        foreach ($basket as $item) {
            $itemsTotal += $item->price;
        }

        return [
            'basket_total' => $itemsTotal,
            'total' => $itemsTotal + $this->query->toArray()['order']->delivery_price,
            'delivery_price' => $this->query->toArray()['order']->delivery_price
        ];
    }

    protected function columns(): iterable
    {
        $info = $this->prepareTotal();

        return [
            TD::make('basket_items_total', __('Items total'))
                ->render(function () use($info){
                    return $info['basket_total'];
                }),

            TD::make('delivery_price_', __('Delivery total'))
                ->render(function () use($info){
                    return $info['delivery_price'];
                }),

            TD::make('order_total', __('Total'))
                ->render(function () use($info){
                    return $info['total'];
                }),
        ];
    }
}