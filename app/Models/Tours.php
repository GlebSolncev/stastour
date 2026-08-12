<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Toast;

class Tours extends Model
{
    use HasFactory;

    protected $table = 'tours';

    protected $primaryKey = 'id';

    protected $fillable = [
        'bokun_id',
        'name',
        'name_fr',
        'name_es',
        'price',
        'preview_text',
        'preview_text_fr',
        'preview_text_es',
        'code',
        'type_tour',
        'description',
        'description_fr',
        'description_es',
        'image',
        'person_count',
        'duration_of_the_tour',
        'road',
        'time_slot',
        'map_file',
        'preview_photo',
        'detail_photo',
        'type_road_tour',
        'label_color',
        'sort'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($tour) {
            if (!$tour->code) {
                $tour->code = Str::slug($tour->name, '-');
            }

            $searchTourByCode = Tours::where('code', $tour->code)->first();

            if (isset($searchTourByCode->id)) {
                Toast::error(__('Error: a tour with the same name has already been created'));
                return false;
            }
        });

        self::updating(function ($tour) {

            $originalName = $tour->getOriginal('name');
            if ($originalName !== $tour->name) {
                $newCode = Str::slug($tour->name, '-');
                if (!Tours::where('code', $newCode)->first()) {
                    $tour->code = $newCode;
                }
            }
        });
    }

}
