<?php

use App\Enums\ReminderStatus;
use App\Models\JobApplication;
use App\Models\Reminder;
use App\Models\User;
use App\Notifications\JobReminderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('user can create a reminder', function () {
    $user = User::factory()->create();
    $job = JobApplication::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->withSession(['_token' => 'test_token'])
        ->from(route('job-applications.show', $job))
        ->post(route('reminders.store', $job), [
            '_token' => 'test_token',
            'message' => 'Test Reminder',
            'scheduled_at' => now()->addHour()->toDateTimeString(),
        ]);

    $response->assertRedirect(route('job-applications.show', $job));
    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'job_application_id' => $job->id,
        'message' => 'Test Reminder',
        'status' => ReminderStatus::PENDING->value,
    ]);
});

test('command sends due reminders', function () {
    Notification::fake();

    $user = User::factory()->create();
    $reminder = Reminder::factory()->create([
        'user_id' => $user->id,
        'scheduled_at' => now()->subMinute(),
        'status' => ReminderStatus::PENDING,
    ]);

    $this->artisan('reminders:send')
        ->assertExitCode(0);

    Notification::assertSentTo($user, JobReminderNotification::class);

    expect($reminder->fresh()->status)->toBe(ReminderStatus::SENT);
});

test('command generates auto reminders', function () {
    $user = User::factory()->create();
    // Create an old application
    $job = JobApplication::factory()->create([
        'user_id' => $user->id,
        'status' => 'applied',
        'applied_date' => now()->subDays(8),
    ]);

    $this->artisan('reminders:generate-auto')
        ->assertExitCode(0);

    $this->assertDatabaseHas('reminders', [
        'user_id' => $user->id,
        'job_application_id' => $job->id,
        'type' => \App\Enums\ReminderType::AUTO_FOLLOW_UP->value,
    ]);
});
