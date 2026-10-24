<?php

namespace App\Http\Controllers;

use App\Models\ManagementTrainee;
use Illuminate\Http\Request;
use App\Models\CoachHistory;
use App\Models\PanelistAccess;
use App\Models\MtStatusLog;
use App\Models\Assignment;
use App\Models\Panelist;
use App\Models\User;
use App\Models\Coach;
use App\Models\MtProgram;
use Illuminate\Support\Facades\Auth;

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

        $currentHistory = $managementTrainee->coachHistory()
            ->whereNull('ended_at')
            ->first();

        if ($currentHistory && $currentHistory->coach_id === $request->coach_id) {
            return redirect()->route('mt.show', $managementTrainee)->with('success', 'Tidak ada perubahan coach.');
        }

        if ($currentHistory) {
            $currentHistory->update(['ended_at' => now()]);
        }

        CoachHistory::create([
            'mt_id' => $managementTrainee->id,
            'coach_id' => $request->coach_id,
            'assigned_by' => Auth::id(),
        ]);

        return redirect()->route('mt.show', $managementTrainee)->with('success', 'Coach berhasil ditugaskan.');
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
            'panelist_id_1' => 'nullable|exists:panelists,id',
            'panelist_id_2' => 'nullable|exists:panelists,id',
            'panelist_id_3' => 'nullable|exists:panelists,id',
        ]);

        $panelistIds = collect([
            $request->panelist_id_1,
            $request->panelist_id_2,
            $request->panelist_id_3,
        ])->filter()->unique();

        $assignment->panelistAccess()->delete();

        foreach ($panelistIds as $panelistId) {
            PanelistAccess::create([
                'panelist_id' => $panelistId,
                'assignment_id' => $assignment->id,
                'assigned_by' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Panelist berhasil diperbarui.');
    }

    public function searchAjax(Request $request)
    {
        try {
            $query = $request->get('q');

            // Cari MT berdasarkan nama user ATAU index_number
            $mts = \App\Models\ManagementTrainee::whereHas('user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhere('index_number', 'like', "%{$query}%")
            ->get();

            $formattedMts = $mts->map(function($mt) {
                return [
                    'id' => $mt->id,
                    'name' => $mt->user->name ?? 'Unknown',
                    'index_number' => $mt->index_number ?? '-',
                    'initial' => strtoupper(substr($mt->user->name ?? 'M', 0, 1))
                ];
            });

            return response()->json($formattedMts);

        } catch (\Exception $e) {
            return response()->json([
                'pesan_error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ===========================================================
     * Area khusus role "mt" -- halaman dashboard milik diri sendiri
     * ===========================================================
     */

    public function dashboard()
    {
        $managementTrainee = Auth::user()->managementTrainee;

        if (!$managementTrainee) {
            abort(403, 'Data Management Trainee tidak ditemukan untuk akun ini.');
        }

        $managementTrainee->load(['assignment.score.panelist.user', 'coachNote', 'mtProgram']);

        return view('mt.dashboard', compact('managementTrainee'));
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048',
        ]);

        $managementTrainee = Auth::user()->managementTrainee;
        abort_unless($managementTrainee, 403);

        $path = $request->file('profile_picture')->store('profile-pictures', 'public');

        $managementTrainee->update(['profile_picture' => $path]);

        return redirect()->route('mt.dashboard')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateOwnData(Request $request)
    {
        $validated = $request->validate([
            'major' => 'required|string',
            'university' => 'required|string',
            'education_degree' => 'required|string',
            'mbti' => 'required|string',
        ]);

        $managementTrainee = Auth::user()->managementTrainee;
        abort_unless($managementTrainee, 403);

        $managementTrainee->update($validated);

        return redirect()->route('mt.dashboard')->with('success', 'Data berhasil diperbarui.');
    }

    public function uploadAssignment(Request $request, Assignment $assignment)
    {
        $managementTrainee = Auth::user()->managementTrainee;
        abort_unless($managementTrainee && $assignment->mt_id === $managementTrainee->id, 403);

        if (!$this->isPhaseUnlocked($managementTrainee, $assignment->phase)) {
            return back()->with('error', 'Phase ini belum terbuka.');
        }

        // kalau sudah ada penilaian masuk, dokumen tidak boleh diganti lagi
        if ($assignment->score()->whereNotNull('submitted_at')->exists()) {
            return back()->with('error', 'Assignment ini sudah dinilai, dokumen tidak bisa diubah lagi.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')->store('assignments', 'public');

        $assignment->update([
            'file_path' => $path,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('mt.dashboard')->with('success', 'Assignment berhasil diupload.');
    }

    private function isPhaseUnlocked(ManagementTrainee $managementTrainee, string $phase): bool
    {
        if ($phase === 'Phase 1') {
            return true;
        }

        if ($phase === 'Phase 2') {
            return $this->phaseFullyScored($managementTrainee, 'Phase 1');
        }

        if ($phase === 'Phase 3') {
            return $this->phaseFullyScored($managementTrainee, 'Phase 1')
                && $this->phaseFullyScored($managementTrainee, 'Phase 2');
        }

        return false;
    }

    private function phaseFullyScored(ManagementTrainee $managementTrainee, string $phase): bool
    {
        $assignment = $managementTrainee->assignment->firstWhere('phase', $phase);

        if (!$assignment) {
            return false;
        }

        return $assignment->score()->whereNotNull('submitted_at')->count() >= 3;
    }
}