<?php

namespace App\Console\Commands;

use App\Enums\ReminderStatus;
use App\Models\Reminder;
use App\Notifications\JobReminderNotification;
use Illuminate\Console\Command;

class SendRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send pending reminders that are due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = Reminder::where('status', ReminderStatus::PENDING)
            ->where('scheduled_at', '<=', now())
            ->with('user')
            ->get();

        $this->info("Found {$reminders->count()} reminders due.");

        foreach ($reminders as $reminder) {
            try {
                $reminder->user->notify(new JobReminderNotification($reminder));

                $reminder->update(['status' => ReminderStatus::SENT]);

                $this->info("Sent reminder ID: {$reminder->id}");
            } catch (\Exception $e) {
                $this->error("Failed to send reminder ID: {$reminder->id}. Error: {$e->getMessage()}");
            }
        }
    }
}
