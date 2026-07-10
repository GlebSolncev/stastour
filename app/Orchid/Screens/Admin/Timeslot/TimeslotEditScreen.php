<?php

namespace App\Orchid\Screens\Admin\Timeslot;

use App\Models\Timeslot;
use App\Models\Tours;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersEditLayout;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotEditLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\MainBanners;
use Orchid\Support\Facades\Toast;

class TimeslotEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit timeslot';
    }

    public function query($id)
    {
        return [
            'timeslot' => Timeslot::find($id),
            'weekdays' => Timeslot::$display
        ];
    }

    public function layout(): iterable
    {
        return [
            TimeslotEditLayout::class
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
        list($hours, $minutes) = array_map(fn ($e) => intval($e), explode(':', $time));
        return $hours * 60 + $minutes;
    }

    public function convertToModelData($data)
    {
        $result = [
            'begin' => $this->convertTimeToMinutes($data['begin']),
            'end' => $this->convertTimeToMinutes($data['end']),
        ];

        if (isset($data['weekday'])) {
            $weekdays = array_values($data['weekday']);
            foreach(Timeslot::$alias as $wd => $alias)
            {
                $result['wd_'.$alias] = in_array($wd, $weekdays);
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
            $data = $request->all();

            Timeslot::updateOrCreate(
                ['id' => $data['id']],
                $this->convertToModelData($data)
            );

            Toast::info(__('Timeslot update'));

        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
