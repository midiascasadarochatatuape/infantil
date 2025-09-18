<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function blockedDates()
    {
        return $this->hasMany(BlockedDate::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
