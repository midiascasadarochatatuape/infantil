<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Schedule Calendar') }}</h2>
            <div class="flex space-x-4">
                <button onclick="previousMonth()" class="px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200">&larr;</button>
                <select id="month" class="rounded-md border-gray-300" onchange="updateCalendar()">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <select id="year" class="rounded-md border-gray-300" onchange="updateCalendar()">
                    @foreach(range(now()->year, now()->addYears(2)->year) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button onclick="nextMonth()" class="px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200">&rarr;</button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-lg">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="bg-gray-50 p-2 text-center font-semibold">{{ $day }}</div>
                    @endforeach

                    @foreach($calendar as $date => $data)
                        <div class="bg-white p-2 min-h-[120px] {{ !$data['isCurrentMonth'] ? 'bg-gray-50' : '' }} {{ $date === now()->format('Y-m-d') ? 'ring-2 ring-blue-500' : '' }}"
                             onclick="showDayDetails('{{ $date }}')">
                            <div class="font-medium {{ !$data['isCurrentMonth'] ? 'text-gray-400' : '' }}">
                                {{ Carbon\Carbon::parse($date)->format('j') }}
                            </div>
                            @foreach($data['events'] as $schedule)
                                <div class="mt-1 p-1 text-xs bg-blue-100 rounded truncate">
                                    {{ $schedule->user->name }}
                                </div>
                            @endforeach
                            @foreach($blockedDates->where('blocked_date', $date) as $blockedDate)
                                <div class="mt-1 p-1 text-xs bg-red-100 rounded truncate">
                                    {{ $blockedDate->user->name }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Day Details Modal -->
    <div id="dayDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium" id="modalDate"></h3>
                <button onclick="closeDayDetails()" class="text-gray-400 hover:text-gray-500">&times;</button>
            </div>
            <div id="modalContent"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateCalendar() {
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            window.location.href = `{{ route('calendar.index') }}?month=${month}&year=${year}`;
        }

        function previousMonth() {
            let month = parseInt(document.getElementById('month').value);
            let year = parseInt(document.getElementById('year').value);
            month--;
            if (month < 1) {
                month = 12;
                year--;
            }
            document.getElementById('month').value = month;
            document.getElementById('year').value = year;
            updateCalendar();
        }

        function nextMonth() {
            let month = parseInt(document.getElementById('month').value);
            let year = parseInt(document.getElementById('year').value);
            month++;
            if (month > 12) {
                month = 1;
                year++;
            }
            document.getElementById('month').value = month;
            document.getElementById('year').value = year;
            updateCalendar();
        }

        async function showDayDetails(date) {
            const modal = document.getElementById('dayDetailsModal');
            const modalDate = document.getElementById('modalDate');
            const modalContent = document.getElementById('modalContent');
            
            modalDate.textContent = new Date(date).toLocaleDateString();
            modal.classList.remove('hidden');
            
            const response = await fetch(`{{ route('calendar.events') }}?date=${date}`);
            const data = await response.json();
            
            let content = '<div class="space-y-4">';
            if (data.schedules.length > 0) {
                content += '<div class="font-medium">Schedules:</div>';
                data.schedules.forEach(schedule => {
                    content += `<div class="p-2 bg-blue-50 rounded">${schedule.user.name}</div>`;
                });
            }
            if (data.blockedDates.length > 0) {
                content += '<div class="font-medium mt-4">Blocked:</div>';
                data.blockedDates.forEach(blocked => {
                    content += `<div class="p-2 bg-red-50 rounded">${blocked.user.name}</div>`;
                });
            }
            content += '</div>';
            modalContent.innerHTML = content;
        }

        function closeDayDetails() {
            document.getElementById('dayDetailsModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>