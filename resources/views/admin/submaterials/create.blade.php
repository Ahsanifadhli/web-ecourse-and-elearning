@extends('layouts.app')

@section('title', 'Tambah Konten Bab')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="mb-6 pb-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Tambah Konten Baru</h2>
        <p class="text-sm text-gray-500 mt-1">
            Menambahkan isi ke dalam Bab: <span class="font-semibold text-indigo-600">{{ $material->title }}</span>
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

    <form action="{{ route('admin.materials.submaterials.store', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Konten</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Video Penjelasan Part 1" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe File</label>
            <select name="type" id="typeSelect" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="video">Video (MP4)</option>
                <option value="pdf">Dokumen (PDF)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
            <input type="file" name="file" id="fileInput" required accept="video/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
            <p class="text-xs text-gray-400 mt-1">Maksimal 100MB.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.courses.show', $material->course_id) }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-medium shadow-md">Upload Konten</button>
        </div>
    </form>
</div>

<script>
    // Script Auto-Filter Tipe File
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
