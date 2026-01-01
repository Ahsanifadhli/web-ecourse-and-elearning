<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen w-full">

        <div class="hidden lg:flex w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80"
                 class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Learning Background">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/90 to-purple-800/80 mix-blend-multiply"></div>

            <div class="relative z-10 w-full flex flex-col justify-end p-16 text-white">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h1 class="text-3xl font-bold tracking-wide">LMS Pro</h1>
                    </div>
                    <h2 class="text-4xl font-bold leading-tight mb-4">Tingkatkan Skill Codingmu<br>Bersama Kami!</h2>
                    <p class="text-indigo-100 text-lg max-w-md">
                        Akses materi berkualitas, kerjakan tugas real-project, dan dapatkan sertifikat kompetensi.
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-12 lg:p-24 bg-white">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk</h2>
                    <p class="text-gray-500">
                        Pengguna baru?
                        <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Buat akun disini</a>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required autofocus
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition outline-none"
                            placeholder="Masukan email atau username">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition outline-none pr-10"
                                placeholder="Masukan password">

                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="#" class="text-sm font-medium text-gray-500 hover:text-indigo-600 underline">Lupa password?</a>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform active:scale-95">
                        Masuk Sekarang
                    </button>

                    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 font-medium hover:bg-gray-50 transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" alt="Google">
                        Masuk dengan Google
                    </a>
                </form>

                <p class="mt-8 text-xs text-center text-gray-400">
                    &copy; 2026 LMS Pro.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('text-indigo-600');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('text-indigo-600');
            }
        }
    </script>
</body>
</html>
