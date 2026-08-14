<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\BasketProperty;
use App\Models\Timeslot;
use App\Models\Tours;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    public function addTour(Request $request)
    {

        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:tours,id'],
            'qty.adults' => ['required', 'integer', 'min:1', 'max:99'],
            'qty.kids' => ['required', 'integer', 'min:0', 'max:99'],
            'info.kids_info' => ['nullable', 'string', 'max:1000'],
            'timeslot.id' => ['required', 'integer', 'exists:timeslot,id'],
            'timeslot.date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $tour = Tours::active()->findOrFail($data['id']);
        abort_if($tour->bokun_id, 422, 'Bokun tours must use Bokun checkout.');

        $basketItemId = \App\Models\BasketItem::addTour(
            $tour,
            $data['timeslot']['id'],
            $data['timeslot']['date'],
            $data['qty']['adults'],
            $data['qty']['kids'],
            $data['info']['kids_info'] ?? ''
        );

        return [
            'done' => true,
            'data' => [
                'id' => $basketItemId
            ]
        ];
    }

    public function addBokunTour(Request $request, \App\Services\Bokun\BokunBookingService $bokun)
    {
        $data = $request->validate([
            'tour_id' => ['required', 'integer'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_time_id' => ['required', 'integer'],
            'pricing' => ['required', 'array', 'min:1'],
            'pricing.*' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $tour = Tours::active()->where('bokun_id', $data['tour_id'])->firstOrFail();
        $passengers = [];
        foreach ($data['pricing'] as $categoryId => $quantity) {
            for ($i = 0; $i < $quantity; $i++) {
                $passengers[] = ['pricingCategoryId' => (int) $categoryId];
            }
        }

        [$quotes] = $bokun->shoppingCart(
            (int) $tour->bokun_id,
            $data['date'],
            [(int) $data['start_time_id']],
            $passengers
        );
        $quote = $quotes[0] ?? [];
        $option = data_get($quote, 'options.0');
        abort_unless($option, 422, 'The selected Bokun slot is no longer available.');

        BasketItem::addBokunTour(
            $tour,
            $data['date'],
            (int) $data['start_time_id'],
            $data['pricing'],
            (float) data_get($option, 'amount', 0),
            (string) data_get($option, 'currency', 'EUR')
        );

        return response()->json(['checkout_url' => url('/checkout/')]);
    }

    public static function getProperties(BasketItem $item): ?array
    {
        $properties = [];
        /** @var BasketProperty $property */
        foreach ($item->properties as $property) {
            $properties[$property->key] = $property->value;
        }

        return $properties;
    }

    public static function getDisplayTourName(string $name, string $timeslotDate, int $timeslotId)
    {
        $prefix = date('j.m.Y', strtotime($timeslotDate));
        /** @var Timeslot $timeslot */
        if($timeslot = Timeslot::find($timeslotId)) {
            $prefix .= ' ('.$timeslot->getDisplayTime().')';
        }
        return $prefix.' - '.$name;
    }

    public static function getTourBasketItem(BasketItem $item): ?object
    {
        if ($tour = Tours::find($item->ext_id)) {

            $properties = static::getProperties($item);

            $timeslot_date = $properties['timeslot_date'];
            $timeslot_id = $properties['timeslot_id'];

            $result = [
                'title' => static::getDisplayTourName($tour->name, $timeslot_date, $timeslot_id),
                'is_tour' => true,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => isset($properties['bokun_total'])
                    ? (float) $properties['bokun_total']
                    : $item->quantity * $item->price,
                'properties' => $properties
            ];

            return (object)$result;
        }

        return null;
    }

    public static function getSessionBasketItems()
    {
        $items = [];
        $has_tour = false;
        $has_shop = false;
        $total = 0;

        $iterator = BasketItem::query()
            ->whereRelation('basket', 'basket.session', '=', \request()->session()->getId())
            ->get();

        foreach ($iterator as $item) {

            if ($item->is_tour && $item = static::getTourBasketItem($item)) {
                $items[] = $item;
                $total += $item->total_price;
                $has_tour = true;
            }
        }

        return (object)[
            'items' => $items,
            'total' => $total,
            'has_tour' => $has_tour,
            'has_shop' => $has_shop
        ];
    }

    public static function checkTourInBasket(): bool
    {
        $basket = static::getSessionBasketItems();
        return $basket->has_tour;
    }

}
