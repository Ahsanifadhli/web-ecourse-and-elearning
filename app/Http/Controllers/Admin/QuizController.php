<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // 1. Tampilkan Form Buat Kuis (Judul & Waktu)
    public function create(Material $material)
    {
        return view('admin.quizzes.create', compact('material'));
    }

    // 2. Simpan Kuis Baru
    public function store(Request $request, Material $material)
    {
        // Validasi (Biarkan seperti yang sudah benar tadi)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0',
        ]);

        // 1. SIMPAN DAN TANGKAP DATANYA KE VARIABEL $quiz
        $quiz = $material->quizzes()->create([
            'title' => $request->title,
            'description' => $request->description,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
        ]);

        // 2. LANGSUNG ARAHKAN KE HALAMAN EDIT (BUAT SOAL)
        // Asumsi route edit namanya 'admin.quizzes.edit' sesuai web.php sebelumnya
        return redirect()->route('admin.quizzes.edit', $quiz->id)
            ->with('success', 'Kuis dibuat! Silakan tambahkan soal di bawah ini.');
    }

    // 3. Halaman Edit Kuis (Kelola Soal)
    public function edit(Quiz $quiz)
    {
        // Load soal beserta opsinya
        $quiz->load('questions.options');
        return view('admin.quizzes.edit', compact('quiz'));
    }

    // --- FUNCTION SHOW SAYA HAPUS DARI SINI KARENA ITU MILIK SISWA ---

    // 4. Tambah Soal Pilihan Ganda
    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required',
        ]);

        // Simpan Soal
        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'type' => 'multiple_choice'
        ]);

        // Simpan Pilihan Jawaban
        foreach ($request->options as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => ($index == $request->correct_answer),
            ]);
        }

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function results(Quiz $quiz)
    {
        // Ambil data attempt (percobaan) beserta user-nya
        // Urutkan dari nilai tertinggi
        $attempts = \App\Models\QuizAttempt::where('quiz_id', $quiz->id)
                    ->with('user')
                    ->orderBy('score', 'desc')
                    ->get();

        return view('admin.quizzes.results', compact('quiz', 'attempts'));
    }

    // 5. Hapus Soal
    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Soal dihapus.');
    }

    // 6. Hapus Kuis
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Kuis dihapus.');
    }
}
