@extends('layouts.app')

@section('content')
<div class="space-y-8">

    {{-- BAGIAN 1: HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Pantau perkembangan kursus dan aktivitas siswa di sini.</p>
        </div>
        <div class="text-right">
            <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg font-bold text-sm">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- BAGIAN 2: KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card 1: Total Siswa --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</h3>
            </div>
        </div>

        {{-- Card 2: Total Kursus --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Kursus</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</h3>
            </div>
        </div>

        {{-- Card 3: Pintasan Cepat --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-2xl shadow-lg text-white flex flex-col justify-center items-start">
            <h3 class="font-bold text-lg mb-1">Tambah Materi Baru?</h3>
            <p class="text-indigo-100 text-sm mb-4">Update konten pembelajaran sekarang.</p>
            <a href="{{ route('admin.courses.index') }}" class="bg-white text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                Kelola Kursus &rarr;
            </a>
        </div>
    </div>

    {{-- BAGIAN 3: AKTIVITAS TERBARU (Live Feed) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Aktivitas Kuis Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Siswa</th>
                        <th class="px-6 py-3">Kuis</th>
                        <th class="px-6 py-3">Nilai</th>
                        <th class="px-6 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentActivities as $attempt)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-bold text-gray-700">{{ $attempt->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $attempt->quiz->title }}</td>
                        <td class="px-6 py-4">
                            @if($attempt->score >= $attempt->quiz->passing_score)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">{{ $attempt->score }} (Lulus)</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">{{ $attempt->score }} (Gagal)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $attempt->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada aktivitas kuis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
