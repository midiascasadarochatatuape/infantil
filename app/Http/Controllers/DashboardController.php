<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now()->startOfDay();

        $schedules = Schedule::with('user')
            ->whereDate('schedule_date', '>=', $today)
            ->orderBy('schedule_date')
            ->get();

        $groupedSchedules = $schedules->groupBy('schedule_date');
        $canManageSchedules = $user->isAdmin();

        $positions = [
            'prof_0_4'    => 'Prof. 0-4 anos',
            'aux_0_4'     => 'Aux. 0-4 anos',
            'prof_5_8'    => 'Prof. 5-8 anos',
            'aux_5_8'     => 'Aux. 5-8 anos',
            'prof_junior' => 'Prof. Junior',
            'aux_junior'  => 'Aux. Junior'
        ];

        return view('dashboard', compact('groupedSchedules', 'canManageSchedules', 'positions', 'user'));
    }
}
