<?php

namespace App\Orchid\Layouts\Admin\Timeslot;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class TimeslotEditLayout extends Rows
{

    protected function fields(): iterable
    {
        return [

            Input::make('id')
                ->type('hidden')
                ->max(255)
                ->required()
                ->value($this->query->toArray()['timeslot']->id),

            Select::make('weekday')
                ->options($this->query->toArray()['weekdays'])
                ->multiple()
                ->title('Timeslot weekday (Regular)')
                ->empty('Select weekday')
                ->value($this->query->toArray()['timeslot']->getCheckedWeekdays()),

            Input::make('date')
                ->title('Timeslot date (Specific)')
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'dd-mm-yyyy',
                    'placeholder' => '_'
                ])
                ->value($this->query->toArray()['timeslot']->getFormattedDate()),

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
                ->placeholder(__('10:00'))
                ->value($this->query->toArray()['timeslot']->getBeginFormatted()),

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
                ->placeholder(__('18:00'))
                ->value($this->query->toArray()['timeslot']->getEndFormatted()),
        ];
    }
}
