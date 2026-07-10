<?php

namespace App\Orchid\Screens\Admin\Banners\Main;

use App\Models\Tours;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersEditLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\MainBanners;
use Orchid\Support\Facades\Toast;

class MainBannersEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit main banner';
    }

    public function query($id)
    {
        return [
            'banner' => MainBanners::find($id),
            'positions' => [
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center'
            ]
        ];
    }

    public function layout(): iterable
    {
        return [
            MainBannersEditLayout::class
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

            if (isset($data['image'])) {
                $data['image'] = implode(',', $data['image']);
            }

            $fields = $data;
            unset($fields['id']);

            MainBanners::updateOrCreate(
                ['id' => $data['id']],
                $fields
            );

            Toast::info(__('Banner update'));

        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
