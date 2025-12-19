<?php

use App\Models\User;
use App\Models\JobApplication;
use App\Models\Reminder;
use App\Enums\ReminderType;
use App\Enums\ReminderStatus;
use Illuminate\Support\Facades\Auth;

// Create a user and login
$user = User::first() ?? User::factory()->create();
Auth::login($user);

// Create a job application
$job = JobApplication::factory()->create(['user_id' => $user->id]);

// Create a reminder due 1 minute ago
$reminder = Reminder::create([
    'user_id' => $user->id,
    'job_application_id' => $job->id,
    'type' => ReminderType::MANUAL,
    'status' => ReminderStatus::PENDING,
    'message' => 'Test Notification',
    'scheduled_at' => now()->subMinute(),
]);

echo "Reminder created with ID: " . $reminder->id . "\n";
echo "Scheduled At: " . $reminder->scheduled_at . "\n";
echo "Current Time: " . now() . "\n";

// Run the command
Artisan::call('reminders:send');
echo "Command Output: " . Artisan::output() . "\n";

// Check if notification exists
$notification = $user->notifications()->latest()->first();
if ($notification && $notification->data['reminder_id'] == $reminder->id) {
    echo "SUCCESS: Notification found for reminder.\n";
} else {
    echo "FAILURE: No notification found.\n";
}

