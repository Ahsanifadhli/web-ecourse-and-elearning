<aside class="bg-gray-900 text-white w-64 min-h-screen flex flex-col transition-all duration-300"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 fixed lg:static z-50'">

    <div class="h-16 flex items-center justify-center border-b border-gray-800">
        <h2 class="text-2xl font-bold tracking-wider text-indigo-400">LMS<span class="text-white">Pro</span></h2>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">

        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('student.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-600 transition-colors {{ request()->is('*dashboard') ? 'bg-indigo-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        @if(Auth::user()->role === 'admin')
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-4 mb-2 pl-4">Administrator</p>

            <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-600 transition-colors {{ request()->routeIs('admin.courses.*') ? 'bg-indigo-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Kelola Kursus
            </a>

            <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-600 transition-colors {{ request()->routeIs('admin.students.*') ? 'bg-indigo-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Kelola Siswa
            </a>
        @endif

        @if(Auth::user()->role === 'student')
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-4 mb-2 pl-4">Siswa</p>

            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Kursus Saya
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
