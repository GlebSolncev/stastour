<?php

namespace App\Orchid\Layouts\Admin\Tours;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Rows;

class ToursCreateLayout extends Rows
{

    protected function fields(): iterable
    {
        return [
            CheckBox::make('is_active')
                ->sendTrueOrFalse()
                ->value(true)
                ->title(__('Active'))
                ->placeholder(__('Show this tour on the website')),

            Input::make('name')
                ->type('text')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('bokun_id')
                ->type('number')
                ->min(1)
                ->title(__('Bokun experience ID'))
                ->help(__('Optional. Enables Bokun availability and booking for this tour.')),

            TextArea::make('preview_text')
                ->title('Preview text')
                ->required()
                ->rows(3),

            Quill::make('description')
                ->required()
                ->title('Description'),

            Upload::make('preview_photo')
                ->acceptedFiles('image/*,.avif,.avifs')
                ->title(__('Preview Photo'))
                ->required()
                ->maxFiles(1),

            Upload::make('detail_photo')
                ->acceptedFiles('image/*,.avif,.avifs')
                ->title(__('Detail Photo'))
                ->required()
                ->maxFiles(1),

            Upload::make('image')
                ->acceptedFiles('image/*,.avif,.avifs')
                ->title(__('Image gallery'))
                ->required()
                ->maxFiles(10),

            Select::make('type_tour')
                ->required()
                ->options($this->query->toArray()['tour_type'])
                ->title(__('Tour type'))
                ->help('Tour type'),

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

            Input::make('price')
                ->type('number')
                ->required()
                ->autocomplete(false)
                ->title(__('Price'))
                ->placeholder(__('Price')),

            Input::make('person_count')
                ->type('number')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Person count'))
                ->placeholder(__('Person count')),

            Input::make('duration_of_the_tour')
                ->type('number')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Duration of the tour'))
                ->placeholder(__('Duration of the tour')),

            Input::make('road')
                ->type('text')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Road'))
                ->placeholder(__('Road')),


            /*Input::make('label_color')
                ->required()
                ->type('color')
                ->title(__('Label Color'))*/


            Select::make('time_slot')
                ->required()
                ->multiple()
                ->options($this->query->toArray()['all_timeslots'])
                ->title(__('Time slot'))
                ->help('Time slot'),

            Select::make('type_road_tour')
                ->required()
                ->options($this->query->toArray()['type_road_tour'])
                ->title(__('Type road tour'))
                ->help('Type road tour'),


            Upload::make('map_file')
                ->title(__('Map'))
                ->acceptedFiles('.kml')
                ->maxFiles(1),



            /*TextArea::make('preview_text_fr')
                ->title('Preview text French')
                ->rows(3),

            TextArea::make('preview_text_es')
                ->title('Preview text Spanish')
                ->rows(3),*/

            /*Quill::make('description_fr')
                ->title('Description French'),

            Quill::make('description_es')
                ->title('Description Spanish'),*/

            Input::make('sort')
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->required()
                ->placeholder('Descending order')
                ->value(500),
        ];
    }
}
