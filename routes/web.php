<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CourseController; // Admin Course Controller
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SubMaterialController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
// Hapus baris 'use App\Http\Controllers\CourseController;' disini agar tidak error tabrakan nama

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
        ->name('admin.') // Otomatis menambahkan prefix 'admin.' ke semua route di bawah
        ->middleware(IsAdmin::class)
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            // 1. CRUD Kursus (Induk)
            Route::resource('courses', CourseController::class);

            // 2. CRUD Bab / Materi
            Route::post('/courses/{course}/materials', [MaterialController::class, 'store'])->name('courses.materials.store');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

            // 3. CRUD Isi Bab / Sub-Materi
            Route::get('/materials/{material}/submaterials/create', [SubMaterialController::class, 'create'])->name('materials.submaterials.create');
            Route::post('/materials/{material}/submaterials', [SubMaterialController::class, 'store'])->name('materials.submaterials.store');
            Route::delete('/submaterials/{subMaterial}', [SubMaterialController::class, 'destroy'])->name('submaterials.destroy');

            // CRUD TUGAS
            Route::get('/materials/{material}/assignments/create', [AssignmentController::class, 'create'])->name('materials.assignments.create');
            Route::post('/materials/{material}/assignments', [AssignmentController::class, 'store'])->name('materials.assignments.store');
            Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

            // CRUD Kuis
            Route::get('/materials/{material}/quizzes/create', [QuizController::class, 'create'])->name('materials.quizzes.create');
            Route::post('/materials/{material}/quizzes', [QuizController::class, 'store'])->name('materials.quizzes.store');

            Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
            Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

            Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
            Route::delete('/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');

            // Lihat Pengumpulan Tugas
            Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])
                ->name('assignments.submissions');

            // Simpan Nilai
            Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'grade'])
                ->name('submissions.grade');

            // Monitoring Hasil Kuis
            Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])
                ->name('quizzes.results');

            // Kelola Siswa
            Route::resource('students', \App\Http\Controllers\Admin\StudentController::class)
                ->only(['index', 'destroy']);

            // Lihat Peserta Kursus (PERBAIKAN DI SINI)
            // Hapus 'admin.' karena sudah ada di group prefix
            Route::get('/courses/{course}/students', [\App\Http\Controllers\Admin\CourseController::class, 'students'])
                ->name('courses.students');
        });

    // --- DASHBOARD SISWA ---
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('student.dashboard');
    })->name('student.dashboard');

    // Halaman Belajar (Pakai Full Path Namespace biar gak tabrakan sama Admin Controller)
    Route::get('/learning/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

    Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\Student\SubmissionController::class, 'store'])
        ->name('student.assignments.submit');

    Route::get('/quizzes/{quiz}/take', [StudentQuizController::class, 'show'])->name('student.quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'store'])->name('student.quizzes.submit');

});
