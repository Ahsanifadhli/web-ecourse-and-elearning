<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis - {{ $quiz->title }}</title>

    {{-- PANGGIL TAILWIND AGAR TAMPILAN BAGUS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f3f4f6; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">

    {{-- NAVBAR SEDERHANA (Opsional, biar gak kosong melompong atasnya) --}}
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center shadow-sm">
        <div class="font-bold text-xl text-indigo-600">LMS Pro</div>
        <div class="text-sm text-gray-500">Hasil Kuis</div>
    </div>

    {{-- KONTEN UTAMA (DI TENGAH, TANPA SIDEBAR) --}}
    <div class="min-h-screen flex flex-col items-center pt-10 pb-20 px-4">

        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center relative overflow-hidden">

            {{-- Hiasan Garis Atas --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Hasil Pengerjaan</h2>
            <p class="text-gray-500 mb-8 text-lg">{{ $quiz->title }}</p>

            {{-- SKOR --}}
            <div class="flex justify-center items-center mb-4">
                <span class="text-9xl font-black text-indigo-600 tracking-tighter drop-shadow-sm">
                    {{ $attempt->score }}
                </span>
            </div>

            <p class="text-gray-400 mb-10 font-medium uppercase tracking-widest text-sm">
                KKM (Nilai Minimal): {{ $quiz->passing_score }}
            </p>

            {{-- STATUS LULUS/GAGAL --}}
            @if($attempt->score >= $quiz->passing_score)
                <div class="mb-10 animate-bounce">
                    <span class="px-8 py-3 rounded-full bg-green-100 text-green-700 font-bold text-xl border border-green-200 shadow-sm">
                        🎉 SELAMAT, ANDA LULUS!
                    </span>
                </div>
            @else
                <div class="mb-10">
                    <span class="px-8 py-3 rounded-full bg-red-100 text-red-700 font-bold text-xl border border-red-200 shadow-sm">
                        😢 BELUM LULUS, TETAP SEMANGAT!
                    </span>
                </div>
            @endif

            {{-- TOMBOL AKSI --}}
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">

                @if($attempt->score >= $quiz->passing_score)
                    {{-- TOMBOL LANJUT --}}
                    <a href="{{ route('courses.show', $quiz->material->course_id) }}"
                       class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Lanjut Materi Berikutnya &rarr;
                    </a>
                @else
                    {{-- TOMBOL ULANGI --}}
                    <a href="{{ route('student.quizzes.take', $quiz->id) }}"
                       class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        ⟳ Ulangi Kuis
                    </a>
                @endif

                {{-- TOMBOL PEMBAHASAN --}}
                <button onclick="togglePembahasan()" id="btn-toggle"
                        class="px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition shadow-sm flex items-center justify-center gap-2">
                    👁️ Lihat Pembahasan
                </button>
            </div>

            {{-- LINK KEMBALI --}}
            <div>
                <a href="{{ route('courses.show', $quiz->material->course_id) }}" class="text-gray-400 hover:text-indigo-600 text-sm font-semibold underline decoration-2 decoration-gray-200 hover:decoration-indigo-600 transition">
                    Kembali ke Halaman Kursus
                </a>
            </div>
        </div>

        {{-- AREA PEMBAHASAN (DEFAULT HIDDEN) --}}
        <div id="pembahasan-area" class="w-full max-w-3xl hidden mt-8 space-y-6 pb-20">
            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded-r-xl shadow-sm">
                <h3 class="text-xl font-bold text-blue-900">Pembahasan Detail</h3>
                <p class="text-blue-700 mt-1 text-sm">Berikut adalah analisis jawaban Anda.</p>
            </div>

            @foreach($quiz->questions as $index => $question)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-start gap-4 mb-6">
                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-indigo-100 text-indigo-700 font-bold rounded-lg text-sm">
                            {{ $index + 1 }}
                        </span>
                        <h4 class="text-lg font-bold text-gray-800 leading-relaxed">{{ $question->question_text }}</h4>
                    </div>

                    <div class="space-y-3 ml-12">
                        @foreach($question->options as $option)
                            @php
                                $isUser = isset($userAnswers[$question->id]) && $userAnswers[$question->id] == $option->id;
                                $isCorrect = $option->is_correct;

                                $bgClass = "bg-white border-gray-200 text-gray-600";
                                $icon = "";

                                if ($isCorrect) {
                                    $bgClass = "bg-green-50 border-green-500 text-green-800 font-bold";
                                    $icon = "✅ Benar";
                                }
                                if ($isUser && !$isCorrect) {
                                    $bgClass = "bg-red-50 border-red-500 text-red-800 font-bold";
                                    $icon = "❌ Salah";
                                }
                                if ($isUser && $isCorrect) {
                                    $icon = "✅ Jawaban Anda";
                                }
                            @endphp

                            <div class="flex justify-between items-center p-4 border rounded-lg {{ $bgClass }} transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $isUser ? 'border-indigo-600' : 'border-gray-300' }}">
                                        @if($isUser) <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></div> @endif
                                    </div>
                                    <span>{{ $option->option_text }}</span>
                                </div>
                                <span class="text-sm">{{ $icon }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- SCRIPT SEDERHANA --}}
    <script>
        function togglePembahasan() {
            var area = document.getElementById('pembahasan-area');
            var btn = document.getElementById('btn-toggle');

            if (area.classList.contains('hidden')) {
                area.classList.remove('hidden');
                btn.innerHTML = "🙈 Tutup Pembahasan";
                setTimeout(() => area.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
            } else {
                area.classList.add('hidden');
                btn.innerHTML = "👁️ Lihat Pembahasan";
            }
        }
    </script>
</body>
</html>
