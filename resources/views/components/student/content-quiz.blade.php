@props(['content'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 text-center">

    {{-- IKON LAMPU (Sesuai Screenshot) --}}
    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
    </div>

    {{-- JUDUL KUIS --}}
    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $content->title }}</h3>

    {{-- DESKRIPSI (INI PERBAIKANNYA: Menggunakan {!! !!} agar HTML terbaca) --}}
    <div class="prose max-w-none text-gray-500 mb-8 mx-auto">
        {!! $content->description !!}
    </div>

    {{-- INFO DETAIL (Durasi, Jumlah Soal, KKM) --}}
    <div class="flex flex-wrap justify-center gap-4 mb-8">
        {{-- Durasi --}}
        <div class="border border-gray-200 rounded-lg p-4 min-w-[100px]">
            {{-- Pastikan nama kolom di database sesuai (time_limit atau duration) --}}
            <div class="font-bold text-gray-800">{{ $content->time_limit ?? $content->duration ?? 0 }} Menit</div>
            <div class="text-xs text-gray-500">Durasi</div>
        </div>

        {{-- Jumlah Soal --}}
        <div class="border border-gray-200 rounded-lg p-4 min-w-[100px]">
            <div class="font-bold text-gray-800">{{ $content->questions->count() }} Soal</div>
            <div class="text-xs text-gray-500">Jumlah Soal</div>
        </div>

        {{-- KKM --}}
        <div class="border border-gray-200 rounded-lg p-4 min-w-[100px]">
            <div class="font-bold text-gray-800">{{ $content->passing_score ?? 60 }}</div>
            <div class="text-xs text-gray-500">KKM</div>
        </div>
    </div>

    {{-- TOMBOL MULAI KUIS --}}
    <a href="{{ route('student.quizzes.take', $content->id) }}"
       class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-1 no-underline">
        Mulai Kuis Sekarang
    </a>

</div>
