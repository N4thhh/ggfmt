<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use Illuminate\Support\Facades\Auth;
use App\Models\CoachHistory;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coaches = Coach::all();
        return view('coach.index', compact('coaches'));
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
    public function show(Coach $coach)
    {
        if (Auth::user()->role === 'coach' && Auth::user()->coach->id !== $coach->id) {
        abort(403);
        }
        return view('coach.profile', compact('coach'));
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

    public function searchAjax(\Illuminate\Http\Request $request)
{
    try {
        $query = $request->get('q');
        
        $coaches = \App\Models\Coach::withCount(['coachHistory' => function($q) {
            $q->whereNull('ended_at');
        }])
        ->whereHas('user', function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })
        ->get();

        $formattedCoaches = $coaches->map(function($coach) {
            return [
                'id' => $coach->id,
                'name' => $coach->user->name ?? 'Unknown',
                'mt_count' => $coach->coach_history_count ?? 0,
                'initial' => strtoupper(substr($coach->user->name ?? 'U', 0, 1))
            ];
        });

        return response()->json($formattedCoaches);

    } catch (\Exception $e) {
        return response()->json([
            'pesan_error' => $e->getMessage(),
            'file' => $e->getFile(),
            'baris' => $e->getLine()
        ], 500);
    }
}

public function assignMt(Request $request, Coach $coach)
{
    $request->validate([
        'mt_id' => 'required|exists:management_trainees,id',
    ]);

    CoachHistory::where('mt_id', $request->mt_id)
        ->whereNull('ended_at')
        ->update(['ended_at' => now()]);

    CoachHistory::create([
        'mt_id' => $request->mt_id,
        'coach_id' => $coach->id,
        'assigned_by' => Auth::id(),
    ]);

    return back()->with('success', 'MT berhasil ditugaskan ke coach ini.');
}
}
