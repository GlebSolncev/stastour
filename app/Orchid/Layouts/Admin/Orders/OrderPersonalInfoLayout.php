<?php
namespace App\Orchid\Layouts\Admin\Orders;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class OrderPersonalInfoLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Input::make('name')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client name'))
                ->placeholder(__('Client name'))
                ->value($this->query->toArray()['order']->name),

            Input::make('phone')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client phone'))
                ->placeholder(__('Client phone'))
                ->value($this->query->toArray()['order']->phone),

            Input::make('email')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client email'))
                ->placeholder(__('Client email'))
                ->value($this->query->toArray()['order']->email),

            Input::make('country')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client country'))
                ->placeholder(__('Client country'))
                ->value($this->query->toArray()['order']->country),

            Input::make('address')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client address'))
                ->placeholder(__('Client address'))
                ->value($this->query->toArray()['order']->address),

            Input::make('city')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client city'))
                ->placeholder(__('Client city'))
                ->value($this->query->toArray()['order']->city),

            Input::make('postal_code')
                ->type('text')
                ->max(255)
                ->readonly()
                ->title(__('Client postal code'))
                ->placeholder(__('Client postal code'))
                ->value($this->query->toArray()['order']->postal_code),

            TextArea::make('comments')
                ->value($this->query->toArray()['order']->comments)
                ->title('Comments')
                ->rows(3),
        ];
    }
}