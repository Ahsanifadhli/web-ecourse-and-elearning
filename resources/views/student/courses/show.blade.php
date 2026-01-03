<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} - Ruang Belajar</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font & Styles --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow: hidden; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden h-screen flex flex-col" x-data="{ sidebarOpen: false }">

    {{-- 1. Navbar --}}
    <x-student.navbar :course="$course" />

    <div class="flex flex-1 overflow-hidden">

        {{-- 2. Sidebar (Responsif) --}}
        <x-student.sidebar :course="$course" :currentContent="$currentContent" />

        {{-- 3. Main Content Area --}}
        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-8 relative w-full">
            
            @if($currentContent)
                <div class="max-w-4xl mx-auto space-y-6 pb-20">

                    {{-- JUDUL KONTEN --}}
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900 leading-tight">{{ $currentContent->title }}</h2>
                        <span class="text-xs font-bold px-2 py-1 rounded bg-gray-200 text-gray-600 uppercase tracking-wide">
                            {{ $currentContent->content_type == 'sub_material' ? 'Materi' : ucfirst($currentContent->content_type) }}
                        </span>
                    </div>

                    {{-- ISI KONTEN (SWITCHER) --}}
                    @if($currentContent->content_type == 'sub_material' || $currentContent->content_type == 'material')
                        <x-student.content-material :content="$currentContent" />

                    @elseif($currentContent->content_type == 'assignment')
                        <x-student.content-assignment :content="$currentContent" />

                    @elseif($currentContent->content_type == 'quiz')
                        <x-student.content-quiz :content="$currentContent" />
                    @endif


                    {{-- LOGIKA UTAMA: CEK STATUS PENGERJAAN SAAT INI --}}
                    @php
                        $isCurrentCompleted = true; // Default true (untuk materi biasa)
                        $blockMessage = '';

                        // 1. CEK JIKA KUIS
                        if ($currentContent->content_type == 'quiz') {
                            $attempt = \App\Models\QuizAttempt::where('quiz_id', $currentContent->id)
                                        ->where('user_id', auth()->id())
                                        ->orderBy('score', 'desc')
                                        ->first();

                            // Belum ngerjain ATAU nilainya jeblok = Belum Selesai
                            if (!$attempt) {
                                $isCurrentCompleted = false; 
                                $blockMessage = 'Kerjakan kuis terlebih dahulu.';
                            } elseif ($attempt->score < $currentContent->passing_score) {
                                $isCurrentCompleted = false; 
                                $blockMessage = 'Nilai Anda belum lulus KKM.';
                            }
                        }
                        
                        // 2. CEK JIKA TUGAS (ASSIGNMENT) - Opsional biar makin ketat
                        if ($currentContent->content_type == 'assignment') {
                            $submission = \App\Models\Submission::where('assignment_id', $currentContent->id)
                                            ->where('user_id', auth()->id())
                                            ->first();
                            if (!$submission) {
                                $isCurrentCompleted = false;
                                $blockMessage = 'Silakan kumpulkan tugas.';
                            }
                        }
                    @endphp


                    {{-- NAVIGATION BUTTONS --}}
                    <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-8">
                        
                        {{-- Tombol Sebelumnya --}}
                        @if($prevContent)
                            <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $prevContent->content_type, 'id' => $prevContent->id]) }}" 
                               class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
                                &larr; Sebelumnya
                            </a>
                        @else 
                            <div></div> 
                        @endif

                        {{-- Tombol Selanjutnya --}}
                        @if($nextContent)
                            @if($isCurrentCompleted)
                                <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $nextContent->content_type, 'id' => $nextContent->id]) }}" 
                                   class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition shadow-md transform hover:-translate-y-0.5">
                                    Selanjutnya &rarr;
                                </a>
                            @else
                                <div class="flex flex-col items-end group relative">
                                    <button disabled class="flex items-center gap-2 px-6 py-2.5 bg-gray-300 text-gray-500 rounded-lg font-bold cursor-not-allowed">
                                        Selanjutnya &rarr;
                                    </button>
                                    <div class="mt-2 text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded border border-red-100">
                                        ⛔ {{ $blockMessage }}
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- State Akhir --}}
                            <span class="text-sm text-gray-400 italic">Materi Terakhir</span>
                        @endif
                    </div>


                    {{-- 🏆 SERTIFIKAT AREA 🏆 --}}
                    {{-- Syarat: Tidak ada konten selanjutnya (Halaman Terakhir) DAN Konten saat ini sudah selesai --}}
                    @if(!$nextContent && $isCurrentCompleted)
                        <div class="mt-10 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-1 shadow-xl transform transition hover:scale-[1.01] animate-in fade-in slide-in-from-bottom-4 duration-700">
                            <div class="bg-white rounded-xl p-8 text-center">
                                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                                    🎓
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat! Kursus Selesai</h3>
                                <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                                    Anda telah menyelesaikan semua materi dan lulus evaluasi pada kursus <strong>{{ $course->title }}</strong>.
                                </p>
                                
                                <a href="{{ route('student.certificate.download', $course->id) }}" 
                                   class="inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:-translate-y-1 hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Download Sertifikat Digital
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    {{-- ALERT KALAU BELUM SELESAI DI HALAMAN TERAKHIR --}}
                    @if(!$nextContent && !$isCurrentCompleted)
                        <div class="mt-10 bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                            <h3 class="font-bold text-yellow-800 mb-1">Hampir Selesai!</h3>
                            <p class="text-sm text-yellow-700 mb-4">Selesaikan tugas/kuis di atas untuk membuka Sertifikat Anda.</p>
                            <span class="inline-block bg-gray-200 text-gray-400 font-bold py-2 px-6 rounded-full cursor-not-allowed">
                                🔒 Sertifikat Terkunci
                            </span>
                        </div>
                    @endif

                </div>
            @else
                {{-- State Kosong --}}
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <img src="https://illustrations.popsy.co/gray/surr-searching.svg" class="w-64 h-64 opacity-50 mb-4">
                    <h3 class="text-xl font-bold text-gray-700">Belum ada materi</h3>
                </div>
            @endif
        </main>
    </div>

    {{-- 4. Modals --}}
    @if($currentContent && $currentContent->content_type == 'assignment')
        <x-student.modal-upload />
        <x-student.modal-preview />
    @endif

    {{-- 5. Javascript --}}
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
            
            frame.classList.add('hidden');
            noPrev.classList.add('hidden');
            load.classList.remove('hidden');

            if (['pdf', 'jpg', 'jpeg', 'png', 'mp4'].includes(ext)) {
                frame.src = fileUrl;
                frame.onload = () => { load.classList.add('hidden'); frame.classList.remove('hidden'); };
            } else {
                load.classList.add('hidden');
                noPrev.classList.remove('hidden');
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
                else { alert('Gagal upload. Cek ukuran file/koneksi.'); btn.innerText = "Upload Tugas"; btn.disabled = false; }
            };
            xhr.send(formData);
        }
    </script>
</body>
</html>