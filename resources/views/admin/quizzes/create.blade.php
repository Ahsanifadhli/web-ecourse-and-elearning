@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <h2 class="text-xl font-bold mb-4">Buat Kuis Baru</h2>
    <form action="{{ route('admin.materials.quizzes.store', $material->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Judul Kuis</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required placeholder="Contoh: Kuis Harian Bab 1">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Durasi (Menit)</label>
            <input type="number" name="time_limit" class="w-full border p-2 rounded" required value="30">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan & Buat Soal</button>
    </form>
</div>
@endsection
