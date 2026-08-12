<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;

class BasketItem extends Model
{
    protected $table = 'basket_item';

    protected $primaryKey = 'id';

    protected $fillable = [
        'basket_id',
        'quantity',
        'price',
        'is_tour',
        'ext_id'
    ];

    protected $casts = [
        'quantity' => 'int',
        'price' => 'float',
        'is_tour' => 'boolean',
        'ext_id' => 'int',
    ];

    public function basket() {
        return $this->belongsTo(Basket::class);
    }

    public function properties() {
        return $this->hasMany(BasketProperty::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($item) {
            $item->properties()->delete();
        });
    }

    protected static function fillTourProperties(int $timeslotId, string $timeslotDate, int $adultQuantity = 1, int $kidQuantity = 0, ?string $kidInfo = null): array
    {
        $properties = [];

        $properties[] = new \App\Models\BasketProperty(['key' => 'timeslot_id', 'value' => $timeslotId]);
        $properties[] = new \App\Models\BasketProperty(['key' => 'timeslot_date', 'value' => $timeslotDate]);

        if($adultQuantity) {
            $properties[] = new \App\Models\BasketProperty(['key' => 'adult', 'value' => $adultQuantity]);
        }
        if($kidQuantity) {
            $properties[] = new \App\Models\BasketProperty(['key' => 'kid', 'value' => $kidQuantity]);
        }
        if($kidInfo) {
            $properties[] = new \App\Models\BasketProperty(['key' => 'kid_info', 'value' => $kidInfo]);
        }

        return $properties;
    }

    public static function addTour(Tours $tour, int $timeslotId, string $timeslotDate, int $adultQuantity = 1, int $kidQuantity = 0, ?string $kidInfo = null): int
    {
        $basket = Basket::loadBasket();
        $basket->deleteExistsTours();

        $item = new BasketItem([
            'basket_id' => $basket->id,
            'ext_id' => $tour->id,
            'is_tour' => true,
            'price' => $tour->price,
            'quantity' => $adultQuantity + $kidQuantity
        ]);

        $item->save();
        if($properties = static::fillTourProperties($timeslotId, $timeslotDate, $adultQuantity, $kidQuantity, $kidInfo)) {
            $item->properties()->saveMany($properties);
        }

        return $item->id;
    }

    public static function addBokunTour(Tours $tour, string $date, int $startTimeId, array $pricing, float $total, string $currency): int
    {
        $basket = Basket::loadBasket();
        $basket->deleteExistsTours();

        $item = static::create([
            'basket_id' => $basket->id,
            'ext_id' => $tour->id,
            'is_tour' => true,
            'price' => $total,
            'quantity' => 1,
        ]);

        $properties = [
            new BasketProperty(['key' => 'timeslot_id', 'value' => $startTimeId]),
            new BasketProperty(['key' => 'timeslot_date', 'value' => $date]),
            new BasketProperty(['key' => 'bokun_id', 'value' => $tour->bokun_id]),
            new BasketProperty(['key' => 'bokun_pricing', 'value' => json_encode($pricing)]),
            new BasketProperty(['key' => 'bokun_total', 'value' => $total]),
            new BasketProperty(['key' => 'bokun_currency', 'value' => $currency]),
        ];
        $item->properties()->saveMany($properties);

        return $item->id;
    }

}
