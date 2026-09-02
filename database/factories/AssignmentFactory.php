<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
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
           'title' => fake()->sentence(),
           'phase' => fake()->randomElement(['Phase 1', 'Phase 2', 'Phase 3']),
           'file_path' => $filePath = fake()->optional()->filePath(),
            'uploaded_at' => $filePath ? fake()->dateTime() : null,
        ];
    }
}
