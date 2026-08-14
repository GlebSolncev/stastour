<?php

namespace App\Orchid\Layouts\Admin\Tours;

use App\Http\Controllers\CatalogSectionController;
use App\Models\Tours;
use Illuminate\Support\Facades\URL;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TourListLayout extends Table
{
    protected $target = 'tours';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->filter(Input::make())
                ->render(function(Tours $tours) {
                    return $tours->name;
                }),

            TD::make('id', __('Id'))
                ->filter(Input::make())
                ->render(function(Tours $tours) {
                    return $tours->id;
                }),

            TD::make('bokun_id', __('Source'))
                ->render(function (Tours $tours) {
                    return $tours->bokun_id
                        ? __('Bokun') . ' #' . $tours->bokun_id
                        : __('Admin');
                }),

            TD::make('is_active', __('Active'))
                ->render(fn (Tours $tour) => $tour->is_active ? __('Yes') : __('No')),

            TD::make('id', __('Type'))
                ->filter(Input::make())
                ->render(function(Tours $tours) {
                    return $tours->type_tour;
                }),

            TD::make('id', __('Code'))
                ->filter(Input::make())
                ->render(function(Tours $tours) {
                    return $tours->code;
                }),

            TD::make('id', __('Url'))
                ->filter(Input::make())
                ->render(function(Tours $tours) {
                    return URL::to(CatalogSectionController::getUrl($tours));
                }),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Tours $tours) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('tour.edit', $tours->id)
                            ->icon('pencil'),

                        Button::make(__('Clone'))
                            ->method('copy', [
                                'id' => $tours->id,
                            ])
                            ->icon('copy'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Remove tour?'))
                            ->method('remove', [
                                'id' => $tours->id,
                            ]),
                    ])),
        ];
    }
}
