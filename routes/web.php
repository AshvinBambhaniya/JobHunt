<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobApplicationLogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

// GROUP 1: Guests (Not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// GROUP 2: Authenticated Users (Logged in)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Redirect root URL to the dashboard
    Route::get('/', function () {
        return redirect()->route('job-applications.index');
    });

    Route::resource('job-applications', JobApplicationController::class);
    Route::post('/job-applications/{job_application}/logs', [JobApplicationLogController::class, 'store'])->name('job-applications.logs.store');

    // Reminders
    Route::post('/job-applications/{job_application}/reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});
