<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} - Ruang Belajar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow: hidden; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 flex-shrink-0 z-20">
        <div class="flex items-center gap-4">
            <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <h1 class="font-bold text-gray-800 text-lg truncate max-w-md">{{ $course->title }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <div class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                {{ substr(Auth::user()->username ?? 'S', 0, 1) }}
            </div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">

        <aside class="w-80 bg-white border-r border-gray-200 flex flex-col overflow-y-auto z-10 hidden md:flex">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider">Kurikulum</h3>
            </div>
            <div class="flex-1 py-2 space-y-1">
                @foreach($course->materials as $material)
                    <div class="px-5 py-2 mt-2"><h4 class="font-bold text-gray-800 text-sm">{{ $material->title }}</h4></div>

                    @foreach($material->subMaterials as $sub)
                        @php $isActive = $currentContent && $currentContent->id == $sub->id && $currentContent->content_type == 'material'; @endphp
                        <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'material', 'id' => $sub->id]) }}" class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-indigo-50 border-indigo-600' : 'border-transparent' }}">
                            <svg class="w-4 h-4 {{ $isActive ? 'text-indigo-600' : 'text-gray-400' }}" fill="{{ $sub->type == 'video' ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sub->type == 'video' ? 'M8 5v14l11-7z' : 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' }}"></path></svg>
                            <span class="text-sm {{ $isActive ? 'font-medium text-indigo-700' : 'text-gray-600' }}">{{ $sub->title }}</span>
                        </a>
                    @endforeach

                    @foreach($material->assignments as $assign)
                        @php $isActive = $currentContent && $currentContent->id == $assign->id && $currentContent->content_type == 'assignment'; @endphp
                        <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'assignment', 'id' => $assign->id]) }}" class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-orange-50 border-orange-500' : 'border-transparent' }}">
                            <svg class="w-4 h-4 {{ $isActive ? 'text-orange-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span class="text-sm {{ $isActive ? 'font-medium text-orange-700' : 'text-gray-600' }}">{{ $assign->title }}</span>
                        </a>
                    @endforeach

                    @foreach($material->quizzes as $quizItem)
                        @php $isActive = $currentContent && $currentContent->id == $quizItem->id && $currentContent->content_type == 'quiz'; @endphp
                        <a href="{{ route('courses.show', ['course' => $course->id, 'type' => 'quiz', 'id' => $quizItem->id]) }}" class="flex items-center gap-3 px-5 py-3 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'bg-purple-50 border-purple-500' : 'border-transparent' }}">
                            <svg class="w-4 h-4 {{ $isActive ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm {{ $isActive ? 'font-medium text-purple-700' : 'text-gray-600' }}">{{ $quizItem->title }}</span>
                        </a>
                    @endforeach
                @endforeach
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-8 relative">
            @if($currentContent)
                <div class="max-w-4xl mx-auto space-y-6">

                    <h2 class="text-2xl font-bold text-gray-900">{{ $currentContent->title }}</h2>

                    @if($currentContent->content_type == 'material')
                        <div class="bg-black rounded-xl overflow-hidden shadow-lg aspect-video relative flex items-center justify-center">
                            @if($currentContent->type == 'video')
                                <video src="{{ asset('storage/' . $currentContent->file_path) }}" controls autoplay class="w-full h-full object-contain"></video>
                            @elseif($currentContent->type == 'pdf')
                                <iframe src="{{ asset('storage/' . $currentContent->file_path) }}" class="w-full h-full border-none bg-white"></iframe>
                            @endif
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h3 class="font-bold text-gray-800 mb-2">Deskripsi</h3>
                            <p class="text-gray-600">{{ $currentContent->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>

                    @elseif($currentContent->content_type == 'assignment')
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-200 border-t-4 border-t-orange-500">
                            <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Instruksi Tugas
                            </h3>
                            <div class="prose max-w-none text-gray-700 bg-orange-50 p-4 rounded-lg mb-6">
                                {{ $currentContent->instruction ?? 'Kerjakan tugas ini sesuai arahan guru.' }}
                            </div>
                            <hr class="border-gray-100 my-6">

                            @php
                                $mySubmission = \App\Models\Submission::where('assignment_id', $currentContent->id)->where('user_id', Auth::id())->first();
                            @endphp

                            <h4 class="font-bold text-gray-800 mb-3">Status Pengumpulan</h4>

                            @if($mySubmission)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3 text-green-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h5 class="text-green-800 font-bold text-lg">Sudah Dikumpulkan</h5>
                                    <p class="text-green-600 text-sm mb-4">Dikirim pada: {{ $mySubmission->created_at->format('d M Y, H:i') }}</p>

                                    <button onclick="openPreviewModal('{{ asset('storage/' . $mySubmission->file_path) }}', '{{ basename($mySubmission->file_path) }}', '{{ $mySubmission->created_at->format('d M Y') }}', '{{ $mySubmission->grade ? 'Dinilai' : 'Menunggu Penilaian' }}')"
                                            class="flex items-center justify-center gap-2 text-sm text-indigo-600 bg-white hover:bg-indigo-50 border border-indigo-200 p-3 rounded-lg w-fit mx-auto mb-4 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="font-medium">Lihat Detail & Preview</span>
                                    </button>
                                    <button onclick="toggleModal('modalUpload')" class="text-sm text-gray-500 hover:text-indigo-600 hover:underline">Ingin mengganti file?</button>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-10 text-center bg-white">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <h4 class="text-gray-800 font-bold mb-1">Belum ada tugas dikumpulkan</h4>
                                    <p class="text-gray-500 text-sm mb-6">Silakan upload jawaban Anda di sini.</p>
                                    <button onclick="toggleModal('modalUpload')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg transition transform active:scale-95 flex items-center gap-2 mx-auto">
                                        Upload Dokumen
                                    </button>
                                </div>
                            @endif
                        </div>

                    @elseif($currentContent->content_type == 'quiz')
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-purple-200 border-t-4 border-t-purple-500 text-center">
                            <div class="inline-block p-4 bg-purple-100 rounded-full mb-4">
                                <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $currentContent->title }}</h2>
                            <p class="text-gray-500 mb-6">{{ $currentContent->description ?? 'Kerjakan kuis ini dengan teliti.' }}</p>

                            <div class="flex justify-center gap-6 mb-8 text-sm">
                                <div class="bg-gray-50 px-4 py-2 rounded border">
                                    <span class="block font-bold text-gray-800">{{ $currentContent->time_limit }} Menit</span>
                                    <span class="text-gray-500">Durasi</span>
                                </div>
                                <div class="bg-gray-50 px-4 py-2 rounded border">
                                    <span class="block font-bold text-gray-800">{{ $currentContent->questions->count() }} Soal</span>
                                    <span class="text-gray-500">Jumlah Soal</span>
                                </div>
                            </div>

                            @php
                                $attempt = \App\Models\QuizAttempt::where('quiz_id', $currentContent->id)->where('user_id', Auth::id())->first();
                            @endphp

                            @if($attempt)
                                <div class="bg-green-50 border border-green-200 p-6 rounded-xl max-w-md mx-auto">
                                    <h3 class="text-green-800 font-bold mb-1">Kuis Selesai</h3>
                                    <p class="text-sm text-green-600 mb-4">Anda sudah menyelesaikan kuis ini.</p>
                                    <div class="text-5xl font-extrabold text-green-600 mb-2">{{ $attempt->score }}</div>
                                    <div class="text-sm font-bold text-green-700 uppercase tracking-wide">Nilai Akhir</div>
                                </div>
                            @else
                                <a href="{{ route('student.quizzes.take', $currentContent->id) }}"
                                   onclick="return confirm('Waktu akan berjalan segera setelah tombol diklik. Siap?')"
                                   class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-purple-700 shadow-lg transition transform hover:scale-105">
                                   Mulai Kuis Sekarang
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-6">
                        @if($prevContent)
                            <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $prevContent->content_type, 'id' => $prevContent->id]) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">&larr; Sebelumnya</a>
                        @else <div></div> @endif
                        @if($nextContent)
                            <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $nextContent->content_type, 'id' => $nextContent->id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Selanjutnya &rarr;</a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Selesai Kursus ✓</a>
                        @endif
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full text-center text-gray-500"><p>Belum ada materi.</p></div>
            @endif
        </main>
    </div>

    @if($currentContent && $currentContent->content_type == 'assignment')
    <div id="modalUpload" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" onclick="toggleModal('modalUpload')"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-xl mx-auto rounded-xl shadow-2xl z-50 overflow-y-auto transform transition-all scale-95 duration-300">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Upload Dokumen</h3>
                <div class="cursor-pointer" onclick="toggleModal('modalUpload')"><svg class="fill-current text-gray-500 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path></svg></div>
            </div>
            <div class="px-6 py-6">
                <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 flex flex-col items-center justify-center text-center transition hover:bg-gray-50 hover:border-indigo-400 group relative">
                    <input type="file" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileSelect(this)">
                    <div id="emptyState">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="text-gray-600 text-sm mb-1">Seret file ke sini atau klik untuk memilih file</p>
                        <p class="text-xs text-gray-400 mb-4">File maksimal 50MB</p>
                        <button class="bg-green-100 text-green-700 px-4 py-1.5 rounded-lg text-sm font-semibold hover:bg-green-200 transition pointer-events-none">Pilih File</button>
                    </div>
                    <div id="filePreview" class="hidden w-full">
                        <div class="bg-white border border-gray-200 rounded-lg p-3 flex items-center gap-3 relative shadow-sm">
                            <div class="bg-indigo-50 p-2 rounded text-indigo-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                            <div class="flex-1 text-left overflow-hidden">
                                <p id="fileName" class="text-sm font-bold text-gray-800 truncate">doc.pdf</p>
                                <p id="fileSize" class="text-xs text-gray-500">2.5 MB</p>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2 overflow-hidden"><div id="progressBar" class="bg-green-500 h-1.5 rounded-full" style="width: 0%"></div></div>
                            </div>
                            <button onclick="removeFile(event)" class="text-gray-400 hover:text-red-500 p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl">
                <button onclick="toggleModal('modalUpload')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm font-medium">Batal</button>
                <button id="uploadBtn" onclick="uploadFile()" class="px-6 py-2 bg-green-500 text-white rounded-lg text-sm font-bold hover:bg-green-600 shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>Upload</button>
            </div>
        </div>
    </div>

    <div id="modalPreview" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-75" onclick="toggleModal('modalPreview')"></div>
        <div class="modal-container bg-white w-full md:w-11/12 lg:w-4/5 xl:max-w-6xl h-[90vh] mx-auto rounded-xl shadow-2xl z-50 overflow-hidden transform transition-all scale-95 duration-300 flex flex-col">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 bg-white z-10">
                <h3 class="font-bold text-lg text-gray-800">Preview Dokumen</h3>
                <div class="cursor-pointer p-2 hover:bg-gray-100 rounded-full transition" onclick="toggleModal('modalPreview')"><svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>
            </div>
            <div class="flex flex-col md:flex-row h-full overflow-hidden">
                <div class="w-full md:w-1/3 bg-gray-50 p-6 border-r border-gray-200 overflow-y-auto">
                    <h4 class="font-bold text-gray-900 mb-6">Informasi File</h4>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-200"><span class="text-gray-500">Nama File</span><span class="text-gray-900 font-medium text-right truncate w-40" id="previewName">-</span></div>
                        <div class="flex justify-between py-2 border-b border-gray-200"><span class="text-gray-500">Tanggal Upload</span><span class="text-gray-900 font-medium" id="previewDate">-</span></div>
                        <div class="flex justify-between py-2 border-b border-gray-200"><span class="text-gray-500">Status</span><span class="px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700" id="previewStatus">Menunggu</span></div>
                    </div>
                    <div class="mt-8 space-y-3">
                        <a id="downloadBtn" href="#" target="_blank" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-bold text-green-700 bg-green-100 border border-green-200 rounded-lg hover:bg-green-200 transition">Unduh Dokumen</a>
                        <button onclick="toggleModal('modalPreview')" class="w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Tutup Preview</button>
                    </div>
                </div>
                <div class="w-full md:w-2/3 bg-gray-200 flex items-center justify-center relative p-4">
                    <div id="loadingPreview" class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10"><svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>
                    <iframe id="previewFrame" src="" class="w-full h-full border-none shadow-lg rounded-lg bg-white" onload="document.getElementById('loadingPreview').classList.add('hidden')"></iframe>
                    <div id="noPreview" class="hidden text-center text-gray-500"><p>Preview tidak tersedia.</p></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        const uploadUrl = "{{ $currentContent && $currentContent->content_type == 'assignment' ? route('student.assignments.submit', $currentContent->id) : '#' }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let selectedFile = null;

        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            const container = modal.querySelector('.modal-container');
            modal.classList.toggle("opacity-0");
            modal.classList.toggle("pointer-events-none");
            container.classList.toggle("scale-95");
            container.classList.toggle("scale-100");
            document.body.classList.toggle("modal-active");
            if(modalID === 'modalUpload' && modal.classList.contains('opacity-0')) setTimeout(() => removeFile(), 300);
        }

        function openPreviewModal(fileUrl, fileName, fileDate, fileStatus) {
            document.getElementById('previewName').innerText = fileName;
            document.getElementById('previewDate').innerText = fileDate;
            document.getElementById('previewStatus').innerText = fileStatus;
            document.getElementById('downloadBtn').href = fileUrl;

            const ext = fileName.split('.').pop().toLowerCase();
            const frame = document.getElementById('previewFrame');
            const noPrev = document.getElementById('noPreview');
            const load = document.getElementById('loadingPreview');
            load.classList.remove('hidden');

            if (['pdf', 'jpg', 'jpeg', 'png', 'mp4'].includes(ext)) {
                frame.src = fileUrl;
                frame.classList.remove('hidden');
                noPrev.classList.add('hidden');
            } else {
                frame.src = "";
                frame.classList.add('hidden');
                noPrev.classList.remove('hidden');
                load.classList.add('hidden');
            }
            toggleModal('modalPreview');
        }

        function handleFileSelect(input) {
            if (input.files && input.files[0]) { selectedFile = input.files[0]; showUploadPreview(selectedFile); }
        }

        function showUploadPreview(file) {
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('filePreview').classList.remove('hidden');
            document.getElementById('fileName').innerText = file.name;
            document.getElementById('fileSize').innerText = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            let width = 0;
            const bar = document.getElementById('progressBar');
            const interval = setInterval(() => {
                if(width >= 100) { clearInterval(interval); document.getElementById('uploadBtn').disabled = false; }
                else { width += 10; bar.style.width = width + '%'; }
            }, 50);
        }

        function removeFile(e) {
            if(e) e.preventDefault();
            selectedFile = null;
            document.getElementById('fileInput').value = '';
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('filePreview').classList.add('hidden');
            document.getElementById('uploadBtn').disabled = true;
        }

        function uploadFile() {
            if (!selectedFile) return;
            const btn = document.getElementById('uploadBtn');
            btn.innerText = "Mengirim...";
            btn.disabled = true;
            let formData = new FormData();
            formData.append('file', selectedFile);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', uploadUrl, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function() {
                if (xhr.status == 200) window.location.reload();
                else { alert('Gagal upload.'); btn.innerText = "Upload"; btn.disabled = false; }
            };
            xhr.send(formData);
        }
    </script>
</body>
</html>
