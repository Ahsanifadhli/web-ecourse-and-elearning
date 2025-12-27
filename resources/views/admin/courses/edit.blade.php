@extends('layouts.app')

@section('title', 'Edit Kursus')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Edit Kursus</h2>

        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kursus ini secara permanen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus Kursus Ini</button>
        </form>
    </div>

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT') <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kursus</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" required>{{ old('description', $course->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail (Gambar Sampul)</label>

            @if($course->thumbnail)
                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-1">Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-32 rounded-lg border border-gray-200 object-cover">
                </div>
            @endif

            <input type="file" name="thumbnail" accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
