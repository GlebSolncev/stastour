<?php

namespace App\Orchid\Screens\Admin\Orders;

use App\Models\Order;
use App\Orchid\Layouts\Admin\Orders\OrdersListLayout;
use Orchid\Screen\Screen;

class OrdersListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Orders list';
    }

    public function query(): array
    {
        return [
            'orders' => Order::query()->orderBy('created_at', 'desc')->get()
        ];
    }

    public function layout(): iterable
    {
        return [
            OrdersListLayout::class
        ];
    }
}