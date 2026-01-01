<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            // PENTING: URL ini harus SAMA PERSIS dengan di Google Console
            ->redirectUrl('http://127.0.0.1:8000/auth/google/callback')
            ->stateless() // PENTING: Matikan cek session biar gak error di localhost
            ->redirect();
    }

    // 2. Terima Balikan dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                // PENTING: URL ini harus SAMA PERSIS juga disini
                ->redirectUrl('http://127.0.0.1:8000/auth/google/callback')
                ->stateless() // PENTING: Matikan cek session disini juga
                ->user();

            // --- LOGIKA LOGIN / REGISTER OTOMATIS ---

            // A. Cek apakah Google ID ini sudah terdaftar?
            $user = User::where('google_id', $googleUser->id)->first();
            if ($user) {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }

            // B. Cek apakah Email sudah terdaftar (tapi belum connect Google)?
            $existingUser = User::where('email', $googleUser->email)->first();
            if ($existingUser) {
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar
                ]);
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }

            // C. Jika belum ada sama sekali -> BUAT USER BARU (Register Otomatis)
            $newUser = User::create([
                'name' => $googleUser->name,
                // Bikin username unik dari nama + angka acak
                'username' => strtolower(str_replace(' ', '', $googleUser->name)) . rand(100, 999),
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(Str::random(16)), // Password acak aman
                'role' => 'student'
            ]);

            Auth::login($newUser);
            return redirect('/dashboard');

        } catch (\Exception $e) {
            // Jika error, tampilkan pesan biar kita tahu salahnya dimana
            dd("Gagal Login Google: " . $e->getMessage());
        }
    }
}
