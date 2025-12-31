@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Hasil Kuis: {{ $quiz->title }}</h1>
            <p class="text-gray-500">KKM: <span class="font-bold text-gray-700">{{ $quiz->passing_score }}</span> | Total Peserta: {{ $attempts->count() }}</p>
        </div>
        <a href="{{ route('admin.courses.show', $quiz->material->course_id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            &larr; Kembali ke Materi
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mengerjakan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attempts as $index => $attempt)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500 font-bold">
                            #{{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold mr-3">
                                    {{ substr($attempt->user->username, 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $attempt->user->username }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $attempt->updated_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-lg font-bold {{ $attempt->score >= $quiz->passing_score ? 'text-green-600' : 'text-red-600' }}">
                                {{ $attempt->score }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($attempt->score >= $quiz->passing_score)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Lulus
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Belum Lulus
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada siswa yang mengerjakan kuis ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
