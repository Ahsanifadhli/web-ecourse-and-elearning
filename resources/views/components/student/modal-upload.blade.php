<div id="modalUpload" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50" onclick="toggleModal('modalUpload')"></div>

    {{-- Modal Content --}}
    <div class="modal-container bg-white w-full max-w-2xl rounded-2xl shadow-2xl z-50 overflow-hidden transform scale-95 transition-transform duration-300">

        {{-- Header --}}
        <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg">Kirim Tugas</h3>
            <button onclick="toggleModal('modalUpload')" class="text-indigo-200 hover:text-white">&times;</button>
        </div>

        {{-- Form --}}
        <div class="p-6">
            <form id="uploadForm" onsubmit="submitTask(event)">

                {{-- OPSI 1: KETIK TEKS (ONLINE TEXT) --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">1. Jawaban Teks (Opsional)</label>
                    <textarea id="textInput" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ketik jawaban Anda di sini jika tidak ingin upload file..."></textarea>
                </div>

                <div class="flex items-center gap-4 mb-4">
                    <div class="h-px bg-gray-300 flex-1"></div>
                    <span class="text-gray-400 text-sm font-medium">DAN / ATAU</span>
                    <div class="h-px bg-gray-300 flex-1"></div>
                </div>

                {{-- OPSI 2: UPLOAD FILE (VIDEO/GAMBAR/DOC) --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">2. Upload File (Opsional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition relative" id="dropZone">

                        <input type="file" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileSelect(this)">

                        <div id="emptyState">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-gray-600 font-medium">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">Bisa Gambar, Video (MP4), PDF, Word, atau ZIP.</p>
                        </div>

                        {{-- Preview File Terpilih --}}
                        <div id="filePreview" class="hidden">
                            <div class="flex items-center gap-3 bg-indigo-50 p-3 rounded-lg text-left">
                                <div class="bg-indigo-100 p-2 rounded text-indigo-600">📎</div>
                                <div class="flex-1 min-w-0">
                                    <p id="fileName" class="text-sm font-bold text-gray-800 truncate">filename.pdf</p>
                                    <p id="fileSize" class="text-xs text-gray-500">2 MB</p>
                                </div>
                                <button type="button" onclick="removeFile(event)" class="text-red-400 hover:text-red-600">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Kirim --}}
                <div class="flex justify-end pt-4 border-t">
                    <button type="button" onclick="toggleModal('modalUpload')" class="text-gray-500 font-bold px-4 py-2 mr-2 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" id="uploadBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded-lg shadow-md transition">
                        Kirim Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script Khusus untuk handle kirim data (File + Teks)
    function submitTask(e) {
        e.preventDefault();

        const fileInput = document.getElementById('fileInput');
        const textInput = document.getElementById('textInput');
        const btn = document.getElementById('uploadBtn');

        // Validasi: Minimal salah satu harus diisi
        if (!selectedFile && textInput.value.trim() === "") {
            alert("Harap isi jawaban teks ATAU upload file.");
            return;
        }

        btn.innerText = "Mengirim...";
        btn.disabled = true;

        let formData = new FormData();
        // Masukkan File (Kalau ada)
        if (selectedFile) {
            formData.append('file', selectedFile);
        }
        // Masukkan Teks (Kalau ada)
        if (textInput.value.trim() !== "") {
            formData.append('text_submission', textInput.value);
        }

        // Kirim via AJAX
        let xhr = new XMLHttpRequest();
        xhr.open('POST', uploadUrl, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Ambil dari layout utama

        xhr.onload = function() {
            if (xhr.status == 200) {
                alert('Tugas berhasil dikirim!');
                window.location.reload();
            } else {
                alert('Gagal mengirim tugas. Cek koneksi atau ukuran file.');
                btn.innerText = "Kirim Tugas";
                btn.disabled = false;
            }
        };
        xhr.send(formData);
    }
</script>
