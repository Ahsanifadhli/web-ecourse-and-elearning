@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm flex justify-between items-center" id="alert-success">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('alert-success').remove()" class="text-green-500 hover:text-green-700 font-bold">&times;</button>
    </div>
    @endif

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penilaian Tugas</h1>
            <p class="text-gray-500">{{ $assignment->title }}</p>
        </div>
        <a href="{{ route('admin.courses.show', $assignment->material->course_id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            &larr; Kembali ke Materi
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai & Feedback</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $sub)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-3">
                                    {{ substr($sub->user->username, 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $sub->user->username }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $sub->created_at->format('d M Y, H:i') }}
                            <br>
                            <span class="text-xs text-gray-400">{{ $sub->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openPreviewModal('{{ asset('storage/' . $sub->file_path) }}', '{{ basename($sub->file_path) }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-indigo-200 text-xs font-medium rounded-full text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat File
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.submissions.grade', $sub->id) }}" method="POST" class="flex flex-col gap-2">
                                @csrf
                                <div class="flex items-center gap-2">
                                    <input type="number" name="grade" value="{{ $sub->grade }}" placeholder="0-100" min="0" max="100" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <span class="text-sm text-gray-500">/ 100</span>
                                </div>
                                <textarea name="feedback" rows="2" placeholder="Tulis feedback..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-xs">{{ $sub->feedback }}</textarea>
                                <button type="submit" class="hidden" id="submit-{{ $sub->id }}"></button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick="document.getElementById('submit-{{ $sub->id }}').click()" class="bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 transition text-xs font-bold shadow-sm">
                                Simpan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada siswa yang mengumpulkan tugas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalPreview" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-80 backdrop-blur-sm" onclick="closeModal()"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col w-11/12 h-[90vh] transform transition-all">

            <div class="bg-white px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900" id="modalTitle">Preview Dokumen</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="flex-1 bg-gray-100 relative p-1 flex items-center justify-center overflow-hidden">
                <iframe id="previewFrame" src="" class="w-full h-full border-none shadow-sm bg-white"></iframe>

                <div id="noPreview" class="hidden text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <p class="text-lg font-medium">Preview tidak tersedia untuk format ini.</p>
                    <a id="downloadLink" href="#" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition shadow">Download File</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openPreviewModal(url, filename) {
        document.getElementById('modalPreview').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = filename;

        const frame = document.getElementById('previewFrame');
        const noPrev = document.getElementById('noPreview');
        const dlLink = document.getElementById('downloadLink');

        const ext = filename.split('.').pop().toLowerCase();

        if(['pdf', 'jpg', 'jpeg', 'png', 'mp4'].includes(ext)) {
            frame.src = url;
            frame.classList.remove('hidden');
            noPrev.classList.add('hidden');
        } else {
            frame.classList.add('hidden');
            noPrev.classList.remove('hidden');
            dlLink.href = url;
        }
    }

    function closeModal() {
        document.getElementById('modalPreview').classList.add('hidden');
        document.getElementById('previewFrame').src = '';
    }
</script>
@endsection
