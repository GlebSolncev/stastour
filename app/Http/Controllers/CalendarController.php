<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\BasketProperty;
use App\Models\Tours;
use App\Travel\Timeslot\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function month(string $tour, string $month) {

        $calendar = new Calendar(Tours::find($tour));

        if($month == intval(date('m'))) {
            return $calendar->calculateForCurrentMonth();
        } else {
            return $calendar->calculateForMonth(intval($month));
        }
    }
}
