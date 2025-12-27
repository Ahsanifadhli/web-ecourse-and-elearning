<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Option;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // 1. Halaman Mengerjakan Kuis (Full Screen)
    public function show(Quiz $quiz)
    {
        // Cek apakah sudah pernah mengerjakan?
        $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                            ->where('user_id', Auth::id())
                            ->first();

        if ($existingAttempt) {
            return redirect()->back()->with('error', 'Anda sudah mengerjakan kuis ini! Nilai Anda: ' . $existingAttempt->score);
        }

        $quiz->load('questions.options');
        return view('student.quizzes.take', compact('quiz'));
    }

    // 2. Proses Submit & Hitung Nilai
    public function store(Request $request, Quiz $quiz)
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        // Loop setiap jawaban yang dikirim
        if ($request->answers) {
            foreach ($request->answers as $questionId => $optionId) {
                $option = Option::find($optionId);
                if ($option && $option->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        // Hitung Skor (Skala 100)
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Simpan ke Database
        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => Auth::id(),
            'score' => $score
        ]);

        return redirect()->route('courses.show', [
            'course' => $quiz->material->course_id,
            'type' => 'quiz',
            'id' => $quiz->id
        ])->with('success', 'Kuis selesai! Nilai Anda: ' . $score);
    }
}
