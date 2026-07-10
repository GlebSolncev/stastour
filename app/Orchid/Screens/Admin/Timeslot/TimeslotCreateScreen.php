<?php

namespace App\Orchid\Screens\Admin\Timeslot;

use App\Models\MainBanners;
use App\Models\Timeslot;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersCreateLayout;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotCreateLayout;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class TimeslotCreateScreen extends Screen
{
    public function name(): ?string
    {
        return 'Create new Timeslot';
    }

    public function getWeekDays(): array
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
    }

    public function query(): array
    {
        return [
            'weekdays' => Timeslot::$display
        ];
    }

    public function layout(): iterable
    {
        return [
            TimeslotCreateLayout::class
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

    public function convertTimeToMinutes(string $time)
    {
        list($hours, $minutes) = array_map(fn($e) => intval($e), explode(':', $time));
        return $hours * 60 + $minutes;
    }

    public function convertToModelData($data)
    {
        $result = [
            'begin' => $this->convertTimeToMinutes($data['begin']),
            'end' => $this->convertTimeToMinutes($data['end']),
        ];

        if (isset($data['weekday'])) {
            foreach ($data['weekday'] as $weekday) {
                if ($alias = Timeslot::$alias[$weekday]) {
                    $result['wd_' . $alias] = true;
                }
            }
        }

        if(isset($data['date'])) {
            $result['date'] = \DateTime::createFromFormat('d-m-Y', $data['date']);
        }

        return $result;
    }

    public function save(Request $request)
    {

        try {
            $data = $this->convertToModelData($request->all());

            Timeslot::create($data);
            Toast::info(__('Timeslot create'));
        } catch (\Throwable $exception) {
            Toast::error(__('Error: ' . $exception->getMessage()));
        }

    }
}
