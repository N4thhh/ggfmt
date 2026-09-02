<?php

namespace Database\Factories;

use App\Models\CoachHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoachHistory>
 */
class CoachHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mt_id' => \App\Models\ManagementTrainee::inRandomOrder()->first()->id,
            'coach_id' => \App\Models\Coach::inRandomOrder()->first()->id,
            'assigned_by' => \App\Models\User::where('role', 'hr')->inRandomOrder()->first()->id,
            'ended_at' => fake()->optional()->dateTime(),
        ];
    }
}
