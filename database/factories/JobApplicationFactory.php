<?php

namespace Database\Factories;

use App\Enums\JobType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
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
            'company_name' => $this->faker->company,
            'role' => $this->faker->jobTitle,
            'location' => $this->faker->city,
            'status' => 'applied',
            'job_type' => JobType::Remote,
            'applied_date' => now(),
            'expected_salary' => $this->faker->numberBetween(50000, 150000),
        ];
    }
}
