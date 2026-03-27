@extends('layouts.dashboard')

@section('title', 'Beranda')
@section('header', 'Ringkasan Ruang Penulis')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white dark:bg-[#151515] p-6 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm transition-colors">
            <p class="text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em] mb-3">Total Karya</p>
            <div class="flex items-end justify-between">
                <span class="text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA]">{{ number_format($stats['total_poems']) }}</span>
                <span class="text-xs text-stone-500 font-medium pb-1">{{ $stats['published_poems'] }} Terbit</span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#151515] p-6 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm transition-colors">
            <p class="text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em] mb-3">Total Lihat</p>
            <div class="flex items-end justify-between">
                <span class="text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA]">{{ number_format($stats['total_views']) }}</span>
                <div class="bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 px-2 py-0.5 rounded text-[10px] font-bold">Live</div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#151515] p-6 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm transition-colors">
            <p class="text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em] mb-3">Total Suka</p>
            <div class="flex items-end justify-between">
                <span class="text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA]">{{ number_format($stats['total_likes']) }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-[#151515] p-6 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm transition-colors">
            <p class="text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em] mb-3">Pengikut</p>
            <div class="flex items-end justify-between">
                <span class="text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA]">{{ number_format($stats['followers_count']) }}</span>
                <a href="{{ route('writers.index') }}" class="text-[10px] text-[#8B5E3C] dark:text-[#C9A27C] hover:underline font-bold uppercase tracking-widest">Kembangkan</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Poems -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Karya Saya</h2>
                <a href="{{ route('dashboard.poems.index') }}" class="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>

            @if($recentPoems->count() > 0)
                <div class="bg-white dark:bg-[#151515] rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm overflow-hidden transition-colors">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-stone-50 dark:bg-stone-900/50 border-b border-stone-100 dark:border-stone-800">
                                <th class="px-6 py-4 text-[10px] font-bold text-stone-400 uppercase tracking-widest">Judul</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-stone-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-stone-400 uppercase tracking-widest">Penayangan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-stone-400 uppercase tracking-widest"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                            @foreach($recentPoems as $poem)
                                <tr class="hover:bg-stone-50 dark:hover:bg-stone-900 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{{ $poem->title }}</p>
                                        <p class="text-[10px] text-stone-400 mt-1 uppercase tracking-widest">{{ $poem->created_at->format('M d, Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest {{ $poem->status === 'published' ? 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400' : 'bg-stone-100 text-stone-500 dark:bg-stone-800 dark:text-stone-400' }}">
                                            {{ $poem->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-stone-500 dark:text-stone-400 font-medium">
                                        {{ number_format($poem->views) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('dashboard.poems.edit', $poem) }}" class="text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white dark:bg-[#151515] p-12 rounded-2xl border border-stone-200 dark:border-stone-800 text-center shadow-sm">
                    <p class="font-serif text-lg text-stone-400 italic mb-6">Abadikan bait pertamamu hari ini.</p>
                    <a href="{{ route('dashboard.poems.create') }}" class="inline-block px-8 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-full font-bold shadow-sm hover:opacity-90 transition-opacity">Mulai Menulis</a>
                </div>
            @endif
        </div>

        <!-- Follow Feed Sidebar -->
        <div class="space-y-6">
            <h2 class="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Feed Karya</h2>
            
            @if($socialFeed->count() > 0)
                <div class="space-y-4">
                    @foreach($socialFeed as $item)
                        <div class="bg-white dark:bg-[#151515] p-5 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm hover:shadow-md transition-all">
                            <div class="flex items-center gap-3 mb-4">
                                @if($item->user->avatar)
                                    <img src="{{ $item->user->avatar }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-400 font-serif text-sm">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA] truncate">{{ $item->user->name }}</p>
                                    <p class="text-[9px] text-stone-400 uppercase tracking-widest">{{ $item->published_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('poems.show', $item->slug) }}" class="block group">
                                <h3 class="font-serif font-bold text-stone-800 dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors line-clamp-1 mb-2">{{ $item->title }}</h3>
                                <p class="text-sm text-stone-500 dark:text-stone-400 line-clamp-2 italic font-serif">"{{ \Illuminate\Support\Str::limit($item->content, 100) }}"</p>
                            </a>
                        </div>
                    @endforeach
                    <a href="{{ route('feed.index') }}" class="block text-center py-3 bg-stone-100 dark:bg-stone-900 rounded-xl text-xs font-bold text-stone-600 dark:text-stone-400 uppercase tracking-widest hover:bg-[#8B5E3C] hover:text-white dark:hover:bg-[#C9A27C] dark:hover:text-[#1A1A1A] transition-all">Lihat Semua Feed</a>
                </div>
            @else
                <div class="bg-white dark:bg-[#151515] p-8 rounded-2xl border border-stone-200 dark:border-stone-800 text-center shadow-sm">
                    <p class="text-sm text-stone-400 mb-6 italic">Ikuti penyair lain untuk melihat karya terbaru mereka di sini.</p>
                    <a href="{{ route('writers.index') }}" class="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest hover:underline">Jelajahi Penyair</a>
                </div>
            @endif
        </div>
    </div>
@endsection
