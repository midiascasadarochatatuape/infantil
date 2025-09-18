<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateBlockNotification extends Model
{
    protected $fillable = ['blocked_date', 'block_count', 'notified'];

    protected $casts = [
        'blocked_date' => 'date',
        'notified' => 'boolean',
    ];
}