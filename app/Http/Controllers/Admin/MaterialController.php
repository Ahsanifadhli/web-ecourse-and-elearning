<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // 1. Form Create
    public function create(Course $course)
    {
        return view('admin.materials.create', compact('course'));
    }

    // 2. Store (Simpan Baru dengan Validasi Ketat)
    public function store(Request $request, Course $course)
    {
        // Validasi dasar
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:video,pdf',
        ]);

        // VALIDASI FILE BERDASARKAN TIPE YANG DIPILIH
        if ($request->type === 'video') {
            $request->validate([
                'file' => 'required|file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo|max:102400', // Max 100MB
            ], [
                'file.mimetypes' => 'Tipe materi VIDEO harus berupa file video (MP4, AVI, MOV).',
            ]);
        } else {
            $request->validate([
                'file' => 'required|file|mimetypes:application/pdf|max:10240', // Max 10MB untuk PDF
            ], [
                'file.mimetypes' => 'Tipe materi PDF harus berupa file dokumen PDF.',
            ]);
        }

        // Simpan File
        $filePath = $request->file('file')->store('materials', 'public');

        // Simpan ke Database
        $course->materials()->create([
            'title'       => $request->title,
            'type'        => $request->type,
            'file_path'   => $filePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.courses.show', $course->id)
                         ->with('success', 'Materi berhasil ditambahkan!');
    }

    // 3. Form Edit
    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    // 4. Update (Edit dengan Validasi Ketat)
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:video,pdf',
        ]);

        // Cek Validasi File JIKA user mengupload file baru
        if ($request->hasFile('file')) {
            if ($request->type === 'video') {
                $request->validate([
                    'file' => 'file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo|max:102400',
                ], [
                    'file.mimetypes' => 'Format file salah! Anda memilih tipe VIDEO, harap upload file video.',
                ]);
            } else {
                $request->validate([
                    'file' => 'file|mimetypes:application/pdf|max:10240',
                ], [
                    'file.mimetypes' => 'Format file salah! Anda memilih tipe PDF, harap upload file PDF.',
                ]);
            }
        }

        $data = [
            'title'       => $request->title,
            'type'        => $request->type,
            'description' => $request->description,
        ];

        // Proses Ganti File
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update($data);

        return redirect()->route('admin.courses.show', $material->course_id)
                         ->with('success', 'Materi berhasil diperbarui!');
    }

    // 5. Delete
    public function destroy(Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
