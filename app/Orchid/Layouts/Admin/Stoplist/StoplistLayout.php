<?php

namespace App\Orchid\Layouts\Admin\Stoplist;

use App\Models\MainBanners;
use App\Models\Timeslot;
use App\Models\TourTimeslotBlock;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StoplistLayout extends Table
{
    protected $target = 'stoplist';

    protected function columns(): iterable
    {
        return [
            TD::make('date', __('Block date'))
                ->render(function (TourTimeslotBlock $ttb) {
                    return Carbon::create($ttb->block_date)->format('j-m-Y');
                }),

            TD::make('tour', __('Tour'))
                ->render(function (TourTimeslotBlock $ttb) {
                    return $ttb->getTourName();
                }),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (TourTimeslotBlock $ttb) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('tour_stops.edit', $ttb->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Remove Stop list?'))
                            ->method('remove', [
                                'id' => $ttb->id,
                            ]),
                    ])),
        ];
    }
}
