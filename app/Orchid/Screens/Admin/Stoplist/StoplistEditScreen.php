<?php

namespace App\Orchid\Screens\Admin\Stoplist;

use App\Models\Timeslot;
use App\Models\Tours;
use App\Models\TourTimeslotBlock;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersEditLayout;
use App\Orchid\Layouts\Admin\Stoplist\StoplistEditLayout;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotEditLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\MainBanners;
use Orchid\Support\Facades\Toast;

class StoplistEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit Stoplist';
    }

    public function query($id)
    {
        return [
            'stoplist' => TourTimeslotBlock::find($id),
            'tours' => static::getTours()
        ];
    }

    public function getTours(): array
    {
        $result = [-1 => 'All tours'];
        /** @var Tours $timeslot */
        foreach (Tours::all() as $timeslot) {
            $result[$timeslot->id] = $timeslot->name;
        }

        return $result;
    }

    public function layout(): iterable
    {
        return [
            StoplistEditLayout::class
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
            $data['block_date'] = \DateTime::createFromFormat('d-m-Y', $data['block_date']);

            TourTimeslotBlock::updateOrCreate(
                ['id' => $data['id']],
                $data
            );

            Toast::info(__('Stoplist update'));

        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
