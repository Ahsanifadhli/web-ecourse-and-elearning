<?php

namespace App\Http\Controllers\Student; // Pastikan namespace ini sesuai folder (misal: App\Http\Controllers\Student)

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- WAJIB ADA INI

class CourseController extends Controller
{
    public function show(Course $course, Request $request)
    {
        // -----------------------------------------------------------
        // 1. LOGIC AUTO-ENROLL (Pencatatan Peserta Otomatis)
        // -----------------------------------------------------------
        // Cek apakah user sudah terdaftar? Jika belum, attach.
        if (!Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            Auth::user()->courses()->attach($course->id);
        }

        // -----------------------------------------------------------
        // 2. LOAD DATA MATERI
        // -----------------------------------------------------------
        // Load relationship agar query ringan
        $course->load(['materials.subMaterials', 'materials.assignments', 'materials.quizzes.questions']);

        // -----------------------------------------------------------
        // 3. FLAT CONTENT (Menggabungkan semua isi jadi satu garis lurus)
        // -----------------------------------------------------------
        $allContents = collect();

        foreach ($course->materials as $material) {

            // A. Masukkan Video/PDF
            foreach ($material->subMaterials as $sub) {
                $sub->content_type = 'material';
                $allContents->push($sub);
            }

            // B. Masukkan Tugas
            foreach ($material->assignments as $assign) {
                $assign->content_type = 'assignment';
                $allContents->push($assign);
            }

            // C. Masukkan Kuis (PERBAIKAN: Loop ini harus DI DALAM loop material)
            foreach ($material->quizzes as $quiz) {
                $quiz->content_type = 'quiz';
                $allContents->push($quiz);
            }
        }

        // -----------------------------------------------------------
        // 4. MENENTUKAN KONTEN SAAT INI (Current View)
        // -----------------------------------------------------------
        $currentId = $request->query('id');
        $currentType = $request->query('type'); // 'material', 'assignment', atau 'quiz'

        if ($currentId && $currentType) {
            // Cari di koleksi yang sudah kita gabung tadi
            $currentContent = $allContents->filter(function ($item) use ($currentId, $currentType) {
                return $item->id == $currentId && $item->content_type == $currentType;
            })->first();
        } else {
            // Kalau tidak ada parameter di URL, ambil konten pertama banget
            $currentContent = $allContents->first();
        }

        // -----------------------------------------------------------
        // 5. LOGIC PREV & NEXT BUTTON
        // -----------------------------------------------------------
        // Cari urutan ke berapa konten yang sedang dibuka sekarang
        $currentIndex = $allContents->search(function ($item) use ($currentContent) {
            return $item === $currentContent;
        });

        // Tentukan konten berikutnya
        $nextContent = ($currentIndex !== false && $currentIndex < $allContents->count() - 1)
            ? $allContents[$currentIndex + 1]
            : null;

        // Tentukan konten sebelumnya
        $prevContent = ($currentIndex !== false && $currentIndex > 0)
            ? $allContents[$currentIndex - 1]
            : null;

        return view('student.courses.show', compact(
            'course',
            'allContents',
            'currentContent',
            'nextContent',
            'prevContent'
        ));
    }

    public function students(Course $course)
    {
        // Ambil data siswa yang terdaftar di kursus ini, urutkan dari yang terbaru gabung
        $students = $course->students()->orderByPivot('created_at', 'desc')->get();

        return view('admin.courses.students', compact('course', 'students'));
    }
}
