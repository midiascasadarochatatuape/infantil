<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_date',
        'position',
        'notes'
    ];

    protected $casts = [
        'schedule_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'User not found'
        ]);
    }
}