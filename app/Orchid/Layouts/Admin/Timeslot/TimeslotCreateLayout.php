<?php

namespace App\Orchid\Layouts\Admin\Timeslot;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;


class TimeslotCreateLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Select::make('weekday')
                //->required()
                ->options($this->query->toArray()['weekdays'])
                ->multiple()
                ->title('Timeslot weekday (Regular)')
                ->empty('Select weekday'),

            Input::make('date')
                ->title('Timeslot date (Specific)')
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'dd-mm-yyyy',
                    'placeholder' => '_'
                ]),

            Input::make('begin')
                ->type('text')
                ->max(5)
                ->required()
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'HH:MM',
                    'placeholder' => '_'
                ])
                ->autocomplete(false)
                ->title(__('Start time'))
                ->placeholder(__('10:00')),

            Input::make('end')
                ->type('text')
                ->max(5)
                ->required()
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'HH:MM',
                    'placeholder' => '_'
                ])
                ->autocomplete(false)
                ->title(__('End time'))
                ->placeholder(__('18:00')),
        ];
    }
}
