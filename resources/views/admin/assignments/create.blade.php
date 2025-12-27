@extends('layouts.app')

@section('title', 'Buat Tugas Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Buat Tugas Baru</h2>
        <p class="text-gray-500 text-sm">Bab: {{ $material->title }}</p>
    </div>

    <form action="{{ route('admin.materials.assignments.store', $material->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Tugas Membuat Makalah" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Instruksi / Soal</label>
            <textarea name="instruction" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Jelaskan apa yang harus dikerjakan siswa..."></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.courses.show', $material->course_id) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium">Simpan Tugas</button>
        </div>
    </form>
</div>
@endsection
