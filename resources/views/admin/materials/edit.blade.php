@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="mb-6 pb-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Edit Materi</h2>
        <p class="text-sm text-gray-500 mt-1">
            Mengubah: <span class="font-semibold text-indigo-600">{{ $material->title }}</span>
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Materi</label>
            <input type="text" name="title" value="{{ old('title', $material->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Materi</label>
            <select name="type" id="typeSelect" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 bg-white">
                <option value="video" {{ (old('type') ?? $material->type) == 'video' ? 'selected' : '' }}>Video (MP4)</option>
                <option value="pdf" {{ (old('type') ?? $material->type) == 'pdf' ? 'selected' : '' }}>Dokumen (PDF)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">File Materi (Opsional)</label>

            <div class="mb-3 flex items-center gap-2 p-3 bg-blue-50 text-blue-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>File saat ini: <b>{{ $material->type }}</b>. <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="underline">Cek File</a></span>
            </div>

            <input type="file" name="file" id="fileInput" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
            <p class="text-xs text-gray-400 mt-1">Upload jika ingin mengganti file lama.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tambahan</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $material->description) }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.courses.show', $material->course_id) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium shadow-md">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('typeSelect');
    const fileInput = document.getElementById('fileInput');

    function updateAccept() {
        if (typeSelect.value === 'video') {
            fileInput.setAttribute('accept', 'video/mp4,video/x-m4v,video/*');
        } else {
            fileInput.setAttribute('accept', 'application/pdf');
        }
    }

    typeSelect.addEventListener('change', updateAccept);
    updateAccept();
</script>
@endsection
