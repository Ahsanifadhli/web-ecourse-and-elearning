<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kursus Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all duration-300">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600">Selamat Datang</h1>
            <p class="text-gray-500 mt-2">Silakan masuk untuk mulai belajar</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    placeholder="Masukkan username" value="{{ old('username') }}">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                    placeholder="Masukkan password">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 active:scale-95 transition duration-200 shadow-md">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun? Hubungi Admin.
        </div>
    </div>

</body>
</html>
