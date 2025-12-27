<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// --- AREA TAMU ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AREA MEMBER ---
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- GROUP KHUSUS ADMIN ---
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(IsAdmin::class)
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            // CRUD Kursus
            Route::resource('courses', CourseController::class);

            // CRUD Materi (Nested: Create & Store butuh ID Course)
            Route::prefix('courses/{course}')->name('courses.')->group(function () {
                Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
                Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
            });

            // CRUD Materi Spesifik (Edit, Update, Delete - Tidak butuh ID Course di URL)
            // === BAGIAN INI YANG TADI HILANG ===
            Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
            Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        });


    // --- DASHBOARD SISWA ---
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('student.dashboard');
    })->name('student.dashboard');

    // Halaman Belajar Siswa
    Route::get('/learning/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

});
