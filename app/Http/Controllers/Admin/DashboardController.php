<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Siswa (Asumsi role 'student' atau user biasa)
        // Kalau Mas gak punya kolom role, hapus where-nya
        $totalStudents = User::where('role', 'student')->count();

        // 2. Hitung Total Kursus
        $totalCourses = Course::count();

        // 3. Ambil 5 Aktivitas Kuis Terakhir (Siapa yang barusan ngerjain?)
        // Pastikan Model QuizAttempt sudah ada relasi ke 'user' dan 'quiz'
        $recentActivities = QuizAttempt::with(['user', 'quiz'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('totalStudents', 'totalCourses', 'recentActivities'));
    }
}
