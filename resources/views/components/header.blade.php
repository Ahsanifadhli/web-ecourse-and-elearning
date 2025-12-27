<header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">

    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
    </button>

    <h1 class="text-xl font-semibold text-gray-800 hidden lg:block">@yield('title')</h1>

    <div class="relative" x-data="{ dropdownOpen: false }">
        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 focus:outline-none">
            <div class="text-right hidden md:block">
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff"
                 class="h-10 w-10 rounded-full border-2 border-indigo-100">
        </button>

        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100"
             style="display: none;">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
        </div>
    </div>
</header>
