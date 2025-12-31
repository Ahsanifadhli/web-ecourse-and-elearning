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
