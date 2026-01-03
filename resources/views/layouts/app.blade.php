<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kursus Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        @include('components.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            @include('components.header')
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>

            @include('components.footer')

            {{-- Overlay Mobile Sidebar --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black bg-opacity-50 lg:hidden z-40 transition-opacity"
                 style="display: none;"></div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- AREA POP-UP (Ditaruh di LUAR wrapper overflow)    --}}
    {{-- ================================================= --}}

    {{-- 1. Toast --}}
    <x-admin.toast />

    {{-- 2. Modal Delete (Wajib Ada) --}}
    <x-admin.modal-delete />


    {{-- SCRIPT ANIMASI MODAL --}}
    <script>
        function confirmDelete(url) {
            const modal = document.getElementById('deleteModal');
            const panel = document.getElementById('deleteModalPanel');
            const form = document.getElementById('deleteForm');

            if (modal && form && panel) {
                // 1. Set URL
                form.action = url;

                // 2. Animasi Masuk (Fade In)
                // Hapus state "Invisible"
                modal.classList.remove('opacity-0', 'pointer-events-none'); 
                panel.classList.remove('opacity-0', 'scale-95');
                
                // Tambah state "Visible"
                modal.classList.add('opacity-100', 'pointer-events-auto');
                panel.classList.add('opacity-100', 'scale-100');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const panel = document.getElementById('deleteModalPanel');

            if(modal && panel) {
                // 1. Animasi Keluar (Fade Out)
                // Balikin ke state "Invisible"
                modal.classList.remove('opacity-100', 'pointer-events-auto');
                panel.classList.remove('opacity-100', 'scale-100');

                modal.classList.add('opacity-0', 'pointer-events-none');
                panel.classList.add('opacity-0', 'scale-95');
            }
        }
    </script>

</body>
</html>