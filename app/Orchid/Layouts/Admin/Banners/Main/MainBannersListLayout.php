<?php

namespace App\Orchid\Layouts\Admin\Banners\Main;

use App\Models\MainBanners;
use App\Models\Tours;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MainBannersListLayout extends Table
{

    protected $target = 'main_banners';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->filter(Input::make())
                ->render(function(MainBanners $banners) {
                    return $banners->name;
                }),

            TD::make('active', __('Active'))
                ->filter(Input::make())
                ->render(function(MainBanners $banners) {
                    return $banners->active ? 'Yes' : 'No';
                }),

            TD::make('sort', __('Sort'))
                ->filter(Input::make())
                ->render(function(MainBanners $banners) {
                    return $banners->sort;
                }),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (MainBanners $banners) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('main.banners.edit', $banners->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Remove banner?'))
                            ->method('remove', [
                                'id' => $banners->id,
                            ]),
                    ])),
        ];
    }
}
