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
