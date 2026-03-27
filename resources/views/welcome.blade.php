@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Main Feed (Left Column) -->
            <div class="lg:w-2/3 space-y-12">
                
                <!-- Section 3: Puisi dari Penyair yang Diikuti (Conditional) -->
                @auth
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-gray-100">Dari Penyair yang Kamu Ikuti</h2>
                        </div>
                        
                        @if($followingPoems->count() > 0)
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($followingPoems as $poem)
                                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-3 mb-4">
                                            @if($poem->user->avatar)
                                                <img src="{{ $poem->user->avatar }}" class="w-8 h-8 rounded-full">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center text-amber-600 dark:text-amber-400 font-serif text-sm">
                                                    {{ substr($poem->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $poem->user->name }}</span>
                                            <span class="text-gray-400">•</span>
                                            <span class="text-xs text-gray-500">{{ $poem->published_at ? $poem->published_at->diffForHumans() : 'Baru saja' }}</span>
                                        </div>
                                        <a href="{{ route('poems.show', $poem->slug) }}" class="block group">
                                            <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 transition-colors mb-2">
                                                {{ $poem->title }}
                                            </h3>
                                            <p class="font-serif leading-relaxed text-gray-700 dark:text-gray-400 line-clamp-3 mb-4">
                                                {{ $poem->excerpt ?? Str::limit($poem->content, 200) }}
                                            </p>
                                        </a>
                                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50 dark:border-gray-700">
                                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                                    {{ $poem->likes_count }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    {{ $poem->views }}
                                                </span>
                                            </div>
                                            <a href="{{ route('poems.show', $poem->slug) }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700">Baca Selengkapnya</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-8 text-center border-2 border-dashed border-gray-200 dark:border-gray-800">
                                <p class="text-gray-600 dark:text-gray-400">Ikuti penyair untuk melihat puisi mereka di sini.</p>
                                <a href="{{ route('writers.index') }}" class="mt-4 inline-block text-amber-600 font-medium hover:underline">Temukan Penyair</a>
                            </div>
                        @endif
                    </section>
                @endauth

                <!-- Section 1: Puisi Terbaru -->
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-gray-100">Puisi Terbaru</h2>
                    </div>

                    @if($latestPoems->count() > 0)
                        <div class="space-y-8">
                            @foreach($latestPoems as $poem)
                                <article class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-all group">
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="flex items-center gap-2 group/author">
                                                    @if($poem->user->avatar)
                                                        <img src="{{ $poem->user->avatar }}" class="w-6 h-6 rounded-full">
                                                    @else
                                                        <div class="w-6 h-6 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-500 font-serif text-[10px]">
                                                            {{ substr($poem->user->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover/author:text-amber-600 transition-colors">{{ $poem->user->name }}</span>
                                                </a>
                                                <span class="text-gray-300 dark:text-gray-600">•</span>
                                                <span class="text-xs text-gray-500">{{ $poem->published_at ? $poem->published_at->format('d M Y') : 'Baru' }}</span>
                                            </div>

                                            <a href="{{ route('poems.show', $poem->slug) }}" class="block">
                                                <h3 class="text-2xl font-serif font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 transition-colors mb-3">
                                                    {{ $poem->title }}
                                                </h3>
                                                <p class="font-serif leading-relaxed text-gray-700 dark:text-gray-400 mb-6 line-clamp-3">
                                                    {{ $poem->excerpt ?? Str::limit($poem->content, 200) }}
                                                </p>
                                            </a>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-6 text-sm text-gray-500">
                                                    <span class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                                        {{ $poem->likes_count }}
                                                    </span>
                                                    <span class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        {{ $poem->views }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('poems.show', $poem->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-amber-600 hover:text-white dark:hover:bg-amber-600 transition-all">
                                                    Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $latestPoems->links() }}
                        </div>
                    @else
                        <div class="py-20 text-center">
                            <p class="text-xl font-serif text-gray-500 italic">Belum ada puisi yang dipublikasikan.</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Sidebar (Right Column) -->
            <aside class="lg:w-1/3 space-y-12">
                
                <!-- Section 2: Puisi Populer -->
                <section>
                    <h2 class="text-xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/></svg>
                        Puisi Populer
                    </h2>
                    <div class="space-y-4">
                        @foreach($popularPoems as $poem)
                            <a href="{{ route('poems.show', $poem->slug) }}" class="block group p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-amber-200 dark:hover:border-amber-900 transition-all shadow-sm">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 transition-colors mb-1 line-clamp-1">
                                    {{ $poem->title }}
                                </h3>
                                <p class="text-xs text-gray-500 mb-2">oleh {{ $poem->user->name }}</p>
                                <div class="flex items-center gap-3 text-[10px] text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                        {{ $poem->likes_count }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{ $poem->views }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <!-- Section 4: Sidebar Penyair -->
                <section>
                    <h2 class="text-xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3.005 3.005 0 013.75-2.906z"/></svg>
                        Penyair Populer
                    </h2>
                    <div class="space-y-6">
                        @foreach($topWriters as $writer)
                            <div class="flex items-center justify-between group">
                                <a href="{{ route('authors.show', $writer->username ?: $writer->id) }}" class="flex items-center gap-3">
                                    @if($writer->avatar)
                                        <img src="{{ $writer->avatar }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-900 flex items-center justify-center text-amber-600 dark:text-amber-400 font-serif font-bold">
                                            {{ substr($writer->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-amber-600 transition-colors">{{ $writer->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $writer->followers_count }} Pengikut</p>
                                    </div>
                                </a>
                                
                                @auth
                                    @if(auth()->id() !== $writer->id)
                                        <form action="{{ route('authors.' . (auth()->user()->isFollowing($writer) ? 'unfollow' : 'follow'), $writer->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold px-4 py-1.5 rounded-full transition-all {{ auth()->user()->isFollowing($writer) ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-amber-600 text-white hover:bg-amber-700' }}">
                                                {{ auth()->user()->isFollowing($writer) ? 'Mengikuti' : 'Ikuti' }}
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="text-xs font-bold px-4 py-1.5 rounded-full bg-amber-600 text-white hover:bg-amber-700 transition-all">
                                        Ikuti
                                    </a>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
                        <a href="{{ route('writers.index') }}" class="text-sm font-semibold text-amber-600 hover:underline">Lihat Semua Penyair</a>
                    </div>
                </section>

                <!-- Footer Compact -->
                <div class="pt-12 text-center">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">&copy; 2024 Senandika Poetry Platform</p>
                </div>

            </aside>
        </div>
    </div>
@endsection
