<?php

namespace App\Orchid\Layouts\Admin\Stoplist;

use Carbon\Carbon;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class StoplistEditLayout extends Rows
{

    protected function fields(): iterable
    {
        return [

            Input::make('id')
                ->type('hidden')
                ->max(255)
                ->required()
                ->value($this->query->toArray()['stoplist']->id),

            Select::make('tour_id')
                ->required()
                ->options($this->query->toArray()['tours'])
                ->title('Block tour')
                ->empty('Select tour')
                ->value($this->query->toArray()['stoplist']->tour_id),

            Input::make('block_date')
                ->required()
                ->title('Block date')
                ->mask([
                    'alias' => 'datetime',
                    'inputFormat' => 'dd-mm-yyyy',
                    'placeholder' => '_'
                ])
                ->value(Carbon::create($this->query->toArray()['stoplist']->block_date)->format('d-m-Y')),
        ];
    }
}
