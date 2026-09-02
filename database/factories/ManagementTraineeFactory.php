<?php

namespace Database\Factories;

use App\Models\ManagementTrainee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ManagementTrainee>
 */
class ManagementTraineeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(['role' => 'mt']),
            'index_number' => fake()->unique()->randomNumber(8, true),
            'status' => fake()->randomElement(['active', 'withdraw', 'failed', 'graduate']),
            'placement' => fake()->randomElement(['IT', 'Finance', 'Marketing', 'HR', 'Operations']),
            'major' => fake()->randomElement(['IT', 'Finance', 'Marketing', 'HR', 'Operations']),
            'university' => fake()->randomElement(['ITB', 'ITS', 'ITS', 'ITS', 'ITS']),
            'education_degree' => fake()->randomElement(['S1', 'S2', 'S3', 'D3', 'D4', 'D1', 'D2']),
            'mbti' => fake()->randomElement(['INTJ', 'INTP', 'ENTJ', 'ENTP', 'INFJ', 'INFP', 'ENFJ', 'ENFP', 'ISTJ', 'ISFJ', 'ESTJ', 'ESFJ', 'ISTP', 'ISFP', 'ESTP', 'ESFP']),
            'assignment_leader'=> fake()->name(),
            'program_leader'=> fake()->name(),
            'batch' => fake()->randomElement(['1', '2', '3', '4', '5']),
            'mt_program_id' => \App\Models\MtProgram::inRandomOrder()->first()->id,
        ];
    }
}
