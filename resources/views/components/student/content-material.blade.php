@props(['content'])

<div class="bg-black rounded-xl overflow-hidden shadow-lg aspect-video relative flex items-center justify-center">
    @if($content->type == 'video')
        <video src="{{ asset('storage/' . $content->file_path) }}" controls autoplay class="w-full h-full object-contain"></video>
    @elseif($content->type == 'pdf')
        <iframe src="{{ asset('storage/' . $content->file_path) }}" class="w-full h-full border-none bg-white"></iframe>
    @endif
</div>
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <h3 class="font-bold text-gray-800 mb-2">Deskripsi</h3>
    <p class="text-gray-600">{{ $content->description ?? 'Tidak ada deskripsi.' }}</p>
</div>

<div class="mt-8 flex justify-end">
    <form action="{{ route('student.completions.toggle', $content->id) }}" method="POST">
        @csrf

        @php
            // Cek apakah user sudah menandai materi ini?
            $isCompleted = Auth::user()->completedSubMaterials->contains($content->id);
        @endphp

        <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-full font-bold shadow-sm transition transform active:scale-95 {{ $isCompleted ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-800 text-white hover:bg-gray-900' }}">
            @if($isCompleted)
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Sudah Selesai</span>
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Tandai Selesai</span>
            @endif
        </button>
    </form>
</div>
