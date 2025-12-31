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

    {{-- 1. Navbar Component --}}
    <x-student.navbar :course="$course" />

    <div class="flex flex-1 overflow-hidden">

        {{-- 2. Sidebar Component --}}
        <x-student.sidebar :course="$course" :currentContent="$currentContent" />

        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-8 relative">
            @if($currentContent)
                <div class="max-w-4xl mx-auto space-y-6">

                    <h2 class="text-2xl font-bold text-gray-900">{{ $currentContent->title }}</h2>

                    {{-- 3. Content Switcher Components --}}
                    @if($currentContent->content_type == 'material')
                        <x-student.content-material :content="$currentContent" />

                    @elseif($currentContent->content_type == 'assignment')
                        <x-student.content-assignment :content="$currentContent" />

                    @elseif($currentContent->content_type == 'quiz')
                        <x-student.content-quiz :content="$currentContent" />
                    @endif

                    {{-- Navigation Buttons --}}
                    <div class="flex justify-between items-center pt-6">
                        @if($prevContent)
                            <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $prevContent->content_type, 'id' => $prevContent->id]) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">&larr; Sebelumnya</a>
                        @else <div></div> @endif

                        @if($nextContent)
                            {{-- LOGIC BLOCKING NEXT BUTTON --}}
                            @php
                                $canProceed = true;
                                $blockMessage = '';

                                // Cek jika konten saat ini adalah Kuis
                                if ($currentContent->content_type == 'quiz') {
                                    $attempt = \App\Models\QuizAttempt::where('quiz_id', $currentContent->id)->where('user_id', Auth::id())->first();

                                    if (!$attempt) {
                                        $canProceed = false; // Belum ngerjain sama sekali
                                        $blockMessage = 'Kerjakan kuis terlebih dahulu.';
                                    } elseif ($attempt->score < $currentContent->passing_score) {
                                        $canProceed = false; // Udah ngerjain tapi gak lulus
                                        $blockMessage = 'Anda harus lulus kuis ini untuk lanjut.';
                                    }
                                }
                            @endphp

                            @if($canProceed)
                                <a href="{{ route('courses.show', ['course' => $course->id, 'type' => $nextContent->content_type, 'id' => $nextContent->id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md">Selanjutnya &rarr;</a>
                            @else
                                <div class="flex flex-col items-end">
                                    <button disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium">Selanjutnya &rarr;</button>
                                    <span class="text-xs text-red-500 mt-1">{{ $blockMessage }}</span>
                                </div>
                            @endif
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

    {{-- 4. Modals --}}
    @if($currentContent && $currentContent->content_type == 'assignment')
        <x-student.modal-upload />
        <x-student.modal-preview />
    @endif

    {{-- Javascript (Disimpan di sini karena menyangkut logika global halaman) --}}
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
