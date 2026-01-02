<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // Form Buat Tugas
    public function create(Material $material)
    {
        return view('admin.assignments.create', compact('material'));
    }

    // Simpan Tugas
    public function store(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instruction' => 'nullable|string',
        ]);

        $material->assignments()->create([
            'title' => $request->title,
            'instruction' => $request->instruction,
        ]);

        return redirect()->route('admin.courses.show', $material->course_id)
                         ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function submissions(Assignment $assignment)
    {
        // Tambah 'latest()' biar yang baru upload ada di paling atas
        $submissions = $assignment->submissions()->with('user')->latest()->get();

        return view('admin.assignments.submissions', compact('assignment', 'submissions'));
    }

    // Proses Simpan Nilai & Feedback
    // app/Http/Controllers/Admin/AssignmentController.php

    public function grade(Request $request, \App\Models\Submission $submission)
    {
        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string' // Validasi untuk catatan
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback, // Simpan catatan
            'status' => 'graded' // Update status jadi sudah dinilai
        ]);

        return back()->with('success', 'Nilai dan catatan berhasil disimpan!');
    }

    // Hapus Tugas
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Tugas dihapus.');
    }
}
