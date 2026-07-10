<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'name_pt',
        'name_es',
        'image',
        'detail_text',
        'detail_text_pt',
        'detail_text_es',
        'preview_text',
        'preview_text_pt',
        'preview_text_es',
        'is_big',
        'is_priority',
        'sort',
        'active',
        'code'
    ];
}
