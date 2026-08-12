<?php

namespace App\Orchid\Layouts\Admin\Orders;

use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use App\Models\Order;
use Orchid\Screen\TD;

class OrdersListLayout extends Table
{
    protected $target = 'orders';

    protected function columns(): iterable
    {
        return [

            TD::make('id', __('Id'))
                ->filter(Input::make())
                ->render(function (Order $order) {
                    return $order->id;
                }),

            TD::make('name', __('Customer name'))
                ->filter(Input::make())
                ->render(function (Order $order) {
                    return $order->name;
                }),

//            TD::make('basket', __('Basket'))
//                ->render(function (Order $order) {
//                    return $order->getBasketRows();
//                }),

            TD::make('date', __('Date'))
                ->render(function (Order $order) {
                    return $order->getDate();
                }),



            TD::make('is_paid', __('Is paid'))
                ->filter(Input::make())
                ->render(function (Order $order) {
                    return $order->is_paid ? 'Y' : 'N';
                }),

            TD::make('status', __('Status'))
                ->render(fn (Order $order) => $order->status ?? 'legacy'),

            TD::make('bokun_confirmation_code', __('Bokun'))
                ->render(fn (Order $order) => $order->bokun_confirmation_code ?: '—'),

            TD::make('bokun_status', __('Bokun status'))
                ->render(fn (Order $order) => $order->bokun_status ?: '—'),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Order $order) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('View'))
                            ->route('orders.edit', $order->id)
                            ->icon('pencil'),
                    ])),
        ];
    }
}
