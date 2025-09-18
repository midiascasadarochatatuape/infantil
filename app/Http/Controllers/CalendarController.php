<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $schedules = Schedule::with('user')
            ->whereBetween('schedule_date', [$startDate, $endDate])
            ->get()
            ->groupBy(function($schedule) {
                return $schedule->schedule_date->format('Y-m-d');
            });

        $blockedDates = BlockedDate::with('user')
            ->whereBetween('blocked_date', [$startDate, $endDate])
            ->get();

        $calendar = $this->generateCalendarData($startDate, $endDate, $schedules);

        return view('calendar.index', compact('calendar', 'blockedDates', 'month', 'year'));
    }

    private function generateCalendarData($startDate, $endDate, $schedules)
    {
        $calendar = collect();
        $currentDate = $startDate->copy()->startOfWeek();
        $lastDate = $endDate->copy()->endOfWeek();

        while ($currentDate <= $lastDate) {
            $dateString = $currentDate->format('Y-m-d');
            $calendar[$dateString] = [
                'date' => $currentDate->copy(),
                'isCurrentMonth' => $currentDate->month === $startDate->month,
                'events' => $schedules->get($dateString, collect()),
            ];
            $currentDate->addDay();
        }

        return $calendar;
    }

    public function events(Request $request)
    {
        $date = $request->date;
        $user = auth()->user();

        $schedules = Schedule::with('user')
            ->whereDate('schedule_date', $date)
            ->get();

        // Se for admin, retorna todas as datas bloqueadas
        // Se for membro, retorna apenas as próprias datas bloqueadas
        $blockedDates = $user->isAdmin()
            ? BlockedDate::with('user')->whereDate('blocked_date', $date)->get()
            : BlockedDate::with('user')
                ->whereDate('blocked_date', $date)
                ->where('user_id', $user->id)
                ->get();

        return response()->json([
            'schedules' => $schedules,
            'blockedDates' => $blockedDates
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:255',
            'type' => 'required|in:schedule,blocked'
        ]);

        if ($validated['type'] === 'schedule') {
            Schedule::create([
                'user_id' => $validated['user_id'],
                'schedule_date' => $validated['date'],
                'notes' => $validated['notes']
            ]);
        } else {
            BlockedDate::create([
                'user_id' => $validated['user_id'],
                'blocked_date' => $validated['date'],
                'reason' => $validated['notes']
            ]);
        }

        return response()->json(['message' => 'Event created successfully']);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:schedule,blocked',
            'id' => 'required|integer'
        ]);

        if ($validated['type'] === 'schedule') {
            Schedule::findOrFail($validated['id'])->delete();
        } else {
            BlockedDate::findOrFail($validated['id'])->delete();
        }

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function downloadICS()
    {
        $title = 'Evento de Teste';
        $description = 'Este é um evento gerado via Laravel';
        $location = 'Av. Paulista, 1000 - São Paulo, SP';

        // Horário em São Paulo
        $inicio = Carbon::createFromTime(9, 30, 0, 'America/Sao_Paulo');
        $fim = Carbon::createFromTime(12, 30, 0, 'America/Sao_Paulo');

        // Formato UTC para o .ics
        $start = $inicio->setTimezone('UTC')->format('Ymd\THis\Z');
        $end = $fim->setTimezone('UTC')->format('Ymd\THis\Z');

        // Lembrete 1 dia antes
        $alarmTrigger = "-P1D";

        $icsContent = <<<ICS
            BEGIN:VCALENDAR
            VERSION:2.0
            CALSCALE:GREGORIAN
            BEGIN:VEVENT
            SUMMARY:$title
            DESCRIPTION:$description
            LOCATION:$location
            DTSTART:$start
            DTEND:$end
            STATUS:CONFIRMED
            BEGIN:VALARM
            TRIGGER:$alarmTrigger
            ACTION:DISPLAY
            DESCRIPTION:Lembrete do evento: $title
            END:VALARM
            END:VEVENT
            END:VCALENDAR
            ICS;

        return response($icsContent, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="evento.ics"',
        ]);
    }
}
