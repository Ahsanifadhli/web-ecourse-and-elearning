@extends('layouts.app')

@section('title', 'Tambah Kursus Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Buat Kursus Baru</h2>

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kursus</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Belajar Laravel Dasar" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Jelaskan apa yang akan dipelajari..." required></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail (Gambar Sampul)</label>
            <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium">Simpan Kursus</button>
        </div>
    </form>
</div>
@endsection
