<?php

namespace Database\Factories;

use App\Models\Panelist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Panelist>
 */
class PanelistFactory extends Factory
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
            'user_id' => \App\Models\User::factory(['role' => 'panelist']),
        ];
    }
}
