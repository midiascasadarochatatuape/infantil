<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Monthly Schedule Stats -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Monthly Schedules ({{ now()->year }})</h3>
                    <div class="space-y-2">
                        @foreach($monthlyStats as $stat)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <span>{{ Carbon\Carbon::create()->month($stat->month)->format('F') }}</span>
                                <span class="font-semibold">{{ $stat->total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Blocked Dates Stats -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-medium">Blocked Dates ({{ now()->year }})</h3>
                    <div class="space-y-2">
                        @foreach($blockedDatesStats as $stat)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <span>{{ Carbon\Carbon::create()->month($stat->month)->format('F') }}</span>
                                <span class="font-semibold">{{ $stat->total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upcoming Schedules -->
                <div class="p-6 bg-white rounded-lg shadow-sm md:col-span-2">
                    <h3 class="mb-4 text-lg font-medium">Upcoming Schedules</h3>
                    @if($upcomingSchedules->count() > 0)
                        <div class="space-y-3">
                            @foreach($upcomingSchedules as $schedule)
                                <div class="p-3 bg-blue-50 rounded">
                                    <div class="font-medium">{{ $schedule->schedule_date->format('F j, Y') }}</div>
                                    <div class="text-sm text-gray-600">{{ $schedule->notes }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No upcoming schedules</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>