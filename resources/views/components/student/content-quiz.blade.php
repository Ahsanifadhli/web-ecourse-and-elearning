@props(['content'])

<div class="bg-white p-8 rounded-xl shadow-sm border border-purple-200 border-t-4 border-t-purple-500 text-center">
    <div class="inline-block p-4 bg-purple-100 rounded-full mb-4">
        <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
    </div>
    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $content->title }}</h2>
    <p class="text-gray-500 mb-6">{{ $content->description ?? 'Kerjakan kuis ini dengan teliti.' }}</p>

    <div class="flex justify-center gap-6 mb-8 text-sm">
        <div class="bg-gray-50 px-4 py-2 rounded border">
            <span class="block font-bold text-gray-800">{{ $content->time_limit }} Menit</span>
            <span class="text-gray-500">Durasi</span>
        </div>
        <div class="bg-gray-50 px-4 py-2 rounded border">
            <span class="block font-bold text-gray-800">{{ $content->questions->count() }} Soal</span>
            <span class="text-gray-500">Jumlah Soal</span>
        </div>
        <div class="bg-gray-50 px-4 py-2 rounded border">
            <span class="block font-bold text-gray-800">{{ $content->passing_score }}</span>
            <span class="text-gray-500">KKM</span>
        </div>
    </div>

    @php
        $attempt = \App\Models\QuizAttempt::where('quiz_id', $content->id)->where('user_id', Auth::id())->first();
        $isPassed = $attempt && $attempt->score >= $content->passing_score;
    @endphp

    @if($attempt)
        <div class="{{ $isPassed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} border p-6 rounded-xl max-w-md mx-auto mb-6">

            @if($isPassed)
                <h3 class="text-green-800 font-bold mb-1 text-lg">🎉 Selamat, Anda Lulus!</h3>
                <p class="text-sm text-green-600 mb-4">Anda telah mencapai nilai minimum.</p>
            @else
                <h3 class="text-red-800 font-bold mb-1 text-lg">❌ Belum Lulus</h3>
                <p class="text-sm text-red-600 mb-4">Nilai Anda di bawah KKM ({{ $content->passing_score }}). Silakan coba lagi.</p>
            @endif

            <div class="text-5xl font-extrabold {{ $isPassed ? 'text-green-600' : 'text-red-600' }} mb-2">{{ $attempt->score }}</div>
            <div class="text-sm font-bold {{ $isPassed ? 'text-green-700' : 'text-red-700' }} uppercase tracking-wide">Nilai Akhir</div>
        </div>

        <div class="flex flex-col gap-3 justify-center items-center">
            @if(!$isPassed)
                <a href="{{ route('student.quizzes.take', $content->id) }}" onclick="return confirm('Mulai ulang kuis?')" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 shadow transition">
                    ↺ Ulangi Kuis
                </a>
            @else
                <a href="{{ route('student.quizzes.take', $content->id) }}" onclick="return confirm('Mulai ulang kuis? Nilai lama akan tertimpa.')" class="text-gray-400 hover:text-indigo-600 text-sm underline">
                    Ingin memperbaiki nilai? Kerjakan ulang
                </a>
            @endif
        </div>

    @else
        <a href="{{ route('student.quizzes.take', $content->id) }}"
           onclick="return confirm('Waktu akan berjalan segera setelah tombol diklik. Siap?')"
           class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-purple-700 shadow-lg transition transform hover:scale-105">
           Mulai Kuis Sekarang
        </a>
    @endif
</div>
