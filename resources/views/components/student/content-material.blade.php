@props(['content'])

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
    
    {{-- Header Judul --}}
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">{{ $content->title }}</h2>
        <div class="mt-2">
            @if(strtolower($content->type) == 'youtube')
                <span class="inline-block bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-bold">
                    ▶ YouTube
                </span>
            @else
                <span class="inline-block bg-indigo-100 text-indigo-600 px-2 py-1 rounded text-xs font-bold">
                    📁 File
                </span>
            @endif
        </div>
    </div>

    {{-- LOGIKA TAMPILAN --}}
    
    {{-- 1. JIKA TIPE YOUTUBE --}}
    @if(strtolower($content->type) == 'youtube')
        
        @php
            // Logika Ekstrak ID YouTube yang lebih sederhana & kuat
            $url = $content->link;
            $videoId = null;

            // Cek format youtu.be/ID
            if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                $videoId = $matches[1];
            }
            // Cek format youtube.com/watch?v=ID
            elseif (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                $videoId = $matches[1];
            }
            // Cek format embed/ID
            elseif (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                $videoId = $matches[1];
            }
        @endphp

        @if($videoId)
            {{-- Kita paksa tinggi 450px biar PASTI MUNCUL --}}
            <div class="w-full rounded-xl overflow-hidden shadow-lg bg-black">
                <iframe 
                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                    style="width: 100%; height: 450px;" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        @else
            <div class="bg-red-50 p-4 rounded text-red-600 border border-red-200">
                <strong>Gagal memuat video!</strong><br>
                Link yang dimasukkan: <span class="font-mono text-xs">{{ $content->link }}</span> <br>
                <em class="text-sm">Pastikan link YouTube benar.</em>
            </div>
        @endif

    {{-- 2. JIKA TIPE FILE --}}
    @else
        
        @php
            $ext = strtolower(pathinfo($content->file_path, PATHINFO_EXTENSION));
        @endphp

        @if(in_array($ext, ['mp4', 'mov', 'avi']))
            {{-- Video Upload --}}
            <video controls style="width: 100%; max-height: 500px;" class="rounded-xl bg-black">
                <source src="{{ asset('storage/' . $content->file_path) }}" type="video/mp4">
                Browser Anda tidak support video.
            </video>

        @elseif($ext == 'pdf')
            {{-- PDF Preview --}}
            <iframe src="{{ asset('storage/' . $content->file_path) }}" style="width: 100%; height: 600px;" class="rounded-xl border border-gray-200"></iframe>
            <div class="mt-4 text-center">
                <a href="{{ asset('storage/' . $content->file_path) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">Download PDF</a>
            </div>

        @else
            {{-- File Lain --}}
            <div class="p-8 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl text-center">
                <p class="text-gray-500 mb-2">File Materi: {{ basename($content->file_path) }}</p>
                <a href="{{ asset('storage/' . $content->file_path) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700">
                    Download File
                </a>
            </div>
        @endif

    @endif

</div>