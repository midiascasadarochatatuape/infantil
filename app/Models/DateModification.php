<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateModification extends Model
{
    protected $fillable = ['user_id', 'modified_date', 'action_type', 'read', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
