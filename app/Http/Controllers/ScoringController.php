<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\PanelistAccess;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class ScoringController extends Controller
{
    public function adminShow(Assignment $assignment)
    {
        $user = Auth::user();
        $panelist = null;
        $existingScore = null;
        $canScore = false;

        if ($user->role === 'panelist') {
            $panelist = $user->panelist;
            if (!$panelist) {
                abort(403);
            }

            $access = PanelistAccess::where('panelist_id', $panelist->id)
                ->where('assignment_id', $assignment->id)
                ->first();

            if (!$access) {
                abort(403);
            }

            $canScore = true;

            $existingScore = Score::where('panelist_id', $panelist->id)
                ->where('assignment_id', $assignment->id)
                ->whereNotNull('submitted_at')
                ->first();

        } elseif (!in_array($user->role, ['admin', 'hr'])) {
            // selain panelist/admin/hr, tidak boleh akses halaman ini
            abort(403);
        }

        // dipakai buat tampilkan rekap semua score (admin/hr/panelist sama-sama bisa lihat)
        $assignment->load('managementTrainee.user', 'score.panelist.user');

        return view('panelist.scoring', compact('assignment', 'panelist', 'existingScore', 'canScore'));
    }

    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'comments' => 'required|string',
        ]);

        $panelist = Auth::user()->panelist;
        if (!$panelist) {
            abort(403);
        }

        $hasAccess = PanelistAccess::where('panelist_id', $panelist->id)
            ->where('assignment_id', $assignment->id)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        Score::updateOrCreate(
            [
                'panelist_id' => $panelist->id,
                'assignment_id' => $assignment->id,
            ],
            [
                'score' => $request->score,
                'comments' => $request->comments,
                'submitted_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Score submitted successfully.');
    }
}