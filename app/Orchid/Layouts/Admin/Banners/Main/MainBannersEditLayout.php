<?php

namespace App\Orchid\Layouts\Admin\Banners\Main;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class MainBannersEditLayout extends Rows
{

    protected static function getImagesIds(?string $stream): array
    {
        return array_filter(explode(',', $stream), fn($entity) => is_numeric($entity));
    }

    protected function fields(): iterable
    {
        return [

            Input::make('id')
                ->type('hidden')
                ->max(255)
                ->required()
                ->value($this->query->toArray()['banner']->id),

            Input::make('name')
                ->type('text')
                ->max(255)
                ->required()
                ->autocomplete(false)
                ->title(__('Name'))
                ->placeholder(__('Name'))
                ->value($this->query->toArray()['banner']->name),

            TextArea::make('description')
                ->title('Description')
                ->rows(3)
                ->value($this->query->toArray()['banner']->description),

            Input::make('button')
                ->title('Button name')
                ->value($this->query->toArray()['banner']->button),

            Input::make('url')
                ->title('Button URL')
                ->value($this->query->toArray()['banner']->url),

            /*Input::make('name_fr')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name French'))
                ->placeholder(__('Name French'))
                ->value($this->query->toArray()['banner']->name_fr),

            Input::make('name_es')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name Spanish'))
                ->placeholder(__('Name Spanish'))
                ->value($this->query->toArray()['banner']->name_es),*/

            Upload::make('image')
                ->title(__('Banner'))
                ->required()
                ->maxFiles(1)
                ->value(static::getImagesIds($this->query->toArray()['banner']->image)),

            Select::make('position')
                ->options($this->query->toArray()['positions'])
                ->value($this->query->toArray()['banner']->position)
                ->title('Text position'),



            /*TextArea::make('description_fr')
                ->title('Description French')
                ->rows(3)
                ->value($this->query->toArray()['banner']->description_fr),

            TextArea::make('description_es')
                ->title('Description Spanish')
                ->rows(3)
                ->value($this->query->toArray()['banner']->description_es),*/

            Input::make('sort')
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->required()
                ->value(500)
                ->value($this->query->toArray()['banner']->sort),

            CheckBox::make('active')
                ->title('Active')
                ->placeholder('Active')
                ->value($this->query->toArray()['banner']->active),
        ];
    }
}
