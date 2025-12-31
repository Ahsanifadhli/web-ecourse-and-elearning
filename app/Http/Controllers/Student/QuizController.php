<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Option;
use App\Models\QuizAttempt; // Pastikan Model ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Menampilkan Halaman Mengerjakan Kuis (Full Screen)
     */
    public function show(Quiz $quiz)
    {
        // Kita load pertanyaan beserta opsi jawabannya
        $quiz->load('questions.options');

        return view('student.quizzes.take', compact('quiz'));
    }

    /**
     * Proses Submit Jawaban & Hitung Skor
     */
    public function store(Request $request, Quiz $quiz)
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        // Cek jawaban yang dikirim user
        if ($request->answers) {
            foreach ($request->answers as $questionId => $optionId) {
                // Cari opsi yang dipilih di database
                $option = Option::find($optionId);

                // Validasi:
                // 1. Opsi harus ada
                // 2. Opsi harus milik pertanyaan yang benar (mencegah kecurangan inspect element)
                // 3. Opsi tersebut adalah jawaban benar (is_correct = 1)
                if ($option && $option->question_id == $questionId && $option->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        // Hitung Skor (Skala 0 - 100)
        // Mencegah error division by zero jika soal 0
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Simpan ke Database
        // Menggunakan updateOrCreate:
        // - Jika user ini SUDAH pernah ngerjain kuis ini -> UPDATE nilai lama.
        // - Jika user BELUM pernah ngerjain -> CREATE data baru.
        QuizAttempt::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id()
            ],
            [
                'score' => $score
            ]
        );

        // Tentukan pesan status berdasarkan KKM
        $statusMessage = ($score >= $quiz->passing_score)
            ? "Selamat! Anda Lulus dengan nilai $score."
            : "Nilai Anda $score (Di bawah KKM $quiz->passing_score). Silakan coba lagi.";

        // Redirect kembali ke halaman Course (Materi)
        // Kita kirim parameter 'type' & 'id' supaya halaman langsung ngebuka tab Kuis tadi
        return redirect()->route('courses.show', [
            'course' => $quiz->material->course_id,
            'type' => 'quiz',
            'id' => $quiz->id
        ])->with('success', 'Kuis selesai dikirim. ' . $statusMessage);
    }
}
