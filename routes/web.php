<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BlockedDateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Root route and auth redirects
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Rest of your authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Basic schedule routes for all authenticated users
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

    // routes/web.php
    Route::get('/download-evento', [App\Http\Controllers\CalendarController::class, 'downloadICS'])->name('download.ics');


    // Admin only routes
    Route::group(['middleware' => 'auth'], function () {
        // User management
        Route::resource('users', UserController::class);

        // Admin schedule routes
        Route::middleware(['auth'])->group(function () {
            Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
            Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
            Route::delete('/schedules/by-date', [ScheduleController::class, 'destroyByDate'])->name('schedules.destroy-by-date');
            Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
            Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
            Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
            Route::get('/schedules/date/{date}/edit', [ScheduleController::class, 'editDate'])->name('schedules.edit-date');
            Route::put('/schedules/date/{date}', [ScheduleController::class, 'updateDate'])->name('schedules.update-date');
            Route::delete('/schedules/date/{date}', [ScheduleController::class, 'destroyDate'])->name('schedules.destroy-date');
        });

        // Blocked dates routes
        Route::resource('blocked-dates', BlockedDateController::class)->only(['index', 'store', 'destroy']);

        // Profile routes
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
                ->name('notifications.mark-as-read');
        });
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

// Move this inside the auth middleware group
Route::get('/available-users', [ScheduleController::class, 'getAvailableUsers'])
    ->name('schedules.available-users');

Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::get('/whatsapp', [WhatsAppController::class, 'index']);
Route::post('/send-whatsapp', [WhatsAppController::class, 'sendNotification']);
Route::get('/send-whatsapps', [WhatsAppController::class, 'sendMessage']);


require __DIR__.'/auth.php';




