<?php

namespace App\Http\Controllers\Tour\Calendar;

use App\Http\Controllers\Controller;
use App\Services\Bokun\BokunBookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ShowCalendarController extends Controller
{
    public function __invoke(string $tourId, string $month, Request $request, BokunBookingService $apiService)
    {
        abort_unless(ctype_digit($tourId) && ctype_digit($month), 404);
        $tourId = (int) $tourId;
        $month = (int) $month;
        abort_unless($tourId > 0 && $month >= 1 && $month <= 12, 422, 'Invalid calendar parameters.');

        $year = $request->integer('year', Carbon::now()->year);
        abort_unless($year >= Carbon::now()->year && $year <= Carbon::now()->year + 1, 422, 'Invalid calendar year.');

        $selectedMonth = Carbon::create($year, $month, 1);
        $from = $selectedMonth->startOfMonth()->format('Y-m-d');
        $to = $selectedMonth->endOfMonth()->format('Y-m-d');
        $startTimeLabels = Collection::make($apiService->getTour($tourId)['startTimes'] ?? [])
            ->mapWithKeys(fn (array $startTime) => [
                (int) ($startTime['id'] ?? 0) => trim((string) ($startTime['externalLabel'] ?? '')),
            ])
            ->filter()
            ->all();
        $prices = $apiService->getPrice($tourId, $from, $to);

        $items = [];
        foreach($prices as $price) {
            $pricePerCategoryUnit = Arr::get($price, 'pricesByRate.0.pricePerCategoryUnit');
            $priceCategory = Collection::make($pricePerCategoryUnit)->map(function($item) {
                return [
                    'id' => Arr::get($item, 'id'),
                    'amount' => Arr::get($item, 'amount.amount'),
                    'currency' => Arr::get($item, 'amount.currency')
                ];
            })->unique('id')->values()->toArray();

            $items[$price['date']][] = [
                'startTimeId' => $price['startTimeId'],
                'startTime' => $price['startTime'],
                'externalLabel' => $startTimeLabels[(int) $price['startTimeId']] ?? null,
                'pricesByRate' => $priceCategory

            ];
        }

        return response()->json($items);
    }
}
