<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\BlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $monthlyStats = Schedule::where('user_id', $user->id)
            ->whereYear('schedule_date', now()->year)
            ->select(DB::raw('MONTH(schedule_date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();

        $blockedDatesStats = BlockedDate::where('user_id', $user->id)
            ->whereYear('blocked_date', now()->year)
            ->select(DB::raw('MONTH(blocked_date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();

        $upcomingSchedules = Schedule::where('user_id', $user->id)
            ->where('schedule_date', '>=', now())
            ->orderBy('schedule_date')
            ->take(5)
            ->get();

        return view('statistics.index', compact('monthlyStats', 'blockedDatesStats', 'upcomingSchedules'));
    }
}