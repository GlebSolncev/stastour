<?php

namespace App\Orchid\Layouts\Admin\Orders;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class OrderDeliveryInfoLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Input::make('delivery_price')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Deliver price'))
                ->placeholder(__('Delivery price'))
                ->value($this->query->toArray()['order']->delivery_price),

            Input::make('timeslot_date')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Timeslot date'))
                ->placeholder(__('Timeslot date'))
                ->value($this->query->toArray()['order']->timeslot_date),

            Input::make('timeslot_count')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Timeslot count'))
                ->placeholder(__('Timeslot count'))
                ->value($this->query->toArray()['order']->timeslot_count),

            CheckBox::make('is_paid')
                ->value($this->query->toArray()['order']->is_paid)
                ->title('Is paid')
                ->placeholder('Is paid'),
        ];
    }
}