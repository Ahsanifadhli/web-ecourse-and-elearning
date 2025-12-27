@extends('layouts.app')

@section('title', 'Detail Kursus')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 h-64 bg-gray-100 overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                    alt="{{ $course->title }}"
                    class="w-full h-full object-cover transition transform hover:scale-105 duration-500">
            </div>

            <div class="p-8 md:w-2/3 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                        <a href="{{ route('admin.courses.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    </div>
                    <p class="mt-4 text-gray-600 leading-relaxed">{{ $course->description }}</p>
                </div>

                <div class="mt-8 flex items-center gap-4 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-semibold">{{ $materials->count() }}</span> Materi Pembelajaran
                    </div>

                    <a href="{{ route('courses.show', $course->id) }}" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview Tampilan Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Kurikulum Materi</h2>
                <p class="text-sm text-gray-500">Kelola video dan dokumen kursus di sini.</p>
            </div>

            <a href="{{ route('admin.courses.materials.create', $course->id) }}"
               class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition font-medium shadow-md">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
               Tambah Materi
            </a>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($materials as $index => $material)
            <div class="p-6 flex flex-col sm:flex-row items-center gap-6 hover:bg-gray-50 transition group">
                <span class="text-2xl font-bold text-gray-200 w-8 text-center">{{ $index + 1 }}</span>

                <div class="flex-shrink-0">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $material->type == 'video' ? 'bg-indigo-50 text-indigo-600' : 'bg-red-50 text-red-600' }}">
                        @if($material->type == 'video')
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        @else
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <h3 class="text-lg font-bold text-gray-800">{{ $material->title }}</h3>
                    <div class="flex items-center justify-center sm:justify-start gap-3 mt-1 text-sm text-gray-500">
                        <span class="uppercase tracking-wider text-xs font-semibold bg-gray-100 px-2 py-0.5 rounded">{{ $material->type }}</span>
                        @if($material->description)
                            <span class="hidden sm:inline">&bull; {{ Str::limit($material->description, 50) }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3 opacity-90">
                    <a href="{{ route('admin.materials.edit', $material->id) }}"
                       class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                       title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>

                    <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-12 flex flex-col items-center justify-center text-center">
                <h3 class="text-lg font-medium text-gray-900">Belum ada materi</h3>
                <p class="text-gray-500 mt-1 mb-6">Kursus ini masih kosong.</p>
                <a href="{{ route('admin.courses.materials.create', $course->id) }}" class="text-indigo-600 font-medium hover:underline">+ Tambah Materi</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
