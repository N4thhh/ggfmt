<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm(Request $request){
        if(Auth::check()){    
            $user = Auth::user();
            $role = $user->role;

            if (($role === 'mt' && !$user->managementTrainee) || 
                ($role === 'coach' && !$user->coach) || 
                ($role === 'panelist' && !$user->panelist)) {
                
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->withErrors(['email' => 'Sesi Anda tidak valid karena data profil belum lengkap. Silakan login kembali atau hubungi Admin.']);
            }

            return match($role) {
                'admin', 'hr' => redirect()->route('mt.index'), // Saya sesuaikan dengan route di fungsi login
                'coach'       => redirect()->route('coach.show', $user->coach),
                'panelist'    => redirect()->route('panelist.show', $user->panelist),
                'mt'          => redirect()->route('mt.show', $user->managementTrainee),
                default       => redirect()->route('mt.index'),
            };
        }

        return view('login');
    }

    /**
     * Memproses percobaan login dari user.
     */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $role = $user->role;

            if ($role === 'mt' && !$user->managementTrainee) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun Anda belum memiliki data profil Management Trainee. Silakan hubungi Admin/HR.']);
            }

            if ($role === 'coach' && !$user->coach) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun Anda belum memiliki data profil Coach. Silakan hubungi Admin/HR.']);
            }

            if ($role === 'panelist' && !$user->panelist) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun Anda belum memiliki data profil Panelist. Silakan hubungi Admin/HR.']);
            }

            return match($role) {
                'admin', 'hr' => redirect()->route('mt.index'),
                'coach'       => redirect()->route('coach.show', $user->coach),
                'panelist'    => redirect()->route('panelist.show', $user->panelist),
                'mt'          => redirect()->route('mt.show', $user->managementTrainee),
                default       => redirect()->route('mt.index'),
            };
        } else {
            return back()->withErrors(['email' => 'Wrong email or password. Try again or click "Forgot Password?"']);
        }
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}