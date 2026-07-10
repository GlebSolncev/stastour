<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;

class BasketProperty extends Model
{
    protected $table = 'basket_property';

    protected $primaryKey = 'id';

    protected $fillable = [
        'basket_item_id',
        'key',
        'value',
    ];

    public function basketItem() {
        return $this->belongsTo(BasketItem::class);
    }

}
