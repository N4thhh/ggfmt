<?php

namespace Database\Factories;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coach>
 */
class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'index_number' => fake()->unique()->randomNumber(8, true),
            'user_id' => \App\Models\User::factory(['role' => 'coach']),
        ];
    }
}
