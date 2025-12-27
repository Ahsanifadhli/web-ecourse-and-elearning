@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-600">
        <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
        <p class="text-gray-600">Waktu: {{ $quiz->time_limit }} Menit | Jumlah Soal: {{ $quiz->questions->count() }}</p>
        <a href="{{ route('admin.courses.show', $quiz->material->course_id) }}" class="text-indigo-600 text-sm mt-2 inline-block">&larr; Kembali ke Kursus</a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold text-lg mb-4">Tambah Soal Pilihan Ganda</h3>
        <form action="{{ route('admin.quizzes.questions.store', $quiz->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Pertanyaan</label>
                <textarea name="question_text" class="w-full border p-2 rounded h-24" required placeholder="Tulis soal di sini..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @for($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-2 border p-3 rounded bg-gray-50">
                    <input type="radio" name="correct_answer" value="{{ $i }}" required class="w-4 h-4 text-indigo-600">
                    <input type="text" name="options[]" class="w-full bg-transparent outline-none border-b border-gray-300 focus:border-indigo-500" placeholder="Pilihan Jawaban {{ $i+1 }}" required>
                </div>
                @endfor
            </div>
            <p class="text-xs text-gray-500 mb-4">*Pilih radio button bulat untuk menandai kunci jawaban yang benar.</p>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">+ Simpan Soal</button>
        </form>
    </div>

    <div class="space-y-4">
        @foreach($quiz->questions as $index => $q)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 relative">
            <div class="absolute top-4 right-4">
                <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                </form>
            </div>

            <h4 class="font-bold text-gray-800 mb-3"><span class="text-indigo-600">#{{ $index + 1 }}</span> {{ $q->question_text }}</h4>

            <ul class="space-y-2 ml-4">
                @foreach($q->options as $opt)
                    <li class="flex items-center gap-2 {{ $opt->is_correct ? 'text-green-700 font-bold' : 'text-gray-600' }}">
                        @if($opt->is_correct)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <div class="w-5 h-5 border border-gray-300 rounded-full"></div>
                        @endif
                        {{ $opt->option_text }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
@endsection
