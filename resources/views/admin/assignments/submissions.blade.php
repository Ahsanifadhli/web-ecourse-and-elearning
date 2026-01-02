@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Penilaian: {{ $assignment->title }}</h1>
            <p class="text-gray-500">Materi: {{ $assignment->material->title }}</p>
        </div>
        <a href="{{ route('admin.courses.show', $assignment->material->course_id) }}"
           class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition shadow-sm">
            &larr; Kembali
        </a>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">File / Jawaban</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Nilai</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- 1. SISWA --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                    {{ substr($submission->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-sm">{{ $submission->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $submission->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- 2. FILE --}}
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @if($submission->text_submission)
                                    <div class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded inline-block border border-gray-200" title="{{ $submission->text_submission }}">
                                        📄 Teks: "{{ Str::limit($submission->text_submission, 20) }}"
                                    </div>
                                @endif

                                @if($submission->file_path)
                                    <div>
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                                           class="text-indigo-600 hover:text-indigo-800 text-sm font-bold flex items-center gap-1 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Lihat File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- 3. NILAI --}}
                        <td class="px-6 py-4 text-center">
                            @if($submission->grade)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    {{ $submission->grade }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                    -
                                </span>
                            @endif
                        </td>

                        {{-- 4. AKSI (TRIGGER COMPONENT) --}}
                        <td class="px-6 py-4 text-center">
                            <button onclick="openGradeModal('{{ $submission->id }}', '{{ $submission->user->name }}', '{{ $submission->grade }}', `{{ $submission->feedback }}`)"
                                    class="text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-lg shadow-sm transition">
                                ⭐ Beri Nilai
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Belum ada pengumpulan tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- PANGGIL COMPONENT MODAL DI SINI --}}
<x-admin.modal-grade />

@endsection
