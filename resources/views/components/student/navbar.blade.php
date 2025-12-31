@props(['course'])

<nav class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shrink-0 z-20">
    <div class="flex items-center gap-4">
        <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="hidden sm:inline">Dashboard</span>
        </a>
        <div class="h-6 w-px bg-gray-300 mx-2"></div>
        <h1 class="font-bold text-gray-800 text-lg truncate max-w-md">{{ $course->title }}</h1>
    </div>
    <div class="flex items-center gap-3">
        <div class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
            {{ substr(Auth::user()->username ?? 'S', 0, 1) }}
        </div>
    </div>
</nav>
