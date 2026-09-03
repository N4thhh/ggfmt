<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Panelist;
use App\Models\Coach;
use App\Models\ManagementTrainee;
use App\Models\MtStatusLog;
use App\Models\CoachNote;
use App\Models\CoachHistory;
use App\Models\Assignment;
use App\Models\PanelistAccess;
use App\Models\Score;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'hr',
            'email' => 'hr@hr.com',
            'role' => 'hr',
        ]);

        foreach (['LEAP', 'PLDP', 'SADP', 'SCDP'] as $program) {
        \App\Models\MtProgram::create(['name' => $program]);
        }

        Panelist::factory(5)->create();
        Coach::factory(5)->create();
        ManagementTrainee::factory(20)->create();
        MtStatusLog::factory(5)->create();
        CoachNote::factory(5)->create();
        CoachHistory::factory(7)->create();
        Assignment::factory(15)->create();
        PanelistAccess::factory(10)->create();
        Score::factory(10)->create();

    }
}
