<?php

namespace App\Http\Controllers;

use App\Models\ManagementTrainee;
use Illuminate\Http\Request;

class MtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managementTrainees = ManagementTrainee::all();
        return view('mt.index', compact('managementTrainees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ManagementTrainee $managementTrainee)
    {
        return view('mt.profile', compact('managementTrainee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManagementTrainee $managementTrainee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManagementTrainee $managementTrainee)
    {
        //
    }

        public function updateStatus(Request $request, ManagementTrainee $managementTrainee)
    {
        $request->validate([
            'status' => 'required|in:active,withdraw,failed,graduate',
        ]);

        $managementTrainee->update(['status' => $request->status]);

        MtStatusLog::create([
            'mt_id' => $managementTrainee->id,
            'status' => $request->status,
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function assignCoach(Request $request, ManagementTrainee $managementTrainee)
    {
        $request->validate([
            'coach_id' => 'required|exists:coaches,id',
        ]);

        $managementTrainee->coachHistory()
            ->whereNull('ended_at')
            ->update(['ended_at' => now()]);

        CoachHistory::create([
            'mt_id' => $managementTrainee->id,
            'coach_id' => $request->coach_id,
            'assigned_by' => Auth::id(),
        ]);

        return back()->with('success', 'Coach berhasil ditugaskan.');
    }

    public function update(Request $request, ManagementTrainee $managementTrainee)
    {
        $validated = $request->validate([
            'index_number' => 'required|string|unique:management_trainees,index_number,' . $managementTrainee->id,
            'batch' => 'required|string',
            'mbti' => 'required|string',
            'major' => 'required|string',
            'university' => 'required|string',
            'education_degree' => 'required|string',
            'placement' => 'required|string',
            'program_leader' => 'required|string',
            'assignment_leader' => 'required|string',
            'mt_program_id' => 'required|exists:mt_programs,id',
        ]);

        $managementTrainee->update($validated);

        return back()->with('success', 'Data MT berhasil diperbarui.');
    }

    public function assignPanelist(Request $request, Assignment $assignment)
    {
        $request->validate([
            'panelist_id' => 'required|exists:panelists,id',
        ]);

        PanelistAccess::create([
            'panelist_id' => $request->panelist_id,
            'assignment_id' => $assignment->id,
            'assigned_by' => Auth::id(),
        ]);

        return back()->with('success', 'Panelist berhasil ditugaskan.');
    }

}
