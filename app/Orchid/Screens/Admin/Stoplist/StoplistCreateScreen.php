<?php

namespace App\Orchid\Screens\Admin\Stoplist;

use App\Models\MainBanners;
use App\Models\Timeslot;
use App\Models\Tours;
use App\Models\TourTimeslotBlock;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersCreateLayout;
use App\Orchid\Layouts\Admin\Stoplist\StoplistCreateLayout;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotCreateLayout;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class StoplistCreateScreen extends Screen
{
    public function name(): ?string
    {
        return 'Create new Stop list';
    }

    public function query(): array
    {
        return [
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
            StoplistCreateLayout::class
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

            TourTimeslotBlock::create($data);
            Toast::info(__('Timeslot create'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error: ' . $exception->getMessage()));
        }

    }
}
