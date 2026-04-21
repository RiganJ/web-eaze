<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    $request->session()->regenerate(); // 🔐 security

    $user = Auth::user();

    // 🔴 Cek akun aktif
    if (!$user->is_active) {
        Auth::logout();
        return back()->withErrors(['email' => 'Akun tidak aktif']);
    }

    // 🔀 Redirect berdasarkan role
    if ($user->role === 'admin_laundry') {
        return redirect()->route('admin.laundry.dashboard');
    }

    if ($user->role === 'admin_homeclean') {
        return redirect()->route('homecleaning.dashboard');
    }
    if ($user->role === 'admin_detailing') {
        return redirect()->route('detailing.dashboard');
    }
        if ($user->role === 'admin_carwash') {
        return redirect()->route('carwash.dashboard');
    }
            if ($user->role === 'admin_cucianmotor') {
        return redirect()->route('cucianmotor.dashboard');
    }
     if ($user->role === 'admin_karsobed') {
        return redirect()->route('karsobed.dashboard');
    }
    if ($user->role === 'admin_polish') {
        return redirect()->route('polish.dashboard');
    }

    // 🔵 Default (owner / super admin / lainnya)
    return redirect()->route('admin.dashboard');
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
