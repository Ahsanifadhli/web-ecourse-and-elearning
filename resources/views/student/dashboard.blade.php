@extends('layouts.app')

@section('title', 'Ruang Belajar Saya')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Selamat Belajar, {{ Auth::user()->name }}! 🚀</h1>
        <p class="text-gray-600 mt-2">Lanjutkan progresmu hari ini sedikit demi sedikit.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
            <div class="h-40 bg-indigo-500 relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
            </div>
            <div class="p-6">
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded mb-2 inline-block">Laravel 12</span>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belajar Membuat Website Kursus</h3>
                <p class="text-gray-500 text-sm mb-4">Mulai dari nol sampai deploy. Cocok untuk pemula.</p>

                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 45%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>45% Selesai</span>
                    <span>12/24 Materi</span>
                </div>
            </div>
        </div>
    </div>
@endsection
