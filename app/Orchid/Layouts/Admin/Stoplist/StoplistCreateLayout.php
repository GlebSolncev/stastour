<?php

namespace App\Orchid\Layouts\Admin\Stoplist;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;


class StoplistCreateLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Select::make('tour_id')
                ->required()
                ->options($this->query->toArray()['tours'])
                ->title('Block tour')
                ->empty('Select tour'),

            Input::make('block_date')
                ->required()
                ->title('Block date')
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'dd-mm-yyyy',
                    'placeholder' => '_'
                ]),
        ];
    }
}
