<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Pro - Belajar Coding dari Ahlinya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm fixed w-full z-20 top-0 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="bg-indigo-600 p-1.5 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">Ahsani<span class="text-indigo-600">Tech</span></span>
                </div>

                <div>
                    @auth
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-500 hidden md:block">Halo, {{ Auth::user()->name }}</span>
                            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-medium transition text-sm shadow-md">
                                Dashboard Saya
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium px-4 py-2 text-sm">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-full font-medium transition text-sm shadow-md hover:shadow-lg transform active:scale-95">
                                Daftar Gratis
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-32 pb-24 bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800 text-white text-center px-4 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <span class="inline-block py-1 px-3 rounded-full bg-indigo-500/30 border border-indigo-400/50 text-indigo-100 text-xs font-semibold tracking-wider mb-6">PLATFORM BELAJAR TERBAIK</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                Bangun Karir Impianmu<br>Mulai Dari Sini 🚀
            </h1>
            <p class="text-indigo-100 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                Akses ratusan materi pemrograman berkualitas, kerjakan proyek nyata, dan dapatkan sertifikat kompetensi untuk portofolio Anda.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#courses" class="bg-white text-indigo-900 font-bold px-8 py-4 rounded-full shadow-xl hover:bg-gray-100 transition transform hover:-translate-y-1">
                    Lihat Katalog Kelas
                </a>
            </div>
        </div>
    </div>

    <div id="courses" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Kelas Terbaru Kami</h2>
            <div class="w-24 h-1 bg-indigo-600 mx-auto rounded-full"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">Pilih kelas sesuai minat Anda dan mulailah belajar dengan kurikulum terstruktur.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full group">
                <div class="h-52 bg-gray-200 relative overflow-hidden rounded-t-2xl">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" alt="{{ $course->title }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-bold text-indigo-600 shadow-sm">
                        {{ $course->students_count }} Siswa
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition">{{ $course->title }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed flex-1">{{ Str::limit($course->description, 100) }}</p>

                    <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                             <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">A</div>
                             <span class="text-xs text-gray-500 font-medium">Admin</span>
                        </div>

                        <a href="{{ route('front.course.detail', $course->slug) }}" class="text-indigo-600 font-bold text-sm hover:text-indigo-800 flex items-center gap-1 group-hover:translate-x-1 transition">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 text-indigo-500 rounded-full mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Belum ada kelas tersedia</h3>
                <p class="text-gray-500 mt-2">Nantikan kelas menarik dari kami segera!</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">LMS Pro</h2>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} LMS Pro. Belajar Coding dengan Asik. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
