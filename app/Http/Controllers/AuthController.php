<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Tampilkan Form Register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses Login (Bisa Email ATAU Username)
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'login' => 'required', // Inputnya kita namakan 'login' biar netral
            'password' => 'required',
        ]);

        // 2. Cek apakah inputnya Email atau Username?
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Tampung kredensial
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        // 4. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 5. CEK ROLE: Admin atau Siswa?
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Lempar ke Admin
            }

            return redirect()->intended('/dashboard'); // Lempar ke Siswa
        }

        // Kalau Gagal
        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->onlyInput('login');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:50|unique:users|alpha_dash', // Wajib Username
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'student', // Default jadi siswa
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
