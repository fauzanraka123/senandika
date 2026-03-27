<nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-sm sticky top-0 z-50 transition-colors duration-300" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="font-serif text-xl tracking-wide text-gray-900 dark:text-gray-100 transition-opacity hover:opacity-80">
                    Senandika
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                @php
                    $menuItems = [
                        ['name' => 'Beranda', 'route' => 'home'],
                        ['name' => 'Puisi', 'route' => 'poems.index'],
                        ['name' => 'Penyair', 'route' => 'writers.index'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="group relative py-2 text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs($item['route']) ? 'text-amber-600 dark:text-amber-400' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400' }}">
                        {{ $item['name'] }}
                        <span class="absolute left-0 bottom-0 h-0.5 w-full bg-amber-500 dark:bg-amber-400 transform transition-transform duration-300 ease-in-out {{ request()->routeIs($item['route']) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                @endforeach

                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="group relative py-2 text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('dashboard') ? 'text-amber-600 dark:text-amber-400' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400' }}">
                        Beranda Penyair
                        <span class="absolute left-0 bottom-0 h-0.5 w-full bg-amber-500 dark:bg-amber-400 transform transition-transform duration-300 ease-in-out {{ request()->routeIs('dashboard') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('dashboard.profile.edit') }}" 
                       class="group relative py-2 text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('dashboard.profile.edit') ? 'text-amber-600 dark:text-amber-400' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400' }}">
                        Profil
                        <span class="absolute left-0 bottom-0 h-0.5 w-full bg-amber-500 dark:bg-amber-400 transform transition-transform duration-300 ease-in-out {{ request()->routeIs('dashboard.profile.edit') ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400 text-sm font-medium transition-colors">Masuk</a>
                    <a href="{{ route('login') }}" class="bg-amber-600 hover:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white px-5 py-2 rounded-full text-sm font-medium transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5">Tulis Puisi</a>
                @endauth

                <!-- Theme Toggle -->
                <button id="theme-toggle" type="button" class="ml-4 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <!-- Hamburger menu button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-colors" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
            @foreach($menuItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium transition-colors
                   {{ request()->routeIs($item['route']) ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    {{ $item['name'] }}
                </a>
            @endforeach

            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium transition-colors
                   {{ request()->routeIs('dashboard') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Beranda Penyair
                </a>
                <a href="{{ route('dashboard.profile.edit') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium transition-colors
                   {{ request()->routeIs('dashboard.profile.edit') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20' : 'text-gray-600 dark:text-gray-400 hover:text-amber-500 dark:hover:text-amber-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Profil
                </a>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600 dark:text-gray-400 hover:text-amber-500 hover:bg-gray-50 dark:hover:bg-gray-800">Masuk</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 mt-2 text-base font-medium text-center bg-amber-600 text-white rounded-md">Tulis Puisi</a>
            @endauth

            <div class="pt-4 pb-2 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between px-3">
                <span class="text-sm font-medium text-gray-500">Mode Tampilan</span>
                <button type="button" onclick="document.getElementById('theme-toggle').click()" class="text-gray-500 dark:text-gray-400 p-2">
                    <span class="sr-only">Toggle theme</span>
                    <!-- Simplified mobile toggle icon -->
                    <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>
                    <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>
        </div>
    </div>
</nav>
