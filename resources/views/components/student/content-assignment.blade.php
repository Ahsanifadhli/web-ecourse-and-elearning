@props(['content'])

<div class="bg-white p-6 rounded-xl shadow-sm border border-orange-200 border-t-4 border-t-orange-500">
    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Instruksi Tugas
    </h3>
    <div class="prose max-w-none text-gray-700 bg-orange-50 p-4 rounded-lg mb-6">
        {{ $content->instruction ?? 'Kerjakan tugas ini sesuai arahan guru.' }}
    </div>
    <hr class="border-gray-100 my-6">

    @php
        $mySubmission = \App\Models\Submission::where('assignment_id', $content->id)->where('user_id', Auth::id())->first();
    @endphp

    <h4 class="font-bold text-gray-800 mb-3">Status Pengumpulan</h4>

    @if($mySubmission)
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">

            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <div class="flex-1 w-full md:w-auto">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h5 class="text-green-800 font-bold text-lg">Sudah Dikumpulkan</h5>
                    <p class="text-green-600 text-sm mb-4">Dikirim pada: {{ $mySubmission->created_at->format('d M Y, H:i') }}</p>

                    <button onclick="openPreviewModal('{{ asset('storage/' . $mySubmission->file_path) }}', '{{ basename($mySubmission->file_path) }}', '{{ $mySubmission->created_at->format('d M Y') }}', '{{ $mySubmission->grade ? 'Dinilai' : 'Menunggu Penilaian' }}')"
                            class="flex items-center justify-center gap-2 text-sm text-indigo-600 bg-white hover:bg-indigo-50 border border-indigo-200 p-3 rounded-lg w-full mb-2 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span class="font-medium">Lihat File Saya</span>
                    </button>

                    @if(is_null($mySubmission->grade))
                        <button onclick="toggleModal('modalUpload')" class="text-sm text-gray-500 hover:text-indigo-600 hover:underline">Ingin mengganti file?</button>
                    @endif
                </div>

                @if(!is_null($mySubmission->grade))
                <div class="flex-1 w-full md:w-auto bg-white border border-green-200 rounded-xl p-5 shadow-sm">
                    <h5 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Nilai Anda</h5>
                    <div class="text-5xl font-extrabold text-green-600 mb-4">{{ $mySubmission->grade }}<span class="text-xl text-gray-400 font-normal">/100</span></div>

                    <div class="text-left bg-gray-50 p-3 rounded border border-gray-100">
                        <span class="text-xs font-bold text-gray-500 block mb-1">Catatan Guru:</span>
                        <p class="text-sm text-gray-700 italic">"{{ $mySubmission->feedback ?? 'Tidak ada catatan tambahan.' }}"</p>
                    </div>
                </div>
                @else
                <div class="flex-1 w-full md:w-auto bg-gray-50 border border-gray-200 rounded-xl p-5 flex flex-col items-center justify-center opacity-70">
                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-gray-500 font-medium">Menunggu Penilaian</span>
                </div>
                @endif

            </div>

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
