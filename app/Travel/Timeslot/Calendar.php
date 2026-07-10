<?php

namespace App\Travel\Timeslot;

use App\Models\Order;
use App\Models\Timeslot;
use App\Models\Tours;
use App\Models\TourTimeslotBlock;
use Carbon\Carbon;

class Calendar
{

    private Tours $tour;
    /** @var Timeslot[] */
    private array $timeslots = [];

    public function __construct(Tours $tour)
    {
        $this->tour = $tour;
        $this->prepareTimeslots();
    }

    private function prepareTimeslots(): void
    {
        $iterator = Timeslot::query()
            ->orderBy('begin')
            ->whereIn('id', explode(',', $this->tour->time_slot))->get();
        foreach ($iterator as $timeslot) {
            $this->timeslots[$timeslot->id] = $timeslot;
        }
    }

    public function compileTimeslotTimeslot(Timeslot $timeslot, int $day): bool|int
    {
        return strtotime(date('j.m.Y H:i:s', $day + $timeslot->begin * 60));
    }

    public function checkTimeslot(Timeslot $timeslot, int $day)
    {
        if ($timeslot->date) {
            return Carbon::create($timeslot->date)->getTimestamp() === $day;
        }

        $wd = date('N', $day);
        return $timeslot['wd_' . Timeslot::$alias[$wd]];
    }

    public function calculateForTimestampRange(int $start, int $end, array $excluded): array
    {
        $result = [];
        $iterate = $start;

        while ($iterate <= $end) {
            $day = strtotime(date('j.m.Y', $iterate));

            if(in_array($day, $excluded)) {
                $iterate = strtotime(date('j.m.Y', strtotime('+1 day', $iterate)));
                continue;
            }

            $timeslots_per_day = [];

            foreach ($this->timeslots as $timeslot) {
                if ($this->checkTimeslot($timeslot, $day)) {
                    if ($timestamp = $this->compileTimeslotTimeslot($timeslot, $day)) {

                        if ($iterate < $timestamp) {
                            $timeslots_per_day[$timeslot->id] = $timestamp;
                        }
                    }
                }
            }

            if ($timeslots_per_day) {
                $result[$day] = $timeslots_per_day;
            }

            $iterate = strtotime(date('j.m.Y', strtotime('+1 day', $iterate)));
        }

        return $result;
    }

    protected function getMonthTailTimestamp(int $start): bool|int
    {
        return strtotime(gmdate('t.m.Y 23:59:59', $start));
    }

    protected function fetchExcludedDates(Tours $tour, int $start, int $end)
    {
        $result = [];
        $iterator = TourTimeslotBlock::query()
            ->where(function($query) use ($tour) {
                $query
                    ->where('tour_id', $tour->id)
                    ->orWhere('tour_id', -1);
            })
            ->where('block_date', '>=', date('Y-m-d', $start))
            ->where('block_date', '<=', date('Y-m-d', $end))
            ->get();

        foreach($iterator as $stoplist) {
            $result[] = strtotime($stoplist['block_date']);
        }

        return $result;
    }

    protected function fetchRangeOrders(int $start, int $end): array
    {
        $orders = [];
        $orderIterator = Order::query()
            ->select(['timeslot_date', 'timeslot_id', 'timeslot_count'])
            ->whereDate('timeslot_date', '>=', date('Y-m-d', $start))
            ->whereDate('timeslot_date', '<=', date('Y-m-d', $end))
            ->get();

        foreach ($orderIterator as $order) {
            $date = strtotime($order['timeslot_date']);
            $id = $order['timeslot_id'];

            if (!isset($orders[$date])) {
                $orders[$date] = [];
            }

            if (!isset($orders[$date][$id])) {
                $orders[$date][$id] = 0;
            }

            $orders[$date][$id] += $order['timeslot_count'];
        }

        return $orders;
    }

    protected function fill(int $start): array
    {
        $end = $this->getMonthTailTimestamp($start);

        $bookedMap = $this->fetchRangeOrders($start, $end);
        $excluded = $this->fetchExcludedDates($this->tour, $start, $end);

        $result = [];
        $days = $this->calculateForTimestampRange($start, $end, $excluded);
        $isPrivateTour = $this->tour->type_tour === 'private';

        foreach ($days as $day => $timeslots) {

            foreach ($timeslots as $id => $timestamp) {

                $booked = 0;

                if (isset($bookedMap[$day]) && isset($bookedMap[$day][$id])) {
                    $booked = $bookedMap[$day][$id];
                }

                if ($booked >= $this->tour->person_count) {
                    continue;
                }

                if ($isPrivateTour && $booked) {
                    continue;
                }

                $result[$day][$id] = [
                    'title' => $this->timeslots[$id]->getDisplayTime(),
                    'sort' => $this->timeslots[$id]['begin'],
                    'booked' => $booked
                ];
            }
        }

        return $result;
    }

    public function calculateForMonth(int $month): array
    {
        return $this->fill(strtotime(gmdate('1.' . $month . '.Y')));
    }

    public function calculateForCurrentMonth(): array
    {
        $current = $this->fill(strtotime(gmdate('j.m.Y H:i:s', strtotime('+3 hours'))));

        if (!$current) {
            $current = $this->calculateForMonth(date('m', strtotime('+1 day')));
        }

        return $current;
    }

}
