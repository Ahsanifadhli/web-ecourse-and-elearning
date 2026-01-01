<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK KARTU (Cards)
        $totalCourses = Course::count();

        $totalStudents = User::where('role', 'student')->count();

        // Menghitung rata-rata nilai dari seluruh tugas yang sudah dinilai
        $averageGrade = Submission::avg('grade') ?? 0; // Jika null, anggap 0

        // Total Siswa Mendaftar (Enrollments)
        // Kita hitung baris di tabel pivot 'course_user'
        $totalEnrollments = DB::table('course_user')->count();

        // 2. DATA UNTUK GRAFIK (Chart)
        // Kita ambil Judul Kursus dan Jumlah Siswanya
        $coursesData = Course::withCount('students')->get(); // Menggunakan withCount untuk hitung relasi students

        $chartLabels = $coursesData->pluck('title'); // Ambil judul kursus
        $chartValues = $coursesData->pluck('students_count'); // Ambil jumlah siswanya

        return view('admin.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'averageGrade',
            'totalEnrollments',
            'chartLabels',
            'chartValues'
        ));
    }
}
