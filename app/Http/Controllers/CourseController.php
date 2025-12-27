<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubMaterial;
use App\Models\Assignment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Course $course, Request $request)
    {
        // 1. Ambil Data Bab beserta isinya (SubMateri, Tugas, dan Kuis)
        // Kita load relationship-nya biar ringan
        $course->load(['materials.subMaterials', 'materials.assignments', 'materials.quizzes.questions']);

        // 2. Gabungkan semua konten (SubMateri & Tugas) jadi satu urutan Linear
        // Ini trik supaya tombol Next/Prev gampang logikanya
        $allContents = collect();

        foreach ($course->materials as $material) {
            // Masukkan Sub-Materi (Video/PDF)
            foreach ($material->subMaterials as $sub) {
                $sub->content_type = 'material'; // Penanda
                $allContents->push($sub);
            }
            // Masukkan Tugas
            foreach ($material->assignments as $assign) {
                $assign->content_type = 'assignment'; // Penanda
                $allContents->push($assign);
            }
        }

        foreach ($material->quizzes as $quiz) {
            $quiz->content_type = 'quiz';
            $allContents->push($quiz);
        }

        // 3. Tentukan Konten Apa yang Sedang Dibuka
        $currentId = $request->query('id');
        $currentType = $request->query('type'); // 'material' atau 'assignment'

        if ($currentId && $currentType) {
            // Cari di koleksi yang sudah kita gabung tadi
            $currentContent = $allContents->filter(function ($item) use ($currentId, $currentType) {
                return $item->id == $currentId && $item->content_type == $currentType;
            })->first();
        } else {
            // Kalau tidak ada di URL, ambil konten pertama banget
            $currentContent = $allContents->first();
        }

        // 4. Logic Next & Previous
        $currentIndex = $allContents->search(function ($item) use ($currentContent) {
            return $item === $currentContent;
        });

        $nextContent = ($currentIndex !== false && $currentIndex < $allContents->count() - 1)
            ? $allContents[$currentIndex + 1]
            : null;

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
}
