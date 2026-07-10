<?php

namespace App\Orchid\Layouts\Admin\News;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class NewsEditLayout extends Rows
{
    protected string $target = 'news';

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
                ->value($this->query->toArray()['news']->name),

            Input::make('code')
                ->type('text')
                ->max(255)
                ->required()
                ->readonly()
                ->title(__('Code'))
                ->value($this->query->toArray()['news']->code),

            Input::make('id')
                ->type('hidden')
                ->max(255)
                ->required()
                ->value($this->query->toArray()['news']->id),

            /*Input::make('name_pt')
                ->type('text')
                ->max(255)
                ->title(__('Name Portugal'))
                ->placeholder(__('Name Portugal'))
                ->value($this->query->toArray()['news']->name_pt),

            Input::make('name_es')
                ->type('text')
                ->max(255)
                ->title(__('Name Spanish'))
                ->placeholder(__('Name Spanish'))
                ->value($this->query->toArray()['news']->name_es),*/

            Upload::make('images')
                ->value(static::getImagesIds($this->query->toArray()['news']->image))
                ->title(__('Preview photo'))
                ->acceptedFiles('image/*')
                ->maxFiles(1)
                ->required(),

            Input::make('preview_text')
                ->value($this->query->toArray()['news']->preview_text)
                ->title('Preview text'),

            /*Input::make('preview_text_pt')
                ->value($this->query->toArray()['news']->preview_text_pt)
                ->title('Preview text Portugal'),

            Input::make('preview_text_es')
                ->value($this->query->toArray()['news']->preview_text_es)
                ->title('Preview text Spanish'),*/

            Quill::make('detail_text')
                ->value($this->query->toArray()['news']->detail_text)
                ->title('Detail text'),

            /*Quill::make('detail_text_pt')
                ->value($this->query->toArray()['news']->detail_text_pt)
                ->title('Detail text Portugal')
                ->toolbar(["text", "list", "format", "media"]),

            Quill::make('detail_text_es')
                ->value($this->query->toArray()['news']->detail_text_es)
                ->title('Detail text Spanish')
                ->toolbar(["text", "list", "format", "media"]),*/

            CheckBox::make('is_big')
                ->value($this->query->toArray()['news']->is_big)
                ->title('Is big')
                ->placeholder('Show big item on news list page')
                ->sendTrueOrFalse(),

            Input::make('sort')
                ->value($this->query->toArray()['news']->sort)
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->placeholder('Descending order')
                ->required()
                ->value(500),

            CheckBox::make('is_priority')
                ->value($this->query->toArray()['news']->is_priority)
                ->title('Is Priority item')
                ->placeholder('This element will be shown in the main section of the blog')
                ->sendTrueOrFalse(),

            CheckBox::make('active')
                ->value($this->query->toArray()['news']->active)
                ->title('Active')
                ->placeholder('Active')
                ->sendTrueOrFalse(),
        ];
    }
}
