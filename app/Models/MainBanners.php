<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable;

class MainBanners extends Model
{

    protected $table = 'main_banners';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'name_fr',
        'name_es',
        'description',
        'description_fr',
        'description_es',
        'url',
        'button',
        'button_fr',
        'button_es',
        'image',
        'position',
        'sort',
        'active'
    ];

    protected static function getSuffix(): string
    {
        if (in_array(App::getInstance()->currentLocale(), ['fr', 'es'])) {
            return '_' . App::getInstance()->currentLocale();
        }

        return '';
    }

    public static function getLast(int $limit = 10) {
        return static::query()
            ->where('active', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }
}
