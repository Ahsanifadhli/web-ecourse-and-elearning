@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Siswa</h1>
            <p class="text-gray-500 text-sm">Total Siswa: {{ $students->total() }}</p>
        </div>

        {{-- FORM PENCARIAN --}}
        <form action="{{ route('admin.students.index') }}" method="GET" class="w-full md:w-auto">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Cari nama atau email...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </form>
    </div>

    {{-- TABEL SISWA --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-3">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $student->email }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ $student->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">

                            {{-- TOMBOL RESET PASSWORD --}}
                            <form action="{{ route('admin.students.resetPassword', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Reset password siswa ini menjadi 12345678?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm bg-yellow-50 px-3 py-1 rounded border border-yellow-200 hover:bg-yellow-100 transition">
                                    🔑 Reset Pass
                                </button>
                            </form>

                            {{-- TOMBOL HAPUS (MODAL POP-UP) --}}
                            <button type="button" 
                                    onclick="confirmDelete('{{ route('admin.students.destroy', $student->id) }}')" 
                                    class="text-red-600 hover:text-red-800 font-medium text-sm bg-red-50 px-3 py-1 rounded border border-red-200 hover:bg-red-100 transition">
                                🗑️ Hapus
                            </button>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            Tidak ada data siswa ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
