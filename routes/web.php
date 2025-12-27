<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/login'); // Sementara redirect home ke login

// Route untuk Tamu (Guest) - yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk Logout (harus login dulu baru bisa logout)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --- Dashboard Routes (Dilindungi Login) ---
Route::middleware('auth')->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Memanggil file view admin
    })->name('admin.dashboard');

    // Dashboard Siswa (Home page setelah login)
    Route::get('/dashboard', function () {
        return view('student.dashboard'); // Memanggil file view student
    })->name('student.dashboard');

});
