<?php

namespace App\Orchid\Layouts\Admin\Tours;

use App\Models\BokunImport;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BokunImportListLayout extends Table
{
    protected $target = 'bokun_imports';

    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')->sort()->render(fn (BokunImport $item) => (string) $item->id),
            TD::make('status', __('Status'))->render(fn (BokunImport $item) => view('admin.bokun-import-status', [
                'status' => $item->status,
            ])),
            TD::make('created_count', __('Created'))->render(fn (BokunImport $item) => (string) $item->created_count),
            TD::make('updated_count', __('Updated'))->render(fn (BokunImport $item) => (string) $item->updated_count),
            TD::make('failed_count', __('Failed'))->render(fn (BokunImport $item) => (string) $item->failed_count),
            TD::make('started_at', __('Started'))->render(fn (BokunImport $item) => $item->started_at?->format('Y-m-d H:i:s') ?? '—'),
            TD::make('finished_at', __('Finished'))->render(fn (BokunImport $item) => $item->finished_at?->format('Y-m-d H:i:s') ?? '—'),
            TD::make('errors', __('Error'))->render(function (BokunImport $item) {
                if (!$item->errors) return '—';
                return e(collect($item->errors)->map(fn ($message, $key) => $key . ': ' . $message)->implode('; '));
            }),
        ];
    }
}
