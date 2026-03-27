<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - Senandika</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,300..700;1,300..700&family=Inter:ital,opsz,wght@0,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-[#F8F6F2] dark:bg-[#0F0F0F] text-[#1A1A1A] dark:text-[#EAEAEA] font-sans h-full flex overflow-hidden transition-colors duration-300">
    
    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity duration-300 opacity-0" onclick="toggleMenu()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 w-64 bg-white dark:bg-[#151515] border-r border-stone-200 dark:border-stone-800 flex flex-col h-full z-40 transition-transform duration-300 transform -translate-x-full md:translate-x-0 transition-colors duration-300">
        <div class="p-6 border-b border-stone-100 dark:border-stone-800">
            <a href="/" class="text-2xl font-serif text-[#8B5E3C] dark:text-[#C9A27C] tracking-tight hover:opacity-80 transition-opacity">Senandika</a>
            <p class="text-[10px] text-stone-400 uppercase tracking-[0.2em] mt-1 font-bold">Ruang Penulis</p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
            <div class="pb-4">
                <p class="px-3 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-widest mb-2">Personal</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('feed.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('feed.index') ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Beranda Penyair
                </a>
                <a href="{{ route('writers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('writers.index') ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Penyair
                </a>
            </div>

            <div class="pb-4">
                <p class="px-3 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-widest mb-2">Menulis</p>
                <a href="{{ route('dashboard.poems.create') }}" class="flex items-center justify-between px-3 py-2 rounded-xl bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] font-bold shadow-sm hover:opacity-90 mb-2 transition-all">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tulis Puisi
                    </span>
                </a>
                <a href="{{ route('dashboard.poems.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('dashboard.poems.index') ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Puisi Saya
                </a>
                <a href="{{ route('dashboard.poems.index', ['status' => 'draft']) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->query('status') === 'draft' ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    Draf Puisi
                </a>
            </div>

            <div class="pt-4 mt-auto">
                <p class="px-3 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-widest mb-2">Akun</p>
                <a href="{{ route('dashboard.profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('dashboard.profile.edit') ? 'bg-[#8B5E3C]/10 text-[#8B5E3C] dark:text-[#C9A27C] font-semibold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </a>
                <button id="theme-toggle" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-stone-600 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900 transition-all">
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <span>Tampilan</span>
                </button>
            </div>
        </nav>
        
        <div class="p-6 border-t border-stone-100 dark:border-stone-800 bg-stone-50 dark:bg-[#1A1A1A] transition-colors duration-300">
            <div class="flex items-center gap-3 mb-4">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-[#8B5E3C] text-white flex items-center justify-center font-serif text-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-stone-900 dark:text-[#EAEAEA] truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-stone-400 uppercase tracking-widest">{{ auth()->user()->role }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-stone-500 hover:bg-red-500 hover:text-white transition-all text-sm font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#F0EBE3] dark:bg-[#0A0A0A] transition-colors duration-300">
        <!-- Header -->
        <header class="bg-white/70 dark:bg-[#0F0F0F]/70 backdrop-blur-md border-b border-stone-200 dark:border-stone-800 h-16 flex items-center px-4 md:px-8 z-10 sticky top-0 justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleMenu()" class="md:hidden p-2 text-stone-600 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-900 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-serif font-medium text-stone-800 dark:text-[#EAEAEA]">@yield('header', 'Beranda')</h1>
            </div>
            <div class="flex items-center gap-4">
                @stack('header-actions')
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        function toggleMenu() {
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                    overlay.classList.remove('opacity-0');
                }, 10);
                document.body.classList.add('overflow-hidden');
            } else {
                // Close
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
                document.body.classList.remove('overflow-hidden');
            }
        }

        var themeToggleBtn = document.getElementById('theme-toggle');
        
        if(themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
