<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('nisn', 'password');
        $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginData = User::where('nisn', $credentials['nisn'])->first();
        if (!$loginData) {
            Log::error("User not found: " . $credentials['nisn']);
            return redirect()->back()->withErrors(['error' => 'Username does not exist.']);
        }
        if (!password_verify($credentials['password'], $loginData->password)) {
            return redirect()->back()->withErrors(['error' => 'The provided password is incorrect.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectRole();
        }

        return back()->withErrors([
            'password' => 'Server Error',
        ]);
    }

    public function redirectRole()
    {
        $authUser = Auth::user()->id;
        $user = User::with('roles')->where('id', $authUser)->first();
        if ($user->hasRole('admin')) {
            // dd('youre a admin');
            return redirect()->route('admin.dashboard');
        } else {
            // dd('youre a scanner');
            return redirect()->route('pemilih.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalidates the current session
        $request->session()->regenerateToken(); // Regenerates the CSRF token for the next session
        return redirect()->route('login');
    }

    public function loginPage()
    {
        return view('auth.login');
    }
}
