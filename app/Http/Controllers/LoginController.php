<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $role = Auth::user()->role;
            
            return match($role) {
                'admin', 'hr' => redirect()->route('mt.index'),
                'coach'       => redirect()->route('coach.show', Auth::user()->coach),
                'panelist'    => redirect()->route('panelist.show', Auth::user()->panelist),
                'mt'          => redirect()->route('mt.show', Auth::user()->managementTrainee),
                default       => redirect()->route('mt.index'),
            };
        } else {
            return back()->withErrors(['email' => 'Wrong email or password. Try again or click "Forgot Password?"']);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
