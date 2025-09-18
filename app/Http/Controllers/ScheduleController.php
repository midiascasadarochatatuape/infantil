<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now()->startOfDay();

        // Primeiro, pegamos todas as datas em que o usuário está escalado
        $userDates = Schedule::where('user_id', $user->id)
            ->whereDate('schedule_date', '>=', $today)
            ->pluck('schedule_date');

        // Depois, buscamos todas as escalas dessas datas
        $schedules = Schedule::with('user')
            ->whereIn('schedule_date', $userDates)
            ->orderBy('schedule_date')
            ->get();

        $groupedSchedules = $schedules->groupBy('schedule_date');
        $canManageSchedules = $user->isAdmin();

        $positions = [
            'prof_0_4'    => 'Prof. 0-4 anos',
            'aux_0_4'     => 'Aux. 0-4 anos',
            'prof_5_8'    => 'Prof. 5-8 anos',
            'aux_5_8'     => 'Aux. 5-8 anos',
            'prof_junior' => 'Prof. Juniores',
            'aux_junior'  => 'Aux. Juniores'
        ];

        return view('schedules.index', compact('groupedSchedules', 'canManageSchedules', 'positions', 'user'));
    }

    public function create()
    {
        $positions = [
            'prof_0_4'    => 'Prof. 0-4 anos',
            'aux_0_4'     => 'Aux. 0-4 anos',
            'prof_5_8'    => 'Prof. 5-8 anos',
            'aux_5_8'     => 'Aux. 5-8 anos',
            'prof_junior' => 'Prof. Juniores',
            'aux_junior'  => 'Aux. Juniores'
        ];

        return view('schedules.create', compact('positions'));
    }

    public function getAvailableUsers(Request $request)
    {
        \Log::info('Getting available users for date: ' . $request->get('date')); // Debug log

        $date = $request->get('date');

        if (!$date) {
            return response()->json([]);
        }

        try {
            $users = User::whereDoesntHave('blockedDates', function($query) use ($date) {
                    $query->whereDate('blocked_date', $date);
                })
                ->whereDoesntHave('schedules', function($query) use ($date) {
                    $query->whereDate('schedule_date', $date);
                })
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            \Log::info('Available users found: ' . $users->count()); // Debug log

            return response()->json($users);
        } catch (\Exception $e) {
            \Log::error('Error getting available users: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching available users'], 500);
        }
    }

    public function store(Request $request)
    {
        // Debug incoming request data
        \Log::info('Incoming schedule data:', $request->all());

        $validated = $request->validate([
            'schedule_date' => 'required|date',
            'assignments' => 'required|array',
            'assignments.*' => [
                'nullable', // Changed from 'required' to 'nullable'
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($value)) return; // Skip validation for empty values

                    $date = $request->schedule_date;
                    $hasBlockedDate = BlockedDate::where('user_id', $value)
                        ->whereDate('blocked_date', $date)
                        ->exists();

                    if ($hasBlockedDate) {
                        $fail('This user has blocked this date.');
                    }

                    $hasSchedule = Schedule::where('user_id', $value)
                        ->whereDate('schedule_date', $date)
                        ->exists();

                    if ($hasSchedule) {
                        $fail('This user is already scheduled for this date.');
                    }
                }
            ],
            'notes' => 'nullable|string'
        ]);

        \Log::info('Validated data:', $validated);

        try {
            foreach ($validated['assignments'] as $position => $userId) {
                if (!empty($userId)) {
                    $schedule = Schedule::create([
                        'user_id' => $userId,
                        'schedule_date' => $validated['schedule_date'],
                        'position' => $position,
                        'notes' => $validated['notes'] ?? null
                    ]);
                    \Log::info('Created schedule:', $schedule->toArray());
                }
            }

            return redirect()->route('schedules.index')
                ->with('success', 'Schedules created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating schedule:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create schedule: ' . $e->getMessage()]);
        }
    }

    public function edit(Schedule $schedule)
    {
        $positions = [
            'prof_0_4'    => 'Prof. 0-4 anos',
            'aux_0_4'     => 'Aux. 0-4 anos',
            'prof_5_8'    => 'Prof. 5-8 anos',
            'aux_5_8'     => 'Aux. 5-8 anos',
            'prof_junior' => 'Prof. Juniores',
            'aux_junior'  => 'Aux. Juniores'
        ];

        $users = User::where(function($query) use ($schedule) {
                $query->whereDoesntHave('blockedDates', function($q) use ($schedule) {
                    $q->whereDate('blocked_date', $schedule->schedule_date);
                })
                ->whereDoesntHave('schedules', function($q) use ($schedule) {
                    $q->whereDate('schedule_date', $schedule->schedule_date)
                        ->where('id', '!=', $schedule->id);
                })
                ->orWhere('id', $schedule->user_id);
            })
            ->get();

        return view('schedules.edit', compact('schedule', 'positions', 'users'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request, $schedule) {
                    $hasBlockedDate = BlockedDate::where('user_id', $value)
                        ->whereDate('blocked_date', $schedule->schedule_date)
                        ->exists();

                    if ($hasBlockedDate) {
                        $fail('This user has blocked this date.');
                    }

                    $hasSchedule = Schedule::where('user_id', $value)
                        ->where('id', '!=', $schedule->id)
                        ->whereDate('schedule_date', $schedule->schedule_date)
                        ->exists();

                    if ($hasSchedule) {
                        $fail('This user is already scheduled for this date.');
                    }
                }
            ],
            'notes' => 'nullable|string'
        ]);

        $schedule->update([
            'user_id' => $validated['user_id'],
            'notes' => $validated['notes']
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    public function destroyDate($date)
    {
        Schedule::whereDate('schedule_date', $date)->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Escala excluída com sucesso.');
    }

    public function editDate($date)
    {
        $positions = [
            'prof_0_4'    => 'Prof. 0-4 anos',
            'aux_0_4'     => 'Aux. 0-4 anos',
            'prof_5_8'    => 'Prof. 5-8 anos',
            'aux_5_8'     => 'Aux. 5-8 anos',
            'prof_junior' => 'Prof. Juniores',
            'aux_junior'  => 'Aux. Juniores'
        ];

        $schedules = Schedule::where('schedule_date', $date)
            ->with('user')
            ->get()
            ->keyBy('position');

        $currentAssignments = [];
        foreach ($positions as $key => $position) {
            $currentAssignments[$key] = $schedules->get($key);
        }

        $availableUsers = User::where('role', 'member')
            ->whereDoesntHave('blockedDates', function($query) use ($date) {
                $query->whereDate('blocked_date', $date);
            })
            ->orWhereHas('schedules', function($query) use ($date) {
                $query->whereDate('schedule_date', $date);
            })
            ->orderBy('name')
            ->get();

        $assignedUsers = $schedules->pluck('user_id')->toArray();

        return view('schedules.edit-date', compact(
            'date',
            'positions',
            'currentAssignments',
            'availableUsers',
            'assignedUsers'
        ));
    }

    public function updateDate(Request $request, $date)
    {
        $assignments = $request->input('assignments', []);

        foreach ($assignments as $position => $userId) {
            if (!empty($userId)) {
                Schedule::updateOrCreate(
                    ['schedule_date' => $date, 'position' => $position],
                    ['user_id' => $userId]
                );
            } else {
                Schedule::where('schedule_date', $date)
                       ->where('position', $position)
                       ->delete();
            }
        }

        return redirect()->route('dashboard')
            ->with('success', 'Escala atualizada com sucesso.');
    }
}
