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
            <label class="block text-gray-700 text-sm font-bold mb-2">Durasi (Menit)</label>
            <input type="number" name="time_limit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 30">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Deskripsi</label>
            <textarea name="description" id="editor" class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-1">KKM (Passing Score)</label>
            <input type="number" name="passing_score" class="w-full border p-2 rounded" required value="70">
            <p class="text-xs text-gray-500 mt-1">Nilai minimal untuk lulus.</p>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan & Buat Soal</button>
    </form>
</div>

<style>
    /* Mengatur tinggi minimal area ketik CKEditor */
    .ck-editor__editable_inline {
        min-height: 300px; /* Mas bisa ganti angka ini sesuka hati */
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
