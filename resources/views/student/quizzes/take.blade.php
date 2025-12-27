<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian: {{ $quiz->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Mencegah copy paste */
        body { user-select: none; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <div class="fixed top-0 w-full bg-white shadow-md z-50 px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="font-bold text-gray-800 text-lg">{{ $quiz->title }}</h1>
            <p class="text-xs text-gray-500">Jumlah Soal: {{ $quiz->questions->count() }}</p>
        </div>
        <div class="flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-lg border border-red-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span id="timer" class="font-mono font-bold text-xl">00:00</span>
        </div>
    </div>

    <div class="flex-1 mt-24 mb-24 max-w-3xl mx-auto w-full px-6">
        <form id="quizForm" action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach($quiz->questions as $index => $question)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
                    <p class="font-bold text-gray-800 text-lg mb-4">
                        <span class="text-indigo-600 mr-2">{{ $index + 1 }}.</span> {{ $question->question_text }}
                    </p>

                    <div class="space-y-3">
                        @foreach($question->options as $option)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition group">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-3 text-gray-700 group-hover:text-indigo-700">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </form>
    </div>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <span class="text-sm text-gray-500">Pastikan semua soal terjawab.</span>
            <button onclick="if(confirm('Yakin ingin mengumpulkan jawaban?')) document.getElementById('quizForm').submit()"
                class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 shadow-lg transition">
                Kirim Jawaban
            </button>
        </div>
    </div>

    <script>
        // Ambil durasi dari database (menit -> detik)
        let timeLeft = {{ $quiz->time_limit * 60 }};
        const timerDisplay = document.getElementById('timer');

        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                alert('Waktu Habis! Jawaban akan dikirim otomatis.');
                document.getElementById('quizForm').submit();
            }

            timeLeft--;
        }, 1000);

        // Warning kalau mau reload page
        window.onbeforeunload = function() {
            return "Waktu terus berjalan. Yakin ingin keluar?";
        };

        // Matikan warning saat submit form
        document.getElementById('quizForm').onsubmit = function() {
            window.onbeforeunload = null;
        };
    </script>

</body>
</html>
