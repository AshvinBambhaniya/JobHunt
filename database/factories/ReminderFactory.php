<?php

namespace Database\Factories;

use App\Enums\ReminderStatus;
use App\Enums\ReminderType;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'job_application_id' => JobApplication::factory(),
            'type' => ReminderType::MANUAL,
            'status' => ReminderStatus::PENDING,
            'message' => $this->faker->sentence,
            'scheduled_at' => now()->addDay(),
        ];
    }
}
