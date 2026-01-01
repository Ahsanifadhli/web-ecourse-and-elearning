@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat Belajar, {{ Auth::user()->name }}! 🚀</h1>
            <p class="text-gray-500 mt-1">Lanjutkan progresmu hari ini sedikit demi sedikit.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($myCourses as $course)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition">

            <div class="h-40 bg-gray-100 relative">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-indigo-600 shadow-sm">
                        Kursus Saya
                    </span>
                </div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-1">{{ $course->title }}</h3>
                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>

                <div class="mt-auto">
                    <div class="flex justify-between items-center text-xs font-semibold text-gray-700 mb-2">
                        <span>{{ $course->progress_percentage }}% Selesai</span>
                        <span>{{ $course->completed_items }}/{{ $course->total_items }} Materi</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500"
                             style="width: {{ $course->progress_percentage }}%"></div>
                    </div>

                    <a href="{{ route('courses.show', $course->id) }}" class="block w-full text-center bg-indigo-50 text-indigo-700 font-bold py-2.5 rounded-lg hover:bg-indigo-100 transition">
                        Lanjut Belajar &rarr;
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada kursus yang diikuti</h3>
            <p class="text-gray-500 mt-1 mb-6">Ayo mulai belajar dengan bergabung di kelas pertamamu!</p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                Cari Kelas Sekarang
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
