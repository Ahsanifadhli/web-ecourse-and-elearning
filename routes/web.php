<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SubMaterialController; // <--- JANGAN LUPA INI BARU
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\AssignmentController;

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

            // 1. CRUD Kursus (Induk)
            Route::resource('courses', CourseController::class);

            // 2. CRUD Bab / Materi (Hanya Judul Bab)
            // URL: /admin/courses/{id}/materials
            Route::post('/courses/{course}/materials', [MaterialController::class, 'store'])->name('courses.materials.store');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

            // 3. CRUD Isi Bab / Sub-Materi (Video & PDF)
            // URL: /admin/materials/{id_bab}/submaterials/create
            Route::get('/materials/{material}/submaterials/create', [SubMaterialController::class, 'create'])->name('materials.submaterials.create');
            Route::post('/materials/{material}/submaterials', [SubMaterialController::class, 'store'])->name('materials.submaterials.store');
            Route::delete('/submaterials/{subMaterial}', [SubMaterialController::class, 'destroy'])->name('submaterials.destroy');

            // CRUD TUGAS (ASSIGNMENT)
            Route::get('/materials/{material}/assignments/create', [AssignmentController::class, 'create'])->name('materials.assignments.create');
            Route::post('/materials/{material}/assignments', [AssignmentController::class, 'store'])->name('materials.assignments.store');
            Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
        });

    // --- DASHBOARD SISWA ---
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('student.dashboard');
    })->name('student.dashboard');

    // Halaman Belajar (Nanti kita perbaiki lagi controller siswanya menyesuaikan struktur baru)
    Route::get('/learning/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

    Route::post('/assignments/{assignment}/submit', [App\Http\Controllers\Student\SubmissionController::class, 'store'])
        ->name('student.assignments.submit');

});
