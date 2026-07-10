<?php

namespace App\Orchid\Screens\Admin\Tours;

use App\Models\Timeslot;
use App\Orchid\Layouts\Admin\Tours\ToursCreateLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use App\Models\Tours;
use Orchid\Support\Facades\Toast;


class ToursCreateScreen extends Screen
{

    public function name(): ?string
    {
        return 'Create tour';
    }

    public function query(): array
    {
        return [
            'all_timeslots' => Timeslot::getOptions(),
            'tour_type' => [
                'private' => 'Private',
                'group' => 'Group'
            ],
            'type_road_tour' => [
                'foot' => 'Foot',
                'car' => 'Car'
            ]
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

    public function layout(): iterable
    {
        return [
            ToursCreateLayout::class
        ];
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();

            if (isset($data['image'])) {
                $data['image'] = implode(',', $data['image']);
            } else {
                Toast::error('Image gallery is required field');
                return;
            }

            if (isset($data['time_slot'])) {
                $data['time_slot'] = implode(',', $data['time_slot']);
            }

            if (isset($data['map_file'])) {
                $data['map_file'] = json_encode($data['map_file']);
            }

            if (isset($data['preview_photo'])) {
                $data['preview_photo'] = json_encode($data['preview_photo']);
            } else {
                Toast::error('Image gallery is required field');
                return;
            }

            if (isset($data['detail_photo'])) {
                $data['detail_photo'] = json_encode($data['detail_photo']);
            } else {
                Toast::error('Image gallery is required field');
                return;
            }

            Tours::create($data);

            Toast::info(__('Tour create'));

        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }

    }
}
