<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourTimeslotBlock extends Model
{
    protected $table = 'tour_timeslot_block';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tour_id',
        'block_date'
    ];

    protected $casts = [
        'tour_id' => 'int',
        'block_date' => 'date:d-m-Y',
    ];

    public function getTourName()
    {
        if($this->tour_id === -1) {
            return 'All tours';
        }

        return Tours::find($this->tour_id)->name;
    }
}
