<?php

namespace App\Orchid\Layouts\Admin\Tours;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ToursEditLayout extends Rows
{
    protected static function getImagesIds(?string $stream): array
    {
        return array_filter(explode(',', $stream), fn($entity) => is_numeric($entity));
    }

    protected function fields(): iterable
    {
        return [
            Input::make('name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name'))
                ->value($this->query->toArray()['tour']->name),

            Input::make('code')
                ->type('text')
                ->max(255)
                ->readonly()
                ->required()
                ->title(__('Code'))
                ->placeholder(__('Code'))
                ->value($this->query->toArray()['tour']->code),

            Input::make('id')
                ->type('hidden')
                ->max(255)
                ->required()
                ->value($this->query->toArray()['tour']->id),

            TextArea::make('preview_text')
                ->title('Preview text')
                ->required()
                ->rows(3)
                ->lang('en')
                ->value($this->query->toArray()['tour']->preview_text),

            Quill::make('description')
                ->required()
                ->title('Description')
                ->lang('en')
                ->value($this->query->toArray()['tour']->description),

            Upload::make('preview_photo')
                ->value(json_decode($this->query->toArray()['tour']->preview_photo))
                ->title(__('Preview Photo'))
                ->maxFiles(1),

            Upload::make('detail_photo')
                ->value(json_decode($this->query->toArray()['tour']->detail_photo))
                ->title(__('Detail Photo'))
                ->maxFiles(1),

            Upload::make('image')
                ->value(static::getImagesIds($this->query->toArray()['tour']->image))
                ->required()
                ->title(__('Image gallery'))
                ->maxFiles(10),

            Select::make('type_tour')
                ->required()
                ->options($this->query->toArray()['tour_type'])
                ->title(__('Tour type'))
                ->value($this->query->toArray()['tour']->type_tour)
                ->help('Tour type'),

            /*Input::make('name_fr')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name French'))
                ->placeholder(__('Name French'))
                ->value($this->query->toArray()['tour']->name_fr),


            Input::make('name_es')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name Spanish'))
                ->placeholder(__('Name Spanish'))
                ->value($this->query->toArray()['tour']->name_es),*/

            Input::make('price')
                ->type('number')
                ->required()
                ->autocomplete(false)
                ->title(__('Price'))
                ->placeholder(__('Price'))
                ->value($this->query->toArray()['tour']->price),

            Input::make('person_count')
                ->type('number')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Person count'))
                ->placeholder(__('Person count'))
                ->value($this->query->toArray()['tour']->person_count),

            Input::make('duration_of_the_tour')
                ->type('number')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Duration of the tour'))
                ->placeholder(__('Duration of the tour'))
                ->value($this->query->toArray()['tour']->duration_of_the_tour),

            Input::make('road')
                ->type('text')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Road'))
                ->placeholder(__('Road'))
                ->value($this->query->toArray()['tour']->road),

            /*Input::make('label_color')
                ->required()
                ->type('color')
                ->value($this->query->toArray()['tour']->label_color)
                ->title(__('Label Color')),*/


            Select::make('time_slot')
                ->required()
                ->multiple()
                ->options($this->query->toArray()['all_timeslots'])
                ->value(array_map(fn ($e) => intval($e), explode(',', $this->query->toArray()['tour']->time_slot)))
                ->title(__('Time slot'))
                ->help('Time slot'),

            Select::make('type_road_tour')
                ->required()
                ->options($this->query->toArray()['type_road_tour'])
                ->value($this->query->toArray()['tour']->type_road_tour)
                ->title(__('Type road tour'))
                ->help('Type road tour'),

            Upload::make('map_file')
                ->value(json_decode($this->query->toArray()['tour']->map_file))
                ->acceptedFiles('.kml')
                ->title(__('Map'))
                ->maxFiles(1),

            /*TextArea::make('preview_text_fr')
                ->title('Preview text French')
                ->lang('fr')
                ->rows(3)
                ->value($this->query->toArray()['tour']->preview_text_fr),

            TextArea::make('preview_text_es')
                ->title('Preview text Spanish')
                ->lang('es')
                ->rows(3)
                ->value($this->query->toArray()['tour']->preview_text_es),*/

            /*Quill::make('description_fr')
                ->title('Description French')
                ->lang('fr')
                ->value($this->query->toArray()['tour']->description_fr),

            Quill::make('description_es')
                ->title('Description Spanish')
                ->lang('es')
                ->value($this->query->toArray()['tour']->description_es),*/

            Input::make('sort')
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->required()
                ->value($this->query->toArray()['tour']->sort ?? 500),
        ];
    }
}
