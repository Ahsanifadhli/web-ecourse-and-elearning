<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    // 1. Tampilkan Daftar Kursus
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    // 2. Form Tambah Kursus
    public function create()
    {
        return view('admin.courses.create');
    }

    // 3. Simpan Kursus ke Database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'description' => 'required',
        ]);

        // Upload Gambar
        $imagePath = $request->file('thumbnail')->store('thumbnails', 'public');

        Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnail' => $imagePath,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dibuat!');
    }

    // 4. Form Edit (Nanti sekaligus kelola materi di sini)
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // 5. Update Kursus
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ];

        // Jika ada upload gambar baru
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    // 6. Hapus Kursus
    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kursus dihapus.');
    }
}
