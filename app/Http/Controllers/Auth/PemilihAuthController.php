<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PemilihAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pemilih.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('pemilih')->attempt($credentials)) {
            $request->session()->regenerate();

            $pemilih = Auth::guard('pemilih')->user();
             // Gunakan method yang sudah diperbaiki
             if ($pemilih->sudah_memilih) {
                return redirect()->route('pemilih.thanks');
            }
            return redirect()->intended('/pemilih/dashboard');
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah.',
        ])->onlyInput('nisn');
    }

    public function logout(Request $request)
    {
        Auth::guard('pemilih')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
