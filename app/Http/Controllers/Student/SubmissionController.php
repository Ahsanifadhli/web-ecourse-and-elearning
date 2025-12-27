<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function store(Request $request, $assignmentId)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // Maksimal 50MB
        ]);

        // Cek apakah siswa ini sudah pernah mengumpulkan sebelumnya?
        // Jika ya, hapus file lama (Re-submit) agar tidak menumpuk sampah
        $existingSubmission = Submission::where('assignment_id', $assignmentId)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingSubmission) {
            Storage::disk('public')->delete($existingSubmission->file_path);
            $existingSubmission->delete();
        }

        // Upload File Baru
        // Kita simpan di folder: public/submissions/USER_ID
        $filePath = $request->file('file')->store('submissions/' . Auth::id(), 'public');

        // Simpan Data ke Database
        Submission::create([
            'assignment_id' => $assignmentId,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'grade' => null, // Nilai kosong dulu karena belum diperiksa Admin
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
