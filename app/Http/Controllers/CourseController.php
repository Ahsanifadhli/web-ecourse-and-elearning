<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material; // <--- JANGAN LUPA IMPORT INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // 1. FUNGSI UTAMA PLAYER (Yang codingan Mas tadi)
    public function show(Course $course, Request $request)
    {
        // A. LOGIC AUTO-ENROLL
        if (Auth::check() && !Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            Auth::user()->courses()->attach($course->id);
        }

        // B. LOAD DATA MATERI
        $course->load(['materials.subMaterials', 'materials.assignments', 'materials.quizzes.questions']);

        // C. FLAT CONTENT (Gabung semua jadi satu list urut)
        $allContents = collect();

        foreach ($course->materials as $material) {
            // Video/PDF
            foreach ($material->subMaterials as $sub) {
                $sub->content_type = 'material';
                $allContents->push($sub);
            }
            // Tugas
            foreach ($material->assignments as $assign) {
                $assign->content_type = 'assignment';
                $allContents->push($assign);
            }
            // Kuis
            foreach ($material->quizzes as $quiz) {
                $quiz->content_type = 'quiz';
                $allContents->push($quiz);
            }
        }

        // D. TENTUKAN KONTEN SAAT INI (Berdasarkan URL ?type=...&id=...)
        $currentId = $request->query('id');
        $currentType = $request->query('type');

        if ($currentId && $currentType) {
            $currentContent = $allContents->filter(function ($item) use ($currentId, $currentType) {
                return $item->id == $currentId && $item->content_type == $currentType;
            })->first();
        } else {
            // Default: Ambil konten paling pertama
            $currentContent = $allContents->first();
        }

        // E. NEXT & PREV BUTTON LOGIC
        $currentIndex = $allContents->search(function ($item) use ($currentContent) {
            return $item === $currentContent;
        });

        $nextContent = ($currentIndex !== false && $currentIndex < $allContents->count() - 1)
            ? $allContents[$currentIndex + 1] : null;

        $prevContent = ($currentIndex !== false && $currentIndex > 0)
            ? $allContents[$currentIndex - 1] : null;

        return view('student.courses.show', compact(
            'course',
            'allContents',
            'currentContent',
            'nextContent',
            'prevContent'
        ));
    }

    // 2. FUNGSI BARU UNTUK MENGATASI ERROR SIDEBAR (materials.show)
    public function material(Material $material)
    {
        // Logic: Kita cari sub-materi pertama dari materi ini,
        // lalu kita REDIRECT ke fungsi show() di atas biar player-nya jalan.

        $firstSub = $material->subMaterials()->first();

        if ($firstSub) {
            // Arahkan ke player utama dengan parameter yang benar
            return redirect()->route('courses.show', [
                'course' => $material->course_id,
                'type' => 'material',
                'id' => $firstSub->id
            ]);
        }

        // Jika materi kosong (gak punya sub-materi), balikin ke halaman depan course
        return redirect()->route('courses.show', $material->course_id)
            ->with('warning', 'Materi ini belum memiliki konten.');
    }
}
