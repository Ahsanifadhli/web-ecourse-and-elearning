{{-- resources/views/components/admin/modal-grade.blade.php --}}

<div id="gradeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    {{-- 1. Backdrop (Latar Belakang Gelap) --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" onclick="closeGradeModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">

        {{-- 2. Modal Panel --}}
        <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-gray-100">

            {{-- Header --}}
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </span>
                    Penilaian Siswa
                </h3>
                <button onclick="closeGradeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Form --}}
            <form id="gradeForm" method="POST">
                @csrf
                <div class="px-6 py-6 space-y-5">

                    {{-- Nama Siswa (Info Saja) --}}
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-wider">Siswa</span>
                        <div id="studentNameDisplay" class="text-gray-900 font-bold text-lg">Nama Siswa</div>
                    </div>

                    {{-- Input Nilai --}}
                    <div>
                        <label for="gradeInput" class="block text-sm font-bold text-gray-700 mb-1">Nilai Akhir (0-100)</label>
                        <div class="relative">
                            <input type="number" name="grade" id="gradeInput" min="0" max="100" required
                                   class="block w-full text-center text-2xl font-bold text-indigo-600 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-bold">/100</span>
                            </div>
                        </div>
                    </div>

                    {{-- Input Feedback --}}
                    <div>
                        <label for="feedbackInput" class="block text-sm font-bold text-gray-700 mb-1">Feedback / Catatan (Opsional)</label>
                        <textarea name="feedback" id="feedbackInput" rows="4"
                                  class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3"
                                  placeholder="Berikan masukan yang membangun..."></textarea>
                    </div>
                </div>

                {{-- Footer (Tombol) --}}
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Simpan Penilaian
                    </button>
                    <button type="button" onclick="closeGradeModal()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Javascript --}}
<script>
    function openGradeModal(id, name, grade, feedback) {
        const modal = document.getElementById('gradeModal');
        const form = document.getElementById('gradeForm');

        // Update Action URL Form
        let url = "{{ route('admin.submissions.grade', ':id') }}";
        form.action = url.replace(':id', id);

        // Isi Data
        document.getElementById('studentNameDisplay').innerText = name;
        document.getElementById('gradeInput').value = grade ? grade : '';
        document.getElementById('feedbackInput').value = feedback ? feedback : '';

        // Tampilkan Modal
        modal.classList.remove('hidden');
    }

    function closeGradeModal() {
        document.getElementById('gradeModal').classList.add('hidden');
    }
</script>
