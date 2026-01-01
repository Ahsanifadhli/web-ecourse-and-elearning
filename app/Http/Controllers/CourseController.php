<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show(Course $course, Request $request)
    {
        // 1. LOGIC AUTO-ENROLL (Otomatis daftar jika belum)
        if (Auth::check() && !Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            Auth::user()->courses()->attach($course->id);
        }

        // 2. LOAD DATA MATERI
        $course->load(['materials.subMaterials', 'materials.assignments', 'materials.quizzes.questions']);

        // 3. FLAT CONTENT (Gabung semua materi jadi satu list urut)
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

        // 4. TENTUKAN KONTEN SAAT INI
        $currentId = $request->query('id');
        $currentType = $request->query('type');

        if ($currentId && $currentType) {
            $currentContent = $allContents->filter(function ($item) use ($currentId, $currentType) {
                return $item->id == $currentId && $item->content_type == $currentType;
            })->first();
        } else {
            $currentContent = $allContents->first();
        }

        // 5. NEXT & PREV BUTTON
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
}
