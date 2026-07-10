<?php

namespace App\Orchid\Layouts\Admin\News;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class NewsCreateLayout extends Rows
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

            /*Input::make('name_pt')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name Portugal'))
                ->placeholder(__('Name Portugal')),

            Input::make('name_es')
                ->type('text')
                ->max(255)
                ->autocomplete(false)
                ->title(__('Name Spanish'))
                ->placeholder(__('Name Spanish')),*/

            Upload::make('images')
                ->title(__('Preview photo'))
                ->acceptedFiles('image/*')
                ->maxFiles(1)
                ->required(),

            Input::make('preview_text')
                ->title('Preview text'),

            /*Input::make('preview_text_pt')
                ->title('Preview text Portugal'),

            Input::make('preview_text_es')
                ->title('Preview text Spanish'),*/

            Quill::make('detail_text')
                ->title('Detail text'),

            /*Quill::make('detail_text_pt')
                ->title('Detail text Portugal')
                ->toolbar(["text", "list", "format", "media"]),

            Quill::make('detail_text_es')
                ->title('Detail text Spanish')
                ->toolbar(["text", "list", "format", "media"]),*/

            CheckBox::make('is_big')
                ->title('Is big')
                ->placeholder('Show big item on news list page')
                ->sendTrueOrFalse(),

            Input::make('sort')
                ->type('number')
                ->autocomplete(false)
                ->title(__('Sort'))
                ->required()
                ->placeholder('Descending order')
                ->value(500),

            CheckBox::make('is_priority')
                ->title('Is Priority item')
                ->placeholder('This element will be shown in the main section of the blog')
                ->sendTrueOrFalse(),

            CheckBox::make('active')
                ->title('Active')
                ->placeholder('Active')
                ->value(1)
                ->sendTrueOrFalse(),
        ];
    }
}
