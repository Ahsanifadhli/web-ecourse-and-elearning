<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - LMS Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen w-full">

        <div class="hidden lg:flex w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
                 class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Register Background">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/90 to-purple-800/80 mix-blend-multiply"></div>

            <div class="relative z-10 w-full flex flex-col justify-end p-16 text-white">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h1 class="text-3xl font-bold tracking-wide">LMS Pro</h1>
                    </div>
                    <h2 class="text-4xl font-bold leading-tight mb-4">Mulai Perjalanan<br>Karirmu Disini.</h2>
                    <p class="text-indigo-100 text-lg max-w-md">
                        Bergabunglah dengan ribuan siswa lainnya dan akses materi pembelajaran terbaik sekarang juga.
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-12 lg:p-24 bg-white overflow-y-auto">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                    <p class="text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Masuk disini</a>
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:outline-none" placeholder="Contoh: Budi Santoso">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:outline-none" placeholder="budi123">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:outline-none" placeholder="budi@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:outline-none" placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:outline-none" placeholder="Ketik ulang password">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform active:scale-95 mt-4">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">atau daftar dengan</span>
                    </div>
                </div>

                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 font-medium hover:bg-gray-50 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" alt="Google">
                    Daftar dengan Google
                </a>

                <p class="mt-8 text-xs text-center text-gray-400">
                    Dengan mendaftar, Anda menyetujui <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> kami.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
