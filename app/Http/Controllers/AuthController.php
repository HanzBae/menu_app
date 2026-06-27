<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login owner.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login owner.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Pastikan yang login memang owner. Kalau bukan, tolak & logout lagi.
        if (Auth::user()->role !== 'owner') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Akun ini tidak memiliki akses sebagai owner.']);
        }

        return redirect()->intended(route('owner.dashboard'))->with('success', 'Selamat datang kembali!');
    }

    /**
     * Logout owner.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('menu.index')->with('success', 'Berhasil logout.');
    }
}
