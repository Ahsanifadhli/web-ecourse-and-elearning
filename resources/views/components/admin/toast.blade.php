@if (session('success') || session('error'))
    <div id="toast-notification"
         class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-3 text-gray-500 bg-white rounded-lg shadow-xl border-l-4 {{ session('success') ? 'border-green-500' : 'border-red-500' }} transform transition-all duration-500 translate-x-full opacity-0"
         role="alert">

        {{-- IKON --}}
        @if (session('success'))
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            </div>
        @else
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>
            </div>
        @endif

        {{-- PESAN TEKS --}}
        <div class="ml-3 text-sm font-normal text-gray-800">
            <span class="font-bold block">{{ session('success') ? 'Berhasil!' : 'Gagal!' }}</span>
            {{ session('success') ?? session('error') }}
        </div>

        {{-- TOMBOL CLOSE MANUAL --}}
        <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>

    {{-- SCRIPT ANIMASI --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toast = document.getElementById('toast-notification');

            // 1. Munculkan (Slide In)
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);

            // 2. Hilangkan Otomatis setelah 4 Detik
            setTimeout(() => {
                closeToast();
            }, 4000);
        });

        function closeToast() {
            const toast = document.getElementById('toast-notification');
            // Slide Out
            toast.classList.add('translate-x-full', 'opacity-0');
            // Hapus dari DOM setelah animasi selesai
            setTimeout(() => {
                toast.remove();
            }, 500);
        }
    </script>
@endif
