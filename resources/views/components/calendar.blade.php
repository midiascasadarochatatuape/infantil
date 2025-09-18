<div class="calendar">
    <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-lg">
        <div class="bg-gray-50 p-2 text-center font-semibold">Sun</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Mon</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Tue</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Wed</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Thu</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Fri</div>
        <div class="bg-gray-50 p-2 text-center font-semibold">Sat</div>

        @foreach ($calendar as $date => $schedules)
            <div class="bg-white p-2 min-h-[100px] {{ $date === today()->format('Y-m-d') ? 'bg-blue-50' : '' }}">
                <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($date)->format('j') }}</div>
                @foreach($schedules as $schedule)
                    <div class="mt-1 p-1 text-xs bg-blue-100 rounded">
                        {{ $schedule->user->name }}
                    </div>
                @endforeach
                @foreach($blockedDates->where('blocked_date', $date) as $blockedDate)
                    <div class="mt-1 p-1 text-xs bg-red-100 rounded">
                        {{ $blockedDate->user->name }} (Blocked)
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>