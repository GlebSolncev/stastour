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

        $id = $request->get('id');
        $qty = $request->get('qty');
        $info = $request->get('info');
        $timeslot = $request->get('timeslot');

        $basketItemId = \App\Models\BasketItem::addTour(
            \App\Models\Tours::find($id),
            $timeslot['id'],
            $timeslot['date'],
            $qty['adults'],
            $qty['kids'],
            $info['kids_info']
        );

        return [
            'done' => true,
            'data' => [
                'id' => $basketItemId
            ]
        ];
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
                'total_price' => $item->quantity * $item->price,
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
