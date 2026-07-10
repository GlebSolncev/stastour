<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Toast;

class Timeslot extends Model
{
    use HasFactory;

    protected $table = 'timeslot';

    protected $primaryKey = 'id';

    public static $display = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday'
    ];

    public static $alias = [
        1 => 'mon',
        2 => 'tue',
        3 => 'wed',
        4 => 'thu',
        5 => 'fri',
        6 => 'sat',
        7 => 'sun'
    ];

    protected $fillable = [
        'wd_mon',
        'wd_tue',
        'wd_wed',
        'wd_thu',
        'wd_fri',
        'wd_sat',
        'wd_sun',

        'date',

        'begin',
        'end',
    ];

    protected $casts = [
        'wd_mon' => 'bool',
        'wd_tue' => 'bool',
        'wd_wed' => 'bool',
        'wd_thu' => 'bool',
        'wd_fri' => 'bool',
        'wd_sat' => 'bool',
        'wd_sun' => 'bool',

        'date' => 'date:d-m-Y',

        'begin' => 'int',
        'end' => 'int',
    ];

    private function getTimeFormatted(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes - $hours * 60;

        return $hours . ":" . str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }

    public function getBeginFormatted(): string
    {
        return $this->getTimeFormatted($this->begin);
    }

    public function getEndFormatted(): string
    {
        return $this->getTimeFormatted($this->end);
    }

    public function getCheckedWeekdays()
    {
        return array_keys(array_filter(static::$alias, fn($alias) => $this['wd_' . $alias]));
    }

    public function getFormattedDate(): string
    {
        if(isset($this->date)) {
            return Carbon::create($this->date)->format('d-m-Y');
        }

        return '';
    }

    public function getWeekdaysFormatted()
    {
        //echo '<pre>';
        //print_r($this);die;

        if (isset($this['date'])) {
            return 'Specific: '.$this->getFormattedDate();
        }

        $checked = array_keys(array_filter(static::$alias, fn($alias) => $this['wd_' . $alias]));

        if (count($checked) == 7) {
            return 'Every day';
        }

        if (count($checked) == 1) {
            return 'Every ' . static::$display[$checked[0]];
        }

        if ($checked == [1, 2, 3, 4, 5]) {
            return 'Every working day';
        }

        if ($checked == [6, 7]) {
            return 'Every weekends';
        }

        if (count($checked) == 6) {
            $without = array_diff(array_keys(static::$display), $checked);
            return 'Every day without ' . static::$display[array_values($without)[0]];
        }

        return 'Every: ' . implode(", ", array_map(fn($wd) => static::$display[$wd], $checked));
    }

    public function getDisplayName()
    {
        return $this->getWeekdaysFormatted() . ' ('.$this->getDisplayTime().')';
    }

    public function getDisplayTime(): string
    {
        return $this->getBeginFormatted().' - '.$this->getEndFormatted();
    }

    public static function getOptions(): array
    {
        $result = [];
        /** @var Timeslot $timeslot */
        foreach (static::all() as $timeslot) {
            $result[$timeslot->id] = $timeslot->getDisplayName();
        }

        return $result;
    }

}
