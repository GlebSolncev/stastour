<?php

namespace App\Orchid\Layouts\Admin\Banners\Main;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;


class MainBannersCreateLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            Input::make('name')
                ->type('text')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Name'))
                ->placeholder(__('Name')),

            TextArea::make('description')
                ->title('Description')
                ->rows(3),

            Input::make('button')
                ->title('Button name'),

            Input::make('url')
                ->title('Button URL'),

            /*Input::make('name_fr')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name French'))
                ->placeholder(__('Name French')),

            Input::make('name_es')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name Spanish'))
                ->placeholder(__('Name Spanish')),*/

            Upload::make('image')
                ->title(__('Banner image'))
                ->required()
                ->maxFiles(1),

            Select::make('position')
                ->options($this->query->toArray()['position'])
                ->title('Text position'),



            /*TextArea::make('description_fr')
                ->title('Description French')
                ->rows(3),

            TextArea::make('description_es')
                ->title('Description Spanish')
                ->rows(3),*/

            Input::make('sort')
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->required()
                ->value(500),

            CheckBox::make('active')
                ->title('Active')
                ->placeholder('Active')
                ->value(1),
        ];
    }
}
