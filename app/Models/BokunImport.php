<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BokunImport extends Model
{
    protected $fillable = [
        'status', 'created_count', 'updated_count', 'failed_count',
        'errors', 'started_at', 'finished_at', 'requested_by',
    ];

    protected $casts = [
        'errors' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function isActive(): bool
    {
        return in_array($this->status, ['running', 'in_progress'], true);
    }
}
