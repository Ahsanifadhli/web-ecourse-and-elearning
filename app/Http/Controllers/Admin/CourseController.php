<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    // 1. Tampilkan Daftar Kursus
    public function index()
    {
        // Ambil semua kursus, urutkan dari yang terbaru
        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    // 2. Tampilkan Form Buat Kursus
    public function create()
    {
        return view('admin.courses.create');
    }

    // 3. Simpan Kursus Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Upload Gambar
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        // Simpan ke Database
        Course::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
            'thumbnail' => $thumbnailPath
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dibuat!');
    }

    // 4. Tampilkan Detail Kursus (Halaman Manage Materi)
    public function show(Course $course)
    {
        // Load relasi materi, tugas, dan kuis agar tidak query berulang-ulang
        $course->load([
            'materials.subMaterials',
            'materials.assignments.submissions',
            'materials.quizzes.questions'
        ]);

        return view('admin.courses.show', compact('course'));
    }

    // 5. Form Edit Kursus
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // 6. Update Kursus
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            // Upload baru
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    // 7. Hapus Kursus
    public function destroy(Course $course)
    {
        // Hapus gambar thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dihapus!');
    }

    // --- FUNGSI BARU: MELIHAT DAFTAR PESERTA ---
    public function students(Course $course)
    {
        // Ambil data siswa yang terdaftar di kursus ini via pivot table
        $students = $course->students()->orderByPivot('created_at', 'desc')->get();

        return view('admin.courses.students', compact('course', 'students'));
    }
}
