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
