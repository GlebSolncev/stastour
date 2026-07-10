<?php

namespace App\Orchid\Layouts\Admin\Timeslot;

use App\Models\MainBanners;
use App\Models\Timeslot;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TimeslotListLayout extends Table
{
    protected $target = 'timeslot';

    protected function columns(): iterable
    {
        return [
            TD::make('weekdays', __('Weekdays'))
                ->render(function (Timeslot $timeslot) {
                    return $timeslot->getWeekdaysFormatted();
                }),
            TD::make('begin', __('Start time'))
                ->filter(Input::make())
                ->render(function (Timeslot $timeslot) {
                    return $timeslot->getBeginFormatted();
                }),

            TD::make('end', __('End time'))
                ->filter(Input::make())
                ->render(function (Timeslot $timeslot) {
                    return $timeslot->getEndFormatted();
                }),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Timeslot $timeslot) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('timeslot.edit', $timeslot->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Remove tour?'))
                            ->method('remove', [
                                'id' => $timeslot->id,
                            ]),
                    ])),
        ];
    }
}
