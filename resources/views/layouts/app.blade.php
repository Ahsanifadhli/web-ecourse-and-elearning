<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kursus Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine JS (Wajib untuk sidebar & dropdown) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        {{-- 1. SIDEBAR --}}
        @include('components.sidebar')

        {{-- 2. WRAPPER KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            {{-- Header --}}
            @include('components.header')

            {{-- Main Content (Area Scrollable) --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('components.footer')

            {{-- Overlay untuk Mobile saat Sidebar terbuka --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black bg-opacity-50 lg:hidden z-40 transition-opacity"
                 style="display: none;"></div>
        </div>

    </div>

    {{-- 3. TOAST NOTIFICATION (Ditaruh paling luar biar posisinya fixed aman) --}}
    <x-admin.toast />

</body>
</html>