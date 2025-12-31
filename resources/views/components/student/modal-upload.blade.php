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
