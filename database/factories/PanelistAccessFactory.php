<?php

namespace Database\Factories;

use App\Models\PanelistAccess;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PanelistAccess>
 */
class PanelistAccessFactory extends Factory
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
            'assigned_by' => \App\Models\User::whereIn('role', ['hr', 'admin'])->inRandomOrder()->first()->id,
        ];
    }
}
