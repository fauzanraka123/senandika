<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Senandika</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900 font-sans h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1A1A1A] text-white flex flex-col h-full shadow-xl">
        <div class="p-6 border-b border-stone-800">
            <a href="/" class="text-2xl font-serif text-[#C9A27C] tracking-tight hover:opacity-80 transition-opacity">Senandika</a>
            <p class="text-[10px] text-stone-500 uppercase tracking-widest mt-1 font-semibold">Administrator Panel</p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-stone-800 text-[#C9A27C] font-semibold' : 'text-stone-400 hover:bg-stone-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Overview
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-stone-800 text-[#C9A27C] font-semibold' : 'text-stone-400 hover:bg-stone-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Categories
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-stone-800 text-[#C9A27C] font-semibold' : 'text-stone-400 hover:bg-stone-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-stone-400 hover:bg-stone-800 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Comments
            </a>
            
            <div class="pt-6">
                <p class="text-[10px] text-stone-600 uppercase tracking-widest px-3 mb-2 font-bold">Quick Switch</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-stone-400 hover:text-[#C9A27C] transition-colors text-sm">
                    Kembali ke Halaman Penulis
                </a>
            </div>
        </nav>
        
        <div class="p-4 border-t border-stone-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-stone-500 hover:bg-red-500 hover:text-white transition-colors text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout Admin
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-stone-200 h-16 flex items-center px-8 z-10 sticky top-0 shadow-sm">
            <h1 class="text-xl font-bold text-stone-800">@yield('header', 'Admin Panel')</h1>
            <div class="ml-auto flex items-center gap-4">
                <span class="text-sm font-medium text-stone-500">{{ auth()->user()->name }}</span>
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="w-8 h-8 rounded-full border border-stone-200">
                @endif
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 bg-stone-50">
            <div class="max-w-7xl mx-auto space-y-8">
                @yield('content')
            </div>
        </div>
    </main>

</body>
</html>
