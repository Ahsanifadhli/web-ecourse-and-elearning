<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Middleware\IsAdmin; // <--- PENTING: Panggil Middleware yang baru dibuat

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// --- GUEST AREA ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- MEMBER AREA ---
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- GROUP KHUSUS ADMIN ---
    Route::prefix('admin')
        ->name('admin.')
        // PERBAIKAN DI SINI: Kita panggil Class Middleware-nya, bukan fungsi
        ->middleware(IsAdmin::class)
        ->group(function () {

            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            Route::resource('courses', CourseController::class);
        });


    // --- DASHBOARD SISWA ---
    Route::get('/dashboard', function () {
        // Redirect Admin ke Dashboard Admin jika salah masuk
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('student.dashboard');
    })->name('student.dashboard');

});
