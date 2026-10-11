<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panelist;
use App\Models\PanelistAccess;
use Illuminate\Support\Facades\Auth;

class PanelistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panelists = Panelist::all();
        return view('panelist.index', compact('panelists'));
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
    public function show(Panelist $panelist)
    {
        $scoredAssignmentIds = \App\Models\Score::where('panelist_id', $panelist->id)
            ->whereNotNull('submitted_at')
            ->pluck('assignment_id');
    
        $scoredAccess = $panelist->panelistAccess()
            ->whereIn('assignment_id', $scoredAssignmentIds)
            ->get();
    
        $pendingAccess = $panelist->panelistAccess()
            ->whereNotIn('assignment_id', $scoredAssignmentIds)
            ->get();
    
        return view('panelist.profile', compact('panelist', 'scoredAccess', 'pendingAccess'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function searchAjax(Request $request)
{
    try {
        $query = $request->get('q');
        
        $panelists = \App\Models\Panelist::whereHas('user', function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })->get();

        $formattedPanelists = $panelists->map(function($panelist) {
            return [
                'id' => $panelist->id,
                'name' => $panelist->user->name ?? 'Unknown',
                'initial' => strtoupper(substr($panelist->user->name ?? 'U', 0, 1))
            ];
        });

        return response()->json($formattedPanelists);

    } catch (\Exception $e) {
        return response()->json([
            'pesan_error' => $e->getMessage()
        ], 500);
    }
}

public function assignAssignment(Request $request, Panelist $panelist)
{
    $request->validate([
        'assignment_id' => 'required|exists:assignments,id',
    ]);

    $alreadyAssigned = PanelistAccess::where('panelist_id', $panelist->id)
        ->where('assignment_id', $request->assignment_id)
        ->exists();

    if ($alreadyAssigned) {
        return back()->with('error', 'Panelist ini sudah ditugaskan ke assignment tersebut.');
    }

    $currentCount = PanelistAccess::where('assignment_id', $request->assignment_id)->count();
    if ($currentCount >= 3) {
        return back()->with('error', 'Assignment ini sudah punya 3 panelist (maksimal).');
    }

    PanelistAccess::create([
        'panelist_id' => $panelist->id,
        'assignment_id' => $request->assignment_id,
        'assigned_by' => Auth::id(),
    ]);

    return back()->with('success', 'Assignment berhasil ditugaskan ke panelist ini.');
}

public function searchAssignmentAjax(\Illuminate\Http\Request $request)
{
    try {
        $query = $request->get('q');
        
        // Cari assignments berdasarkan nama MT atau Phase
        $assignments = \App\Models\Assignment::with('managementTrainee.user')
            ->whereHas('managementTrainee.user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhere('phase', 'like', "%{$query}%")
            ->get();

        $formattedAssignments = $assignments->map(function($assignment) {
            $mtName = $assignment->managementTrainee->user->name ?? 'Unknown MT';
            return [
                'id' => $assignment->id,
                'mt_name' => $mtName,
                'phase' => $assignment->phase,
                'initial' => strtoupper(substr($mtName, 0, 1))
            ];
        });

        return response()->json($formattedAssignments);

    } catch (\Exception $e) {
        return response()->json([
            'pesan_error' => $e->getMessage()
        ], 500);
    }
}
}
