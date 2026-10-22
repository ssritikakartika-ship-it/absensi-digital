<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // 1. Cek Lockout
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error_lockout', $seconds)->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');

        // 2. Cek Autentikasi
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $user = Auth::user();

            // Pengecekan Akun Siswa (Berdasarkan role atau email siswa/ahmad)
            if ($user->role === 'siswa' || Str::contains($user->email, 'siswa') || $user->email === 'ahmad@gmail.com') {
                return redirect()->route('student.beranda')
                    ->with('success_login', 'Selamat datang!');
            }

            // Jika Admin
            return redirect()->intended('/dashboard')
                ->with('success_login', 'Selamat datang kembali Admin!');
        }

        // 3. Jika Gagal Login
        RateLimiter::hit($throttleKey, 60);
        $retriesLeft = RateLimiter::retriesLeft($throttleKey, 3);

        if ($retriesLeft <= 0) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error_lockout', $seconds)->withInput($request->only('email'));
        }

        return back()
            ->with('error_login', "Email atau password salah! Sisa percobaan: {$retriesLeft}")
            ->withInput($request->only('email'));
    }
}