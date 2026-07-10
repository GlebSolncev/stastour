<?php

namespace App\Orchid\Layouts\Admin\Assets;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class AssetsEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Upload::make('about_background')
                ->title(__('Background for about block'))
                ->required()
                ->maxFiles(1)
                ->value($this->query->toArray()['about_background']),
        ];
    }
}
