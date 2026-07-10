<?php

namespace App\Orchid\Screens\Admin\Assets;

use App\Models\News;
use App\Orchid\Layouts\Admin\News\NewsEditLayout;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class AssetsEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit assets';
    }

    public function query(): array
    {
        return [
        ];
    }

    public function layout(): iterable
    {
        return [
            NewsEditLayout::class
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save')
        ];
    }

    public function save(Request $request)
    {
        try {

            Toast::info(__('Assets update'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
