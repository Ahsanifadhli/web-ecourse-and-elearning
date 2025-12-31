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
