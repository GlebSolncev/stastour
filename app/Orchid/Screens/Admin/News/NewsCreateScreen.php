<?php

namespace App\Orchid\Screens\Admin\News;

use App\Orchid\Layouts\Admin\News\NewsCreateLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use App\Models\News;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Str;

class NewsCreateScreen extends Screen
{
    public function name(): ?string
    {
        return 'Article create';
    }

    public function query(): array
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            NewsCreateLayout::class
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
            $data = $request->all();
            if (isset($data['images'])) {
                $data['image'] = implode(',', $data['images']);
            }

            //$data['is_big'] = isset($data['is_big']) && $data['is_big'] == 'on';
            //$data['is_priority'] = isset($data['is_priority']) && $data['is_priority'] == 'on';
            //$data['active'] = isset($data['active']) && $data['active'] == 'on';

            $data['code'] = Str::slug($data['name'], '-');

            News::create($data);

            Toast::info(__('Article create'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error '. $exception->getMessage()));
        }

    }
}
