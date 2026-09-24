<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Panelist;
use App\Models\Coach;
use App\Models\ManagementTrainee;
use App\Models\MtProgram;
use App\Models\MtStatusLog;
use App\Models\CoachNote;
use App\Models\CoachHistory;
use App\Models\Assignment;
use App\Models\PanelistAccess;
use App\Models\Score;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Pinned admin / HR ────────────────────────────────────────────────
        User::factory()->create(['name' => 'Admin', 'email' => 'admin@admin.com', 'role' => 'admin']);
        $hrUser = User::factory()->create(['name' => 'HR Manager', 'email' => 'hr@hr.com', 'role' => 'hr']);

        // ── Programs ─────────────────────────────────────────────────────────
        foreach (['LEAP', 'PLDP', 'SADP', 'SCDP'] as $name) {
            MtProgram::create(['name' => $name]);
        }
        $leap = MtProgram::where('name', 'LEAP')->first();
        $pldp = MtProgram::where('name', 'PLDP')->first();

        // ── Pinned panelist ──────────────────────────────────────────────────
        $panelistUser = User::factory()->create(['name' => 'Panelist', 'email' => 'panelist@panelist.com', 'role' => 'panelist']);
        $pinnedPanelist = Panelist::create(['user_id' => $panelistUser->id, 'index_number' => 'PANELIST001']);

        // ── 4 scenario coaches ───────────────────────────────────────────────
        // coach1 — no MTs ever
        $c1u = User::factory()->create(['name' => 'Ahmad Dahlan', 'email' => 'coach1@test.com', 'role' => 'coach']);
        $coach1 = Coach::create(['user_id' => $c1u->id, 'index_number' => 'C001']);

        // coach2 — current MTs only
        $c2u = User::factory()->create(['name' => 'Budi Kurniawan', 'email' => 'coach2@test.com', 'role' => 'coach']);
        $coach2 = Coach::create(['user_id' => $c2u->id, 'index_number' => 'C002']);

        // coach3 — history MTs only
        $c3u = User::factory()->create(['name' => 'Chandra Wijaya', 'email' => 'coach3@test.com', 'role' => 'coach']);
        $coach3 = Coach::create(['user_id' => $c3u->id, 'index_number' => 'C003']);

        // coach4 — both current and past MTs
        $c4u = User::factory()->create(['name' => 'Dewi Santoso', 'email' => 'coach4@test.com', 'role' => 'coach']);
        $coach4 = Coach::create(['user_id' => $c4u->id, 'index_number' => 'C004']);

        // original pinned coach (for dev login)
        $coachUser = User::factory()->create(['name' => 'Coach', 'email' => 'coach@coach.com', 'role' => 'coach']);
        $pinnedCoach = Coach::create(['user_id' => $coachUser->id, 'index_number' => 'COACH001']);

        // ── MT helper closure ────────────────────────────────────────────────
        $makeMt = function (string $name, string $email, string $status, $program, string $batch = '1') {
            $user = User::factory()->create(['name' => $name, 'email' => $email, 'role' => 'mt']);
            return ManagementTrainee::create([
                'user_id'           => $user->id,
                'mt_program_id'     => $program->id,
                'index_number'      => strtoupper(preg_replace('/[^a-z0-9]/i', '', $email)),
                'status'            => $status,
                'placement'         => 'IT',
                'major'             => 'Informatics',
                'university'        => 'UNILA',
                'education_degree'  => 'S1',
                'mbti'              => 'ISTJ',
                'assignment_leader' => 'Assignment Leader',
                'program_leader'    => 'Program Leader',
                'batch'             => $batch,
            ]);
        };

        // ── 8 scenario MTs ───────────────────────────────────────────────────
        $mt1 = $makeMt('Aditya Pratama',  'mt1@test.com', 'active',   $leap);
        $mt2 = $makeMt('Bagus Saputra',   'mt2@test.com', 'active',   $leap);
        $mt3 = $makeMt('Cynthia Lestari', 'mt3@test.com', 'active',   $pldp);
        $mt4 = $makeMt('Doni Setiawan',   'mt4@test.com', 'withdraw', $leap);
        $mt5 = $makeMt('Eka Putri',       'mt5@test.com', 'failed',   $leap);
        $mt6 = $makeMt('Fahri Ramadhan',  'mt6@test.com', 'graduate', $pldp);
        $mt7 = $makeMt('Gilang Perdana',  'mt7@test.com', 'active',   $leap);
        $mt8 = $makeMt('Hani Hapsari',    'mt8@test.com', 'active',   $leap);

        // original pinned MT (for dev login)
        $mtUser = User::factory()->create(['name' => 'Management Trainee', 'email' => 'mt@mt.com', 'role' => 'mt']);
        ManagementTrainee::create([
            'user_id' => $mtUser->id, 'mt_program_id' => $leap->id,
            'index_number' => 'MT001', 'status' => 'active',
            'placement' => 'IT', 'major' => 'IT', 'university' => 'UNILA',
            'education_degree' => 'S1', 'mbti' => 'ISTJ',
            'assignment_leader' => 'Iqbal M Parabi', 'program_leader' => 'Rahman T', 'batch' => '1',
        ]);

        // ── Coach histories ───────────────────────────────────────────────────
        // coach1: no rows (intentionally empty)

        // coach2: current only (mt2, mt7)
        CoachHistory::create(['mt_id' => $mt2->id, 'coach_id' => $coach2->id, 'assigned_by' => $hrUser->id, 'ended_at' => null]);
        CoachHistory::create(['mt_id' => $mt7->id, 'coach_id' => $coach2->id, 'assigned_by' => $hrUser->id, 'ended_at' => null]);

        // coach3: history only (mt3 past, mt5 past, mt8 past)
        CoachHistory::create(['mt_id' => $mt3->id, 'coach_id' => $coach3->id, 'assigned_by' => $hrUser->id, 'ended_at' => now()->subMonths(3)]);
        CoachHistory::create(['mt_id' => $mt5->id, 'coach_id' => $coach3->id, 'assigned_by' => $hrUser->id, 'ended_at' => now()->subMonths(6)]);
        CoachHistory::create(['mt_id' => $mt8->id, 'coach_id' => $coach3->id, 'assigned_by' => $hrUser->id, 'ended_at' => now()->subMonths(1)]);

        // coach4: current (mt4) + past (mt6)
        CoachHistory::create(['mt_id' => $mt4->id, 'coach_id' => $coach4->id, 'assigned_by' => $hrUser->id, 'ended_at' => null]);
        CoachHistory::create(['mt_id' => $mt6->id, 'coach_id' => $coach4->id, 'assigned_by' => $hrUser->id, 'ended_at' => now()->subMonths(2)]);

        // mt3 coach change: had coach3 (ended), now coach2 (current)
        CoachHistory::create(['mt_id' => $mt3->id, 'coach_id' => $coach2->id, 'assigned_by' => $hrUser->id, 'ended_at' => null]);

        // ── Coach notes ───────────────────────────────────────────────────────
        // mt1: 0 notes
        // mt2: 1 note
        CoachNote::create(['coach_id' => $coach2->id, 'mt_id' => $mt2->id, 'comments' => 'Keep it up']);

        // mt3: 3 notes (2 from coach3, 1 from coach2 after transfer)
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt3->id, 'comments' => 'Promising start']);
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt3->id, 'comments' => 'Good direction']);
        CoachNote::create(['coach_id' => $coach2->id, 'mt_id' => $mt3->id, 'comments' => 'Excellent']);

        // mt4: 0 notes
        // mt5: 2 notes
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt5->id, 'comments' => 'Needs support']);
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt5->id, 'comments' => 'Program ended']);

        // mt6: 1 note
        CoachNote::create(['coach_id' => $coach4->id, 'mt_id' => $mt6->id, 'comments' => 'Completed successfully']);

        // mt7: 0 notes
        // mt8: 3 notes
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt8->id, 'comments' => 'Good start']);
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt8->id, 'comments' => 'Progressing well']);
        CoachNote::create(['coach_id' => $coach3->id, 'mt_id' => $mt8->id, 'comments' => 'Well done']);

        // ── Assignments ───────────────────────────────────────────────────────
        $phases = ['Phase 1', 'Phase 2', 'Phase 3'];

        // mt1: no uploads
        foreach ($phases as $phase) {
            Assignment::create(['mt_id' => $mt1->id, 'phase' => $phase, 'title' => "Aditya $phase", 'file_path' => null, 'uploaded_at' => null]);
        }

        // mt2: Phase 1 uploaded only
        Assignment::create(['mt_id' => $mt2->id, 'phase' => 'Phase 1', 'title' => 'Bagus Phase 1', 'file_path' => 'assignments/mt2_p1.pdf', 'uploaded_at' => now()->subDays(30)]);
        Assignment::create(['mt_id' => $mt2->id, 'phase' => 'Phase 2', 'title' => 'Bagus Phase 2', 'file_path' => null, 'uploaded_at' => null]);
        Assignment::create(['mt_id' => $mt2->id, 'phase' => 'Phase 3', 'title' => 'Bagus Phase 3', 'file_path' => null, 'uploaded_at' => null]);

        // mt3: all uploaded — will be scored
        $mt3p1 = Assignment::create(['mt_id' => $mt3->id, 'phase' => 'Phase 1', 'title' => 'Cynthia Phase 1', 'file_path' => 'assignments/mt3_p1.pdf', 'uploaded_at' => now()->subDays(60)]);
        $mt3p2 = Assignment::create(['mt_id' => $mt3->id, 'phase' => 'Phase 2', 'title' => 'Cynthia Phase 2', 'file_path' => 'assignments/mt3_p2.pdf', 'uploaded_at' => now()->subDays(30)]);
        $mt3p3 = Assignment::create(['mt_id' => $mt3->id, 'phase' => 'Phase 3', 'title' => 'Cynthia Phase 3', 'file_path' => 'assignments/mt3_p3.pdf', 'uploaded_at' => now()->subDays(7)]);

        // mt4: all uploaded, no scores
        Assignment::create(['mt_id' => $mt4->id, 'phase' => 'Phase 1', 'title' => 'Doni Phase 1', 'file_path' => 'assignments/mt4_p1.pdf', 'uploaded_at' => now()->subDays(45)]);
        Assignment::create(['mt_id' => $mt4->id, 'phase' => 'Phase 2', 'title' => 'Doni Phase 2', 'file_path' => 'assignments/mt4_p2.pdf', 'uploaded_at' => now()->subDays(20)]);
        Assignment::create(['mt_id' => $mt4->id, 'phase' => 'Phase 3', 'title' => 'Doni Phase 3', 'file_path' => 'assignments/mt4_p3.pdf', 'uploaded_at' => now()->subDays(5)]);

        // mt5: Phase 1 and 2 uploaded, Phase 3 null
        Assignment::create(['mt_id' => $mt5->id, 'phase' => 'Phase 1', 'title' => 'Eka Phase 1', 'file_path' => 'assignments/mt5_p1.pdf', 'uploaded_at' => now()->subDays(90)]);
        Assignment::create(['mt_id' => $mt5->id, 'phase' => 'Phase 2', 'title' => 'Eka Phase 2', 'file_path' => 'assignments/mt5_p2.pdf', 'uploaded_at' => now()->subDays(60)]);
        Assignment::create(['mt_id' => $mt5->id, 'phase' => 'Phase 3', 'title' => 'Eka Phase 3', 'file_path' => null, 'uploaded_at' => null]);

        // mt6: all uploaded — will be scored
        $mt6p1 = Assignment::create(['mt_id' => $mt6->id, 'phase' => 'Phase 1', 'title' => 'Fahri Phase 1', 'file_path' => 'assignments/mt6_p1.pdf', 'uploaded_at' => now()->subDays(120)]);
        $mt6p2 = Assignment::create(['mt_id' => $mt6->id, 'phase' => 'Phase 2', 'title' => 'Fahri Phase 2', 'file_path' => 'assignments/mt6_p2.pdf', 'uploaded_at' => now()->subDays(90)]);
        $mt6p3 = Assignment::create(['mt_id' => $mt6->id, 'phase' => 'Phase 3', 'title' => 'Fahri Phase 3', 'file_path' => 'assignments/mt6_p3.pdf', 'uploaded_at' => now()->subDays(60)]);

        // mt7: no uploads
        foreach ($phases as $phase) {
            Assignment::create(['mt_id' => $mt7->id, 'phase' => $phase, 'title' => "Gilang $phase", 'file_path' => null, 'uploaded_at' => null]);
        }

        // mt8: all uploaded, no scores
        Assignment::create(['mt_id' => $mt8->id, 'phase' => 'Phase 1', 'title' => 'Hani Phase 1', 'file_path' => 'assignments/mt8_p1.pdf', 'uploaded_at' => now()->subDays(50)]);
        Assignment::create(['mt_id' => $mt8->id, 'phase' => 'Phase 2', 'title' => 'Hani Phase 2', 'file_path' => 'assignments/mt8_p2.pdf', 'uploaded_at' => now()->subDays(25)]);
        Assignment::create(['mt_id' => $mt8->id, 'phase' => 'Phase 3', 'title' => 'Hani Phase 3', 'file_path' => 'assignments/mt8_p3.pdf', 'uploaded_at' => now()->subDays(10)]);

        // ── Panelist access + scores (mt3 and mt6 only) ───────────────────────
        foreach ([$mt3p1, $mt3p2, $mt3p3, $mt6p1, $mt6p2, $mt6p3] as $assignment) {
            PanelistAccess::create([
                'panelist_id'  => $pinnedPanelist->id,
                'assignment_id'=> $assignment->id,
                'assigned_by'  => $hrUser->id,
            ]);
            Score::create([
                'panelist_id'  => $pinnedPanelist->id,
                'assignment_id'=> $assignment->id,
                'score'        => rand(70, 100),
                'comments'     => 'Good work on this assignment.',
                'submitted_at' => now()->subDays(rand(1, 10)),
            ]);
        }

        // ── Random background data ────────────────────────────────────────────
        Panelist::factory(4)->create();
        Coach::factory(4)->create();
        ManagementTrainee::factory(15)->create();
        MtStatusLog::factory(5)->create();
        CoachNote::factory(5)->create();
        CoachHistory::factory(5)->create();

        foreach (ManagementTrainee::all() as $mt) {
            foreach ($phases as $phase) {
                if (!Assignment::where('mt_id', $mt->id)->where('phase', $phase)->exists()) {
                    Assignment::factory()->create(['mt_id' => $mt->id, 'phase' => $phase]);
                }
            }
        }

        PanelistAccess::factory(5)->create();
        Score::factory(5)->create();
    }
}