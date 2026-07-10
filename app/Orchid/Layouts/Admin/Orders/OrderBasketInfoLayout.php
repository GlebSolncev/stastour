<?php

namespace App\Orchid\Layouts\Admin\Orders;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use App\Models\Tours;

class OrderBasketInfoLayout extends Rows
{

    protected function fields(): iterable
    {
        return $this->prepareBasket();
    }

    protected function prepareBasket(): array
    {
        $result = [];

        $basket = $this->query->toArray()['basketItems'];

        foreach ($basket as $basketItem) {
            if ($basketItem->is_tour) {
                $tour = Tours::find($basketItem->ext_id);
                $name = $tour->name;
            } else {
                // TODO SHOP ITEM NAME
                $name = '';
            }

            $info = 'price: ' . $basketItem->price . ' quantity: ' . $basketItem->quantity;

            $result[] = Input::make('items' . $basketItem->id)
                ->type('text')
                ->readonly()
                ->title(__('Basket item: ' . $name))
                ->value($info);
        }

        return $result;
    }
}