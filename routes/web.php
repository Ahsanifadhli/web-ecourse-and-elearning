<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleController;

// Controllers Admin
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SubMaterialController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\StudentController;

// Controllers Student
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;

// Middleware
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes (FINAL & FIXED)
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN DEPAN (PUBLIC) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course/{course:slug}', [HomeController::class, 'courseDetail'])->name('front.course.detail');


// --- 2. AUTHENTICATION (MANUAL & GOOGLE) ---
Route::middleware('guest')->group(function () {
    // Google Login
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    // Manual Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Manual Register
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- 3. FITUR UTAMA SISWA (ENROLL) ---
Route::middleware('auth')->post('/enroll/{course}', function (\App\Models\Course $course) {
    if (!auth()->user()->courses->contains($course->id)) {
        auth()->user()->courses()->attach($course->id);
    }
    return redirect()->route('courses.show', $course->id)->with('success', 'Selamat! Anda berhasil gabung kelas.');
})->name('student.enroll');


// --- 4. AREA MEMBER (SISWA & ADMIN) ---
Route::middleware('auth')->group(function () {

    // --- DASHBOARD SISWA ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');

    // --- HALAMAN BELAJAR (COURSE PLAYER) ---
    // 1. Masuk via Course ID (Default)
    Route::get('/learning/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

    // 2. Masuk via Material ID (Redirect Logic)
    Route::get('/learning/material/{material}', [\App\Http\Controllers\CourseController::class, 'material'])->name('materials.show');

    // Tandai Materi Selesai
    Route::post('/learning/{subMaterial}/complete', [\App\Http\Controllers\Student\CompletionController::class, 'toggle'])->name('student.completions.toggle');

    // --- FITUR TUGAS (SISWA) ---
    Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\Student\SubmissionController::class, 'store'])->name('student.assignments.submit');

    // --- FITUR KUIS (SISWA) ---
    // 1. Ambil Kuis (Halaman Soal)
    Route::get('/quizzes/{quiz}/take', [StudentQuizController::class, 'show'])->name('student.quizzes.take');

    // 2. Kirim Jawaban (INI PERBAIKANNYA)
    // Saya ganti jadi 'student.quizzes.submit' supaya cocok dengan take.blade.php
    Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'store'])->name('student.quizzes.submit');

    // 3. Lihat Hasil & Pembahasan
    Route::get('/quizzes/{quiz}/results', [StudentQuizController::class, 'results'])->name('student.quizzes.results');


    // --- 5. GROUP KHUSUS ADMIN ---
    Route::prefix('admin')->name('admin.')->middleware(IsAdmin::class)->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // A. Resource Controllers (CRUD Utama)
        Route::resource('courses', CourseController::class);

        // Custom Route: Lihat Siswa di Kursus
        Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('courses.students');

        Route::resource('students', StudentController::class)->only(['index', 'destroy']);

        Route::put('/students/{student}/reset-password', [StudentController::class, 'resetPassword'])
    ->name('students.resetPassword');

        // B. Route Spesifik Materi & Sub-Materi
        Route::post('/courses/{course}/materials', [MaterialController::class, 'store'])->name('courses.materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

        Route::get('/materials/{material}/submaterials/create', [SubMaterialController::class, 'create'])->name('materials.submaterials.create');
        Route::post('/materials/{material}/submaterials', [SubMaterialController::class, 'store'])->name('materials.submaterials.store');
        Route::delete('/submaterials/{subMaterial}', [SubMaterialController::class, 'destroy'])->name('submaterials.destroy');

        // C. Route Spesifik Tugas
        Route::get('/materials/{material}/assignments/create', [AssignmentController::class, 'create'])->name('materials.assignments.create');
        Route::post('/materials/{material}/assignments', [AssignmentController::class, 'store'])->name('materials.assignments.store');
        Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
        Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'grade'])->name('submissions.grade');

        // D. Route Spesifik Kuis (ADMIN)
        Route::get('/materials/{material}/quizzes/create', [QuizController::class, 'create'])->name('materials.quizzes.create');
        Route::post('/materials/{material}/quizzes', [QuizController::class, 'store'])->name('materials.quizzes.store');
        Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
        Route::delete('/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');
        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
    });
});
