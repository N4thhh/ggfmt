<?php

namespace Database\Factories;

use App\Models\MtStatusLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MtStatusLog>
 */
class MtStatusLogFactory extends Factory
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
            'status' => fake()->randomElement(['failed', 'withdraw', 'graduate']),
            'changed_by' => \App\Models\User::whereIn('role', ['hr', 'admin'])->inRandomOrder()->first()->id,
        ];
    }
}
