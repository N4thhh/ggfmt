<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\ManagementTrainee;
use App\Models\Coach;
use App\Models\Panelist;
use App\Models\Assignment;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $users = User::all();
      return view('user.index', compact('users'));  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:mt,coach,panelist',

            'index_number' => [
                'required',
                'string',
                'unique:management_trainees,index_number',
                'unique:coaches,index_number',
                'unique:panelists,index_number',
            ],

            'mt_program_id' => 'required_if:role,mt|exists:mt_programs,id',
            'batch' => 'required_if:role,mt|string',
            'major' => 'required_if:role,mt|string',
            'university' => 'required_if:role,mt|string',
            'education_degree' => 'required_if:role,mt|string',
            'mbti' => 'required_if:role,mt|string',
            'placement' => 'required_if:role,mt|string',
            'program_leader' => 'required_if:role,mt|string',
            'assignment_leader' => 'required_if:role,mt|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            match ($validated['role']) {
                'mt' => $this->createManagementTraineeWithAssignments($user, $validated),
                'coach' => Coach::create([
                    'user_id' => $user->id,
                    'index_number' => $validated['index_number'],
                ]),
                'panelist' => Panelist::create([
                    'user_id' => $user->id,
                    'index_number' => $validated['index_number'],
                ]),
            };
        });

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Buat row ManagementTrainee, lalu sekaligus auto-buat 3 assignment
     * (Phase 1/2/3) untuk MT baru ini supaya dashboard-nya langsung terisi.
     */
    private function createManagementTraineeWithAssignments(User $user, array $validated): ManagementTrainee
    {
        $mt = ManagementTrainee::create([
            'user_id' => $user->id,
            'index_number' => $validated['index_number'],
            'mt_program_id' => $validated['mt_program_id'],
            'batch' => $validated['batch'],
            'major' => $validated['major'],
            'university' => $validated['university'],
            'education_degree' => $validated['education_degree'],
            'mbti' => $validated['mbti'],
            'placement' => $validated['placement'],
            'program_leader' => $validated['program_leader'],
            'assignment_leader' => $validated['assignment_leader'],
            'status' => 'active',
        ]);

        foreach (['Phase 1', 'Phase 2', 'Phase 3'] as $phase) {
            Assignment::create([
                'mt_id' => $mt->id,
                'title' => $user->name . ' ' . $phase,
                'phase' => $phase,
            ]);
        }

        return $mt;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Admin users cannot be deleted.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function sendInvite(User $user)
    {
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Log::info("Invite link for {$user->email}: " .url('/setup-account/' . $token));

        return redirect()->route('user.index');
    }

    public function sendInviteAll()
    {
        $users = User::whereNull('password')->get();
        foreach ($users as $user) {
            $token = Str::random(60);
            DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Log::info("Invite link for {$user->email}: " .url('/setup-account/' . $token));
        }
        
        return redirect()->route('user.index');
    }
}