<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Coba login (Auth::attempt akan otomatis hash password input dan bandingkan dengan DB)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Security: Regenerasi session ID

            // Cek Role untuk Redirect (Mengarahkan user)
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard'); // Nanti kita buat rute ini
            }

            return redirect()->intended('/dashboard'); // Peserta masuk ke halaman utama
        }

        // Jika salah password/username
        return back()->withErrors([
            'username' => 'Maaf, username atau password salah.',
        ])->onlyInput('username');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
