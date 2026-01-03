@extends('layouts.app')

@section('title', 'Kelola Kursus')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Kursus</h2>
        <a href="{{ route('admin.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Tambah Kursus
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 text-sm font-semibold text-gray-600 w-32">Thumbnail</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Judul Kursus</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Deskripsi Singkat</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($courses as $course)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="w-24 h-16 bg-gray-100 rounded-md overflow-hidden border border-gray-200">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="p-4 font-medium text-gray-800">{{ $course->title }}</td>
                    <td class="p-4 text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($course->description, 50) }}</td>

                    <td class="p-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.courses.show', $course->id) }}"
                           class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 shadow-sm transition">
                           Lihat (Kelola Materi)
                        </a>

                        <a href="{{ route('admin.courses.edit', $course->id) }}"
                           class="px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-50 rounded hover:bg-yellow-100 border border-yellow-200 transition">
                           Edit Info
                        </a>

                        <button onclick="confirmDelete('{{ route('admin.courses.destroy', $course->id) }}')"
                                class="text-red-600 hover:text-red-900 ml-2">
                            x
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">Belum ada kursus. Yuk buat sekarang!</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection
