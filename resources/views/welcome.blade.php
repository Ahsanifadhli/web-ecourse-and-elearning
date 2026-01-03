<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Pro - Platform Belajar Online Terlengkap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Menggunakan font Plus Jakarta Sans agar lebih modern & friendly */
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        
        /* ANIMASI */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @keyframes float-side {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            50% { transform: translateX(10px) rotate(2deg); }
        }
        
        /* UTILITIES */
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-float-delayed { animation: float 4s ease-in-out 2s infinite; }
        .animate-hover-side { animation: float-side 5s ease-in-out infinite; }

        /* SCROLL REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* CUSTOM HOVER */
        .hover-card-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-card-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* SCROLL BAR ATAS */
        .progress-bar {
            position: fixed; top: 0; left: 0; height: 3px;
            background: linear-gradient(to right, #4f46e5, #ec4899);
            z-index: 100; width: 0%; transition: width 0.1s;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">

    <div class="progress-bar" id="progressBar"></div>

    <nav id="navbar" class="fixed w-full z-50 top-0 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="bg-gradient-to-br from-indigo-600 to-pink-500 p-2 rounded-xl text-white shadow-lg">
                        <i class="fas fa-shapes text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight">Ahsani<span class="text-indigo-600">Course</span></span>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-slate-600 hover:text-indigo-600 font-medium text-sm transition">Beranda</a>
                    <a href="#categories" class="text-slate-600 hover:text-indigo-600 font-medium text-sm transition">Kategori</a>
                    <a href="#courses" class="text-slate-600 hover:text-indigo-600 font-medium text-sm transition">Kelas Populer</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium text-sm transition">Mentors</a>
                </div>

                <div>
                    @auth
                        <div class="flex items-center gap-4">
                            <a href="{{ url('/dashboard') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-full font-bold transition text-sm shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Dashboard Saya
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-bold text-sm px-3">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-pink-500 hover:from-indigo-700 hover:to-pink-600 text-white px-6 py-2.5 rounded-full font-bold transition text-sm shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
                                Mulai Belajar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] rounded-full bg-pink-100/50 blur-3xl animate-float"></div>
            <div class="absolute bottom-[10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-100/50 blur-3xl animate-float-delayed"></div>
            <div class="absolute top-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-[0.05]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <div class="text-center lg:text-left reveal active">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-50 border border-orange-100 text-orange-600 text-xs font-bold tracking-wide uppercase mb-6">
                        🔥 Platform Edukasi No. 1
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
                        Tingkatkan Skill, <br>
                        <span class="gradient-text">Buka Peluang Baru.</span>
                    </h1>
                    <p class="text-slate-500 text-lg md:text-xl mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Ribuan kelas online berkualitas. Mulai dari Bisnis, Desain, Marketing, Bahasa, hingga Teknologi. Belajar kapan saja, di mana saja.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#courses" class="px-8 py-4 bg-slate-900 text-white rounded-full font-bold hover:bg-slate-800 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            Jelajahi Kelas
                        </a>
                        <a href="#categories" class="px-8 py-4 bg-white text-slate-700 border border-gray-200 rounded-full font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2 group">
                            Lihat Kategori
                        </a>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div class="relative w-full max-w-md mx-auto animate-float">
                        <div class="relative bg-white rounded-3xl p-6 shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 z-10">
                            <div class="flex items-center gap-4 mb-4 border-b border-gray-100 pb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xl">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">Sertifikat Kompetensi</h4>
                                    <p class="text-xs text-slate-500">Diterbitkan Resmi</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-2 bg-gray-100 rounded-full w-full"></div>
                                <div class="h-2 bg-gray-100 rounded-full w-3/4"></div>
                                <div class="mt-4 p-3 bg-green-50 rounded-xl flex items-center gap-3 text-green-700 text-sm font-bold">
                                    <i class="fas fa-check-circle"></i> Lulus Predikat Sempurna
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-6 -right-6 bg-white p-3 rounded-2xl shadow-xl animate-hover-side flex items-center gap-3 z-0">
                            <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600">
                                <i class="fas fa-palette"></i>
                            </div>
                            <span class="font-bold text-slate-700 pr-2">Desain</span>
                        </div>

                        <div class="absolute top-[40%] -left-12 bg-white p-3 rounded-2xl shadow-xl animate-float-delayed flex items-center gap-3 z-20">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="font-bold text-slate-700 pr-2">Bisnis</span>
                        </div>

                        <div class="absolute -bottom-6 -right-2 bg-white p-3 rounded-2xl shadow-xl animate-float flex items-center gap-3 z-20">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                                <i class="fas fa-camera"></i>
                            </div>
                            <span class="font-bold text-slate-700 pr-2">Fotografi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 border-y border-gray-100 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="reveal">
                    <h3 class="text-3xl font-extrabold text-indigo-600">500+</h3>
                    <p class="text-slate-500 text-sm mt-1">Kelas Online</p>
                </div>
                <div class="reveal">
                    <h3 class="text-3xl font-extrabold text-pink-600">24/7</h3>
                    <p class="text-slate-500 text-sm mt-1">Akses Materi</p>
                </div>
                <div class="reveal">
                    <h3 class="text-3xl font-extrabold text-orange-600">150+</h3>
                    <p class="text-slate-500 text-sm mt-1">Mentor Ahli</p>
                </div>
                <div class="reveal">
                    <h3 class="text-3xl font-extrabold text-green-600">100k+</h3>
                    <p class="text-slate-500 text-sm mt-1">Alumni Sukses</p>
                </div>
            </div>
        </div>
    </section>

    <section id="categories" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Eksplorasi Minat Anda</h2>
                <p class="text-slate-500">Temukan kelas yang sesuai dengan passion dan kebutuhan karir Anda.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-100 hover:border-indigo-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-chart-pie text-3xl text-slate-400 group-hover:text-indigo-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-indigo-700">Bisnis</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-pink-50 border border-slate-100 hover:border-pink-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-palette text-3xl text-slate-400 group-hover:text-pink-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-pink-700">Desain</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-orange-50 border border-slate-100 hover:border-orange-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-bullhorn text-3xl text-slate-400 group-hover:text-orange-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-orange-700">Marketing</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-green-50 border border-slate-100 hover:border-green-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-utensils text-3xl text-slate-400 group-hover:text-green-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-green-700">Kuliner</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-language text-3xl text-slate-400 group-hover:text-blue-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-blue-700">Bahasa</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 hover:bg-purple-50 border border-slate-100 hover:border-purple-100 text-center transition group cursor-pointer reveal">
                    <i class="fas fa-laptop text-3xl text-slate-400 group-hover:text-purple-600 mb-3 transition"></i>
                    <h3 class="font-bold text-slate-700 group-hover:text-purple-700">Teknologi</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="courses" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4 reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Kelas Terpopuler</h2>
                    <p class="text-slate-500">Mulai belajar dari materi yang paling diminati saat ini.</p>
                </div>
                <a href="#" class="text-indigo-600 font-bold hover:text-indigo-800 flex items-center gap-2 group">
                    Lihat Semua Kelas <i class="fas fa-arrow-right group-hover:translate-x-1 transition"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($courses as $course)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover-card-lift flex flex-col h-full group reveal">
                    <div class="relative h-48 overflow-hidden bg-gray-200">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700" alt="{{ $course->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <i class="fas fa-book-open text-4xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-lg text-xs font-bold text-slate-800 shadow-sm uppercase tracking-wider">
                                {{ $course->level ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-1 text-yellow-500 text-xs">
                                <i class="fas fa-star"></i>
                                <span class="text-slate-500 font-bold ml-1">4.8</span>
                                <span class="text-slate-400 ml-1">(120 Review)</span>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                            <a href="{{ route('front.course.detail', $course->slug) }}">
                                {{ $course->title }}
                            </a>
                        </h3>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2 flex-1">{{ Str::limit($course->description, 80) }}</p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="text-xs font-medium text-slate-600">Instruktur</span>
                            </div>
                            <span class="text-lg font-bold text-indigo-600">
                                {{ $course->price == 0 ? 'Gratis' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <div class="inline-block p-4 rounded-full bg-slate-100 text-slate-400 mb-4">
                        <i class="fas fa-inbox text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada kelas</h3>
                    <p class="text-slate-500">Cek kembali nanti ya!</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 text-center reveal">
            <i class="fas fa-quote-left text-4xl text-indigo-100 mb-6 block mx-auto"></i>
            <h2 class="text-2xl md:text-4xl font-bold text-slate-900 mb-8 leading-relaxed">
                "Platform ini membantu saya belajar Digital Marketing dari nol sampai akhirnya bisa membuka jasa agency sendiri. Materinya mudah dipahami!"
            </h2>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Putri&background=random" alt="User">
                </div>
                <div class="text-left">
                    <p class="font-bold text-slate-900">Sarah Putri</p>
                    <p class="text-sm text-slate-500">Entrepreneur</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 relative overflow-hidden bg-slate-900">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-50%] left-[-10%] w-[800px] h-[800px] rounded-full bg-indigo-600/20 blur-[100px]"></div>
            <div class="absolute bottom-[-50%] right-[-10%] w-[800px] h-[800px] rounded-full bg-pink-600/20 blur-[100px]"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 text-center relative z-10 reveal">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">
                Mulai Perjalanan Belajar Anda
            </h2>
            <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan komunitas pembelajar terbesar. Daftar sekarang dan akses kelas pertama Anda secara gratis.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-pink-500 text-white rounded-full font-bold hover:shadow-lg hover:shadow-indigo-500/50 transition transform hover:-translate-y-1">
                    Daftar Akun Gratis
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">Ahsani<span class="text-indigo-600">Course</span></span>
                    <p class="mt-4 text-sm text-slate-500 leading-relaxed">
                        Platform edukasi untuk semua kalangan. Belajar skill baru untuk masa depan yang lebih baik.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Kategori</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-indigo-600 transition">Bisnis & Keuangan</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Teknologi</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Gaya Hidup</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Kesehatan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-indigo-600 transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Kontak</h4>
                    <p class="text-sm text-slate-500 mb-2">support@ahsanicourse.com</p>
                    <p class="text-sm text-slate-500">+62 812 3456 7890</p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 transition"><i class="fab fa-youtube text-xl"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 transition"><i class="fab fa-tiktok text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center text-sm text-slate-400">
                <p>&copy; {{ date('Y') }} AhsaniCourse. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-md', 'bg-white/90');
            } else {
                navbar.classList.remove('shadow-md', 'bg-white/90');
            }
            
            // Progress Bar
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        });

        // Scroll Reveal
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        reveal(); // Trigger on load
    </script>
</body>
</html>