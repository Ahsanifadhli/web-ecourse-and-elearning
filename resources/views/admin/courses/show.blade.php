@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex gap-6">
        <div class="w-32 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h1>
            <p class="text-gray-500 mt-1">{{ $course->description }}</p>
            <div class="mt-3">
                <a href="{{ route('courses.show', $course->id) }}" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center gap-1 w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Preview Tampilan Siswa
                </a>
            </div>
        </div>
    </div>

    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
        <form action="{{ route('admin.courses.materials.store', $course->id) }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="title" placeholder="Nama Bab Baru (Misal: Bab 1 Pendahuluan)" class="flex-1 px-4 py-2 rounded-lg border border-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700">+ Tambah Bab</button>
        </form>
    </div>

    <div class="space-y-6">
        @forelse($course->materials as $material)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">{{ $material->title }}</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.materials.submaterials.create', $material->id) }}" class="text-sm bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50 text-gray-700 transition">
                            + Video/PDF
                        </a>

                        <a href="{{ route('admin.materials.assignments.create', $material->id) }}" class="text-sm bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50 text-gray-700 transition">
                            + Tugas
                        </a>

                        <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus Bab ini beserta seluruh isinya?');">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-sm font-bold px-3 py-1">Hapus Bab</button>
                        </form>
                    </div>
                </div>

                <div class="divide-y divide-gray-100">

                    @foreach($material->subMaterials as $sub)
                        <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <span class="text-xs uppercase font-bold px-2 py-1 rounded {{ $sub->type == 'video' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $sub->type }}
                                </span>
                                <span class="text-gray-700">{{ $sub->title }}</span>
                            </div>
                            <form action="{{ route('admin.submaterials.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Hapus konten ini?');">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 font-bold px-2">&times;</button>
                            </form>
                        </div>
                    @endforeach

                    @foreach($material->assignments as $assignment)
                        <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50 border-t border-gray-100 bg-orange-50/30">
                            <div class="flex items-center gap-3">
                                <span class="text-xs uppercase font-bold px-2 py-1 rounded bg-orange-100 text-orange-700">
                                    Tugas
                                </span>
                                <span class="text-gray-700 font-medium">{{ $assignment->title }}</span>
                            </div>
                            <form action="{{ route('admin.assignments.destroy', $assignment->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 font-bold px-2">&times;</button>
                            </form>
                        </div>
                    @endforeach

                    @if($material->subMaterials->isEmpty() && $material->assignments->isEmpty())
                        <div class="px-6 py-8 text-center text-gray-400 text-sm italic">
                            Belum ada materi atau tugas di bab ini.
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-10">
                <div class="inline-block p-4 rounded-full bg-gray-100 mb-2">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p>Belum ada Bab. Silakan buat Bab pertama di atas.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
