<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\PanelistAccess;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class ScoringController extends Controller
{
    public function show(Assignment $assignment)
    {
        $panelist = Auth::user()->panelist;
        if (!$panelist) {
            abort(403);
        }
            
        $access = PanelistAccess::where('panelist_id', $panelist->id)
            ->where('assignment_id', $assignment->id)
            ->first();
        if(!$access){
            abort(403);
        }

        $existingScore = Score::where('panelist_id', $panelist->id)
            ->where('assignment_id', $assignment->id)
            ->whereNotNull('submitted_at')
            ->first();
        
        return view('panelist.scoring', compact('assignment', 'panelist', 'existingScore'));
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
