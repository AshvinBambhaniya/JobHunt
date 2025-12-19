<?php

namespace Database\Factories;

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
            'user_id' => \App\Models\User::factory(),
            'company_name' => fake()->company(),
            'role' => fake()->jobTitle(),
            'location' => fake()->city(),
            'status' => fake()->randomElement(['applied', 'shortlisted', 'interviewed', 'offer', 'rejected']),
            'applied_date' => fake()->date(),
            'notes' => fake()->sentence(),
            'job_type' => fake()->randomElement(\App\Enums\JobType::cases()),
            'expected_salary' => fake()->numberBetween(50000, 150000),
        ];
    }
}
