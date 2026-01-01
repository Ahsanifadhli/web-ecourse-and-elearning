<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - LMS Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 font-medium flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>

                @auth
                    <a href="{{ route('student.dashboard') }}" class="text-indigo-600 font-bold hover:underline">Dashboard Saya</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Masuk Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 py-12 md:py-16">
            <div class="flex flex-col md:flex-row gap-10 items-start">

                <div class="w-full md:w-1/3 flex-shrink-0">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 bg-gray-200">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-auto object-cover" alt="{{ $course->title }}">
                        @else
                            <div class="aspect-video flex items-center justify-center bg-indigo-100 text-indigo-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-between text-sm text-gray-500 md:hidden">
                        <span>{{ $course->students_count }} Siswa Terdaftar</span>
                        <span>{{ $course->materials_count }} Bab Materi</span>
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="mb-4">
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Kelas Premium</span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $course->title }}</h1>

                    <div class="hidden md:flex items-center gap-8 mb-8 text-sm text-gray-600 font-medium border-y border-gray-100 py-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ $course->students_count }} Siswa Terdaftar
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            {{ $course->materials_count }} Bab Materi
                        </div>
                    </div>

                    <p class="text-gray-600 text-lg leading-relaxed mb-10">{{ $course->description }}</p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            @if(Auth::user()->courses->contains($course->id))
                                <a href="{{ route('courses.show', $course->id) }}" class="inline-flex justify-center items-center gap-2 bg-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg hover:shadow-green-200 transform hover:-translate-y-1 w-full sm:w-auto">
                                    <span>Lanjut Belajar</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <form action="{{ route('student.enroll', $course->id) }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-200 transform hover:-translate-y-1">
                                        <span>Gabung Kelas Sekarang</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex justify-center items-center gap-2 bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-200 transform hover:-translate-y-1 w-full sm:w-auto">
                                <span>Masuk untuk Gabung Kelas</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <h3 class="text-2xl font-bold text-gray-900 mb-8">Kurikulum Kelas</h3>
        <div class="space-y-4">
            @forelse($course->materials as $index => $material)
                <div class="bg-white border border-gray-200 rounded-xl p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">{{ $material->title }}</h4>
                        <p class="text-gray-500 text-sm mt-1">Materi ini akan terbuka setelah Anda bergabung.</p>
                    </div>
                    <div class="ml-auto text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-8">Belum ada materi yang diunggah.</div>
            @endforelse
        </div>
    </div>

</body>
</html>
