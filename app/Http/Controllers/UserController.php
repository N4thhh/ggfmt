<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);
        return redirect()->route('user.index');
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
    public function destroy(string $id)
    {
        //
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
