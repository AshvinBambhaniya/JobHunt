<?php

namespace App\Console\Commands;

use App\Enums\ReminderStatus;
use App\Enums\ReminderType;
use App\Models\JobApplication;
use Illuminate\Console\Command;

class GenerateAutoRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:generate-auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate auto follow-up reminders for old applications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $applications = JobApplication::where('status', 'applied')
            ->where('applied_date', '<=', now()->subDays(7))
            ->get();

        $count = 0;

        foreach ($applications as $app) {
            // Check if auto reminder already exists for this application
            $exists = $app->reminders()
                ->where('type', ReminderType::AUTO_FOLLOW_UP)
                ->exists();

            if ($exists) {
                continue;
            }

            $app->reminders()->create([
                'user_id' => $app->user_id,
                'type' => ReminderType::AUTO_FOLLOW_UP,
                'status' => ReminderStatus::PENDING,
                'message' => "It's been 7 days since you applied to {$app->company_name} for {$app->role}. Time to follow up?",
                'scheduled_at' => now(), // Trigger immediately when this runs
            ]);

            $count++;
        }

        $this->info("Generated {$count} auto-reminders.");
    }
}
