<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;

class Order extends Model
{

    protected $table = 'order';

    protected $primaryKey = 'id';

    protected $fillable = [

        'delivery_price',
        'timeslot_date',
        'timeslot_id',
        'timeslot_count',
        'is_paid',
        'status',
        'amount',
        'currency',
        'bokun_booking_id',
        'bokun_confirmation_code',
        'bokun_status',
        'bokun_payload',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'paid_at',
        'booking_details',

        'name',
        'phone',
        'email',

        'restrictions',
        'comments',

        'country',
        'address',
        'city',
        'postal_code',
    ];

    protected $casts = [
        'order' => 'int',
        'timeslot_date' => 'date',
        'timeslot_id' => 'int',
        'timeslot_count' => 'int',
        'is_paid' => 'bool',
        'amount' => 'decimal:2',
        'bokun_payload' => 'array',
        'paid_at' => 'datetime',
        'booking_details' => 'array',
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string',

        'restrictions' => 'string',
        'comments' => 'string',

        'country' => 'string',
        'address' => 'string',
        'city' => 'string',
        'postal_code' => 'string',
    ];

    public function getDate()
    {
        $date = [$this->timeslot_date->format('j-m-Y')];

        /** @var Timeslot $timeslot */
        if ($this->timeslot_id && $timeslot = Timeslot::find($this->timeslot_id)) {
            $date[] = '(' . $timeslot->getBeginFormatted() . ' - ' . $timeslot->getEndFormatted() . ')';
        }

        return implode(' ', $date);
    }

    public function getBasketRows()
    {
        $basket = Basket::where('order_id', $this->id)->first();
        $basketItems = BasketItem::where('basket_id', $basket->id)->get();

        $result = [];

        /** @var BasketItem $basketItem */
        foreach ($basketItems as $basketItem) {
            $name = 'Item: ';
            $properties = [];
            if ($basketItem->is_tour) {
                $name = 'Tour: ';
                if ($tour = Tours::find(['id' => $basketItem->ext_id])->first()) {
                    $name .= $tour->name;
                } else {
                    $name .= '[deleted tour]';
                }
            }

            $props = BasketProperty::where(['basket_item_id' => $basketItem->id])->get();
            foreach ($props as $prop) {
                if (!str_starts_with($prop->key, 'timeslot')) {
                    $properties[] = $prop->key . ': ' . $prop->value;
                }
            }

            if (count($properties)) {
                $name .= ' (' . implode(", ", $properties) . ')';
            }

            $result[] = $name;
        }

        return implode("<br>", $result);
    }
}
