<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountSetupController extends Controller
{
    public function showSetupForm($token){
        $tokenRecord = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenRecord == null || $tokenRecord->created_at < now()->subminutes(1440)) {
            abort(404);
        }
        else {
            $user = User::where('email', $tokenRecord->email)->first();
            return view('account-setup.form',compact('token', 'user'));
        }
        
    }

    public function store(Request $request){
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenRecord = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if ($tokenRecord->created_at < now()->subminutes(1440)) {
            abort(404);
        }
        $token = $request->token;
        DB::table('users')->where('email', $tokenRecord->email)->update(
            ['password' => Hash::make($request->password)
        ]);
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        return redirect()->route('login');
    }
}
