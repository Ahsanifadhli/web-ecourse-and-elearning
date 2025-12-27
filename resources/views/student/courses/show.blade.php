<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - Belajar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 overflow-hidden h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 flex-shrink-0 z-20 relative">
        <div class="flex items-center gap-4">
            <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="font-bold text-gray-800 text-lg truncate max-w-md">{{ $course->title }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden md:flex flex-col items-end mr-4">
                <span class="text-xs text-gray-500 font-medium">Progress Belajar</span>
                <div class="w-32 h-2 bg-gray-100 rounded-full mt-1">
                    <div class="h-2 bg-green-500 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <div class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                {{ substr(Auth::user()->username ?? 'S', 0, 1) }}
            </div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">

        <aside class="w-80 bg-white border-r border-gray-200 flex flex-col overflow-y-auto z-10 hidden md:flex">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider">Daftar Materi</h3>
            </div>

            <div class="flex-1 py-2">
                @foreach($materials as $index => $material)
                    @php
                        // Cek apakah ini materi yang sedang dibuka
                        $isActive = $currentMaterial && $currentMaterial->id == $material->id;
                    @endphp

                    <a href="{{ route('courses.show', ['course' => $course->id, 'material' => $material->id]) }}"
                       class="flex items-start gap-3 px-5 py-4 border-b border-gray-50 transition hover:bg-gray-50 {{ $isActive ? 'bg-indigo-50 border-r-4 border-r-indigo-600' : '' }}">

                        <div class="mt-0.5">
                            @if($isActive)
                                <div class="w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-sm">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 text-gray-300 flex items-center justify-center">
                                    <span class="text-[10px] font-bold">{{ $index + 1 }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h4 class="text-sm font-medium {{ $isActive ? 'text-indigo-700' : 'text-gray-700' }}">
                                {{ $material->title }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-100 text-gray-500 uppercase font-semibold tracking-wide">
                                    {{ $material->type }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 relative">

            @if($currentMaterial)
                <div class="max-w-5xl mx-auto space-y-6">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $currentMaterial->title }}</h2>
                    </div>

                    <div class="bg-black rounded-xl overflow-hidden shadow-lg aspect-video relative flex items-center justify-center group">
                        @if($currentMaterial->type == 'video')
                            <video src="{{ asset('storage/' . $currentMaterial->file_path) }}" controls autoplay class="w-full h-full object-contain"></video>
                        @elseif($currentMaterial->type == 'pdf')
                            <iframe src="{{ asset('storage/' . $currentMaterial->file_path) }}" class="w-full h-full border-none"></iframe>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">

                        <div>
                            @if($prevMaterial)
                                <a href="{{ route('courses.show', ['course' => $course->id, 'material' => $prevMaterial->id]) }}" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 font-medium transition px-4 py-2 hover:bg-gray-50 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Sebelumnya
                                </a>
                            @else
                                <span class="text-gray-300 cursor-not-allowed flex items-center gap-2 px-4 py-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Sebelumnya
                                </span>
                            @endif
                        </div>

                        <div>
                            @if($nextMaterial)
                                <a href="{{ route('courses.show', ['course' => $course->id, 'material' => $nextMaterial->id]) }}" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 font-medium transition px-4 py-2 hover:bg-gray-50 rounded-lg">
                                    Selanjutnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 text-indigo-600 font-medium px-4 py-2 hover:bg-indigo-50 rounded-lg">
                                    Selesai Kursus
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-3">Tentang Materi Ini</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $currentMaterial->description ?? 'Tidak ada deskripsi tambahan untuk materi ini.' }}
                        </p>
                    </div>

                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-md">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">Belum Ada Materi</h3>
                        <p class="text-gray-500 mt-2">Admin belum mengupload materi apapun untuk kursus ini.</p>
                        <a href="{{ route('student.dashboard') }}" class="mt-6 inline-block text-indigo-600 font-medium hover:underline">Kembali ke Dashboard</a>
                    </div>
                </div>
            @endif

        </main>
    </div>

</body>
</html>
