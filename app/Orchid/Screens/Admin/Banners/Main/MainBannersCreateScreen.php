<?php

namespace App\Orchid\Screens\Admin\Banners\Main;

use App\Models\MainBanners;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersCreateLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class MainBannersCreateScreen extends Screen
{
    public function name(): ?string
    {
        return 'Create main banner';
    }


    public function query(): array
    {
        return [
            'position' => [
                'left' => 'Left',
                'right' => 'Right',
                'center' => 'Center'
            ]
        ];
    }

    public function layout(): iterable
    {
        return [
            MainBannersCreateLayout::class
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

            //$data['active'] = isset($data['active']) && $data['active'] == 'on';

            MainBanners::create($data);
            Toast::info(__('Main banner create'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error: ' . $exception->getMessage()));
        }

    }
}
