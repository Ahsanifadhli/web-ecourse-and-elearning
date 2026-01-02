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
    public function store(Request $request, Assignment $assignment)
    {
        // 1. Validasi "Longgar" (Boleh File Apapun)
        $request->validate([
            // Max 50MB (51200 KB). Mimes lengkap biar video/gambar masuk.
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,mp4,mov,avi,zip,rar|max:51200',
            'text_submission' => 'nullable|string',
        ]);

        // Cek: Jangan sampai kosong melompong (Gak kirim file, gak kirim teks)
        if (!$request->hasFile('file') && !$request->text_submission) {
            return response()->json(['error' => 'Mohon isi jawaban teks atau upload file.'], 400);
        }

        // 2. Proses Upload File (Jika Ada)
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Simpan dengan nama asli biar gampang dikenali
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', $filename, 'public');
        }

        // 3. Simpan ke Database
        // Kita pakai updateOrCreate biar kalau siswa kirim ulang, data lama tertimpa (Revisi)
        Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => auth()->id()
            ],
            [
                'file_path' => $filePath, // Bisa null kalau cuma teks
                'text_submission' => $request->text_submission, // Kolom baru
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        return response()->json(['message' => 'Berhasil!']);
    }
}
