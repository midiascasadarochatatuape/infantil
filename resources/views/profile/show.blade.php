<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Profile Information -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="mb-4 text-lg font-medium">Profile Information</h3>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required class="block w-full mt-1" />
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required class="block w-full mt-1" />
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                                    <x-text-input id="password" type="password" name="password" class="block w-full mt-1" />
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="block w-full mt-1" />
                                </div>

                                <x-primary-button>Update Profile</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="mb-4 text-lg font-medium">Preferences</h3>
                        <form method="POST" action="{{ route('profile.preferences') }}">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="email_notifications" id="email_notifications" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $user->email_notifications ? 'checked' : '' }}>
                                    <label for="email_notifications" class="ml-2 block text-sm text-gray-900">
                                        Receive email notifications
                                    </label>
                                </div>
                                <div>
                                    <x-input-label for="calendar_view" :value="__('Default Calendar View')" />
                                    <select name="calendar_view" id="calendar_view" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="month" {{ $user->calendar_view === 'month' ? 'selected' : '' }}>Month</option>
                                        <option value="week" {{ $user->calendar_view === 'week' ? 'selected' : '' }}>Week</option>
                                    </select>
                                </div>
                                <x-primary-button>Save Preferences</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>