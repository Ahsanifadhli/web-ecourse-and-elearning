<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Option;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.options');

        // FIX: Load 'materials' langsung (GAK PAKE SECTIONS)
        $course = $quiz->material->course->load('materials');

        return view('student.quizzes.take', compact('quiz', 'course'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        $attempt = QuizAttempt::updateOrCreate(
            ['quiz_id' => $quiz->id, 'user_id' => Auth::id()],
            ['score' => 0]
        );

        QuizAnswer::where('quiz_attempt_id', $attempt->id)->delete();

        if ($request->answers) {
            foreach ($request->answers as $questionId => $optionId) {
                $option = Option::find($optionId);
                if ($option && $option->question_id == $questionId) {
                    if ($option->is_correct) {
                        $correctAnswers++;
                    }
                    QuizAnswer::create([
                        'quiz_attempt_id' => $attempt->id,
                        'question_id' => $questionId,
                        'option_id' => $optionId
                    ]);
                }
            }
        }

        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $attempt->update(['score' => $score]);

        return redirect()->route('student.quizzes.results', $quiz->id)
            ->with('success', 'Kuis selesai dikirim!');
    }

    public function results(Quiz $quiz)
    {
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->firstOrFail();

        $quiz->load(['questions.options']);

        $userAnswers = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                        ->pluck('option_id', 'question_id')
                        ->toArray();

        // FIX: Load 'materials' langsung
        $course = $quiz->material->course->load('materials');

        return view('student.quizzes.result', compact('quiz', 'attempt', 'userAnswers', 'course'));
    }
}
