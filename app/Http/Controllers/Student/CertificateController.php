<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Submission;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download(Course $course)
    {
        $user = Auth::user();

        // --- 1. CEK KELENGKAPAN TUGAS (ASSIGNMENT) ---
        // Ambil semua ID assignment di kursus ini
        $allAssignments = $course->materials->flatMap->assignments->pluck('id');

        // Ambil submission user yang sudah dinilai (grade != null)
        $completedAssignments = Submission::whereIn('assignment_id', $allAssignments)
            ->where('user_id', $user->id)
            ->whereNotNull('grade')
            ->get();

        // --- 2. CEK KELENGKAPAN KUIS (QUIZ) ---
        // Ambil semua ID quiz di kursus ini
        $allQuizzes = $course->materials->flatMap->quizzes->pluck('id');

        // Ambil attempt user yang LULUS (score >= passing_score)
        // Kita ambil attempt terbaik per kuis
        $passedQuizzes = QuizAttempt::whereIn('quiz_id', $allQuizzes)
            ->where('user_id', $user->id)
            ->get()
            ->filter(function ($attempt) {
                return $attempt->score >= $attempt->quiz->passing_score;
            })
            ->unique('quiz_id'); // Pastikan 1 kuis dihitung 1 kali

        // --- 3. VALIDASI AKHIR ---
        $totalItems = $allAssignments->count() + $allQuizzes->count();
        $totalCompleted = $completedAssignments->count() + $passedQuizzes->count();

        // Jika jumlah yg selesai kurang dari total, TOLAK.
        if ($totalCompleted < $totalItems) {
            return back()->with('error', 'Anda belum menyelesaikan seluruh materi (Kuis/Tugas) atau nilai belum lengkap.');
        }

        // --- 4. HITUNG RATA-RATA ---
        $sumAssignment = $completedAssignments->sum('grade');
        $sumQuiz = $passedQuizzes->sum('score');

        // Rata-rata total
        $averageScore = 0;
        if ($totalItems > 0) {
            $averageScore = ($sumAssignment + $sumQuiz) / $totalItems;
        }

        // --- 5. SIAPKAN DATA DATA ---
        // Gabungkan data untuk Transkrip (Halaman 2)
        $transcript = collect();

        // Masukkan data Tugas
        foreach($completedAssignments as $sub) {
            $transcript->push([
                'name' => 'Tugas: ' . $sub->assignment->title,
                'type' => 'Assignment',
                'score' => $sub->grade
            ]);
        }

        // Masukkan data Kuis
        foreach($passedQuizzes as $quiz) {
            $transcript->push([
                'name' => 'Kuis: ' . $quiz->quiz->title,
                'type' => 'Quiz',
                'score' => $quiz->score
            ]);
        }

        $data = [
            'student_name' => $user->name,
            'course_name' => $course->title,
            'average_score' => round($averageScore, 1),
            'transcript' => $transcript, // Kirim data gabungan
            'date' => now()->translatedFormat('d F Y'),
            'certificate_id' => 'SERT-' . date('Ymd') . '-' . $user->id . '-' . $course->id
        ];

        // --- 6. GENERATE PDF ---
        $pdf = Pdf::loadView('pdf.certificate', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat-' . $course->title . '.pdf');
    }
}
