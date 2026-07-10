<?php

namespace App\Orchid\Screens\Admin\Assets;

use App\Models\Assets;
use App\Models\News;
use App\Orchid\Layouts\Admin\Assets\AssetsEditLayout;
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
        $result = [];

        foreach (Assets::all() as $asset) {
            $result[$asset->code] = $asset->attach_id;
        }

        return $result;
    }

    public function layout(): iterable
    {
        return [
            AssetsEditLayout::class
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

            //print_r($request->all());die;

            foreach ($request->all() as $key => $value) {
                if ($key === '_token' || !$value) {
                    continue;
                }

                if (Assets::query()->where('code', $key)->first()) {
                    Assets::where('code', $key)->update(['attach_id' => $value[0]]);
                } else {
                    Assets::create([
                        'code' => $key,
                        'attach_id' => $value[0]
                    ]);
                }

            }

            Toast::info(__('Assets update'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
