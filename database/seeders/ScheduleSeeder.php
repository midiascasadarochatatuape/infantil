<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        
        if ($user) {
            Schedule::create([
                'user_id' => $user->id,
                'schedule_date' => now(),
                'notes' => 'Test schedule'
            ]);
        }
    }
}