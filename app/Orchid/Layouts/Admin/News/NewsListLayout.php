<?php

namespace App\Orchid\Layouts\Admin\News;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\News;

class NewsListLayout extends Table
{
    protected $target = 'news';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->render(function(News $news) {
                    return $news->name;
                }),

            TD::make('sort', __('Sort'))
                ->render(function(News $news) {
                    return $news->sort;
                }),

            TD::make('is_priority', __('Is priority'))
                ->render(function(News $news) {
                    return $news->is_priority ? 'Yes' : 'No';
                }),

            TD::make('is_big', __('Is big'))
                ->render(function(News $news) {
                    return $news->is_big ? 'Yes' : 'No';
                }),

            TD::make('created_at', __('Created'))
                ->render(function(News $news) {
                    return $news->created_at;
                }),

            TD::make('updated_at', __('Last updated'))
                ->render(function(News $news) {
                    return $news->updated_at;
                }),

            TD::make(__('Action'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (News $news) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('news.edit', $news->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Remove article?'))
                            ->method('remove', [
                                'id' => $news->id,
                            ]),
                    ])),
        ];
    }
}
