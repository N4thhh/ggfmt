<?php

namespace Database\Factories;

use App\Models\CoachNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoachNote>
 */
class CoachNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coach_id' => \App\Models\Coach::inRandomOrder()->first()->id,
            'mt_id' => \App\Models\ManagementTrainee::inRandomOrder()->first()->id,
            'comments' => fake()->paragraph(),
        ];
    }
}
