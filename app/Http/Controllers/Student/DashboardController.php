<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kursus yang diikuti user, beserta materi, tugas, dan kuisnya
        // Kita gunakan 'with' (Eager Loading) untuk menghindari error "on null"
        $myCourses = $user->courses()->with([
            'materials.subMaterials.completions', // Untuk cek materi selesai
            'materials.assignments.submissions',  // Untuk cek tugas dikumpul
            'materials.quizzes.attempts'          // Untuk cek kuis dikerjakan
        ])->get();

        // Hitung Progress untuk setiap kursus
        foreach ($myCourses as $course) {
            $totalItems = 0;
            $completedItems = 0;

            foreach ($course->materials as $material) {
                // 1. Hitung Sub-Materi (Video/PDF)
                foreach ($material->subMaterials as $sub) {
                    $totalItems++;
                    // Cek apakah user sudah menandai selesai
                    if ($sub->completions->contains('user_id', $user->id)) {
                        $completedItems++;
                    }
                }

                // 2. Hitung Tugas (Assignment)
                foreach ($material->assignments as $assignment) {
                    $totalItems++;
                    // Cek apakah user sudah mengumpulkan tugas (Relasi submissions harus ada di Model Assignment)
                    // Kita gunakan optional() atau cek null agar aman
                    if ($assignment->submissions && $assignment->submissions->contains('user_id', $user->id)) {
                        $completedItems++;
                    }
                }

                // 3. Hitung Kuis
                foreach ($material->quizzes as $quiz) {
                    $totalItems++;
                    // Cek apakah user sudah mengerjakan kuis (Relasi attempts harus ada di Model Quiz)
                    if ($quiz->attempts && $quiz->attempts->contains('user_id', $user->id)) {
                        $completedItems++;
                    }
                }
            }

            // Hindari pembagian dengan nol
            if ($totalItems > 0) {
                $progress = round(($completedItems / $totalItems) * 100);
            } else {
                $progress = 0;
            }

            // Simpan data progress sementara ke object course
            $course->progress_percentage = $progress;
            $course->total_items = $totalItems;
            $course->completed_items = $completedItems;
        }

        return view('student.dashboard', compact('myCourses'));
    }
}
