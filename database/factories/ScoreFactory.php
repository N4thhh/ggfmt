<?php

namespace Database\Factories;

use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'panelist_id' => \App\Models\Panelist::inRandomOrder()->first()->id,
            'assignment_id' => \App\Models\Assignment::inRandomOrder()->first()->id,
            'score' => fake()->numberBetween(0, 100),
            'comments' => fake()->paragraph(),
        ];
    }
}
