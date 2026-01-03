@extends('layouts.app')

@section('title', 'Tambah Konten Bab')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
    <div class="mb-6 pb-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Tambah Konten Baru</h2>
        <p class="text-sm text-gray-500 mt-1">
            Menambahkan isi ke dalam Bab: <span class="font-semibold text-indigo-600">{{ $material->title }}</span>
        </p>
    </div>

    {{-- ERROR HANDLING --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-bold">Perhatian:</p>
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.materials.submaterials.store', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 1. JUDUL --}}
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Konten</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                   placeholder="Contoh: Video Penjelasan Part 1" required>
        </div>

        {{-- 2. TIPE KONTEN (PILIHAN) --}}
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Konten</label>
            <div class="grid grid-cols-2 gap-4">
                {{-- Opsi Upload File --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="type" value="file" class="peer sr-only" onchange="toggleType()" checked>
                    <div class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:bg-gray-50 transition text-center">
                        <span class="block text-2xl mb-1">📁</span>
                        <span class="font-bold text-gray-700 peer-checked:text-indigo-700 text-sm">Upload File</span>
                        <span class="block text-xs text-gray-400 mt-1">(PDF / Video MP4)</span>
                    </div>
                </label>

                {{-- Opsi Youtube --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="type" value="youtube" class="peer sr-only" onchange="toggleType()">
                    <div class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-red-600 peer-checked:bg-red-50 hover:bg-gray-50 transition text-center">
                        <span class="block text-2xl mb-1">▶️</span>
                        <span class="font-bold text-gray-700 peer-checked:text-red-700 text-sm">Link YouTube</span>
                        <span class="block text-xs text-gray-400 mt-1">(Hemat Penyimpanan)</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- 3. INPUT UPLOAD FILE (Muncul jika pilih Upload File) --}}
        <div id="inputTypeFile">
            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih File</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition">
                <input type="file" name="file" id="fileInput"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Format: PDF, MP4, DOC, PPT. (Max 100MB)</p>
            </div>
        </div>

        {{-- 4. INPUT LINK YOUTUBE (Muncul jika pilih YouTube) --}}
        <div id="inputTypeYoutube" class="hidden">
            <label class="block text-sm font-bold text-gray-700 mb-2">Masukkan Link YouTube</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                </div>
                <input type="url" name="link" id="youtubeInput"
                       class="w-full pl-10 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none"
                       placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <p class="text-xs text-gray-500 mt-1">Pastikan link video bersifat 'Public' atau 'Unlisted'.</p>
        </div>

        {{-- 5. DESKRIPSI --}}
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                      placeholder="Tambahkan catatan untuk siswa..."></textarea>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.courses.show', $material->course_id) }}" class="px-6 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-medium">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg hover:bg-indigo-700 font-bold shadow-lg transform active:scale-95 transition">
                Simpan Konten
            </button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT LOGIKA TOGGLE --}}
<script>
    function toggleType() {
        // Ambil semua radio button dengan name="type"
        const types = document.getElementsByName('type');
        let selectedValue;

        for (const type of types) {
            if (type.checked) {
                selectedValue = type.value;
                break;
            }
        }

        const fileGroup = document.getElementById('inputTypeFile');
        const youtubeGroup = document.getElementById('inputTypeYoutube');
        const fileInput = document.getElementById('fileInput');
        const youtubeInput = document.getElementById('youtubeInput');

        if (selectedValue === 'youtube') {
            // Tampilkan Youtube, Sembunyikan File
            fileGroup.classList.add('hidden');
            youtubeGroup.classList.remove('hidden');

            // Hapus required dari file, tambah ke youtube
            fileInput.removeAttribute('required');
            fileInput.value = ''; // Reset file jika pindah ke youtube
            youtubeInput.setAttribute('required', 'required');
        } else {
            // Tampilkan File, Sembunyikan Youtube
            fileGroup.classList.remove('hidden');
            youtubeGroup.classList.add('hidden');

            // Hapus required dari youtube, tambah ke file
            youtubeInput.removeAttribute('required');
            youtubeInput.value = ''; // Reset link jika pindah ke file
            fileInput.setAttribute('required', 'required');
        }
    }

    // Jalankan sekali saat load (untuk antisipasi validasi error redirect)
    document.addEventListener("DOMContentLoaded", function() {
        toggleType();
    });
</script>
@endsection
