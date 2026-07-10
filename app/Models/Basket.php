<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Prunable;

class Basket extends Model
{
    use Prunable;

    protected $table = 'basket';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'session',
    ];

    protected $casts = [
        'order' => 'int'
    ];

    public function items() {
        return $this->hasMany(BasketItem::class);
    }

    public function prunable()
    {
        return static::query()
            ->where('session', '=', null)
            ->where('created_at', '<=', now()->subDays(1))
            ->get();
    }

    protected function pruning()
    {
        return $this->items->delete();
    }

    public static function loadBasket(): Basket
    {
        $sessionId = request()->session()->getId();
        /** @var Basket $basket */
        $basket = static::query()->where('session', '=', $sessionId)->first();

        if($basket) {
            return $basket;
        }

        $basket = new Basket([
            'session' => $sessionId
        ]);
        $basket->save();

        return $basket;
    }

    public function deleteExistsTours() {
        $tours = $this->items()->where('is_tour', '=', true)->get();
        foreach ($tours as $tour) {
            $tour->delete();
        }
    }
}
