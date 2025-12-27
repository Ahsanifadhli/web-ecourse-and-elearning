<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Course $course, Request $request)
    {
        // Ambil semua materi urut dari yang terlama (Urutan belajar)
        $materials = $course->materials()->orderBy('id', 'asc')->get();

        // Cek: Apakah user sedang memilih materi tertentu dari Sidebar?
        // Jika ada query ?material=ID, pakai itu. Jika tidak, pakai materi pertama.
        $currentMaterialId = $request->query('material');

        if ($currentMaterialId) {
            $currentMaterial = $materials->where('id', $currentMaterialId)->first();
        } else {
            $currentMaterial = $materials->first();
        }

        // Logic untuk tombol "Selanjutnya" dan "Sebelumnya"
        $currentIndex = $materials->search(function($item) use ($currentMaterial) {
            return $item->id === $currentMaterial->id;
        });

        $nextMaterial = ($currentIndex < $materials->count() - 1) ? $materials[$currentIndex + 1] : null;
        $prevMaterial = ($currentIndex > 0) ? $materials[$currentIndex - 1] : null;

        return view('student.courses.show', compact('course', 'materials', 'currentMaterial', 'nextMaterial', 'prevMaterial'));
    }
}
