<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment;

class Assets extends Model
{
    protected $table = 'assets';
    protected $fillable = [
        'code',
        'attach_id',
    ];

    public static function getCollection()
    {
        $result = [];
        foreach (Assets::all() as $asset) {
            if ($file = Attachment::find($asset->attach_id)) {
                $result[$asset->code] = $file->url();
            }
        }

        return (object) $result;
    }

}
