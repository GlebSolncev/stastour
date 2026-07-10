<?php

namespace App\Orchid\Screens\Admin\News;

use App\Models\News;
use App\Orchid\Layouts\Admin\News\NewsEditLayout;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class NewsEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit blog';
    }

    public function query($id): array
    {
        return [
            'news' => News::find($id)
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
            $data = $request->all();

            if (isset($data['images'])) {
                $data['image'] = implode(',', $data['images']);
            }

            //$data['is_big'] = isset($data['is_big']) && $data['is_big'] == 'on';
            //$data['is_priority'] = isset($data['is_priority']) && $data['is_priority'] == 'on';
            //$data['active'] = isset($data['active']) && $data['active'] == 'on';

            $data['code'] = Str::slug($data['name'], '-');
            $fields = $data;
            unset($fields['id']);

            News::updateOrCreate(
                ['id' => $data['id']],
                $fields
            );
            Toast::info(__('Article update'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
