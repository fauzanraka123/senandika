@extends('layouts.app')

@section('title', $author->name . ' - Senandika')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Profile Header Section -->
        <header class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-16">
            <div class="flex-shrink-0">
                @if($author->avatar)
                    <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-white dark:border-gray-800">
                @else
                    <div class="w-32 h-32 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-500 font-serif text-5xl font-bold shadow-lg">
                        {{ substr($author->name, 0, 1) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                    <h1 class="text-3xl font-serif font-bold text-gray-900 dark:text-gray-100">
                        {{ $author->name }}
                    </h1>
                    
                    @auth
                        @if(auth()->id() !== $author->id)
                            <form action="{{ route('authors.' . (auth()->user()->isFollowing($author) ? 'unfollow' : 'follow'), $author->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2 rounded-full text-sm font-bold transition-all {{ auth()->user()->isFollowing($author) ? 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-red-50 hover:text-red-600' : 'bg-amber-600 text-white hover:bg-amber-700' }}">
                                    {{ auth()->user()->isFollowing($author) ? 'Berhenti Mengikuti' : 'Ikuti Penyair' }}
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-amber-600 text-white rounded-full text-sm font-bold hover:bg-amber-700 transition-all">
                            Ikuti Penyair
                        </a>
                    @endauth
                </div>

                <p class="font-serif italic text-gray-600 dark:text-gray-400 text-lg leading-relaxed mb-6 max-w-2xl">
                    {{ $author->bio ?: 'Merasakan dunia melalui setiap bait yang tertulis, menemukan keajaiban dalam sepis yang sunyi.' }}
                </p>

                <div class="flex items-center justify-center md:justify-start gap-8 text-sm font-medium">
                    <div class="flex flex-col items-center md:items-start px-4 first:pl-0 border-l first:border-l-0 border-gray-100 dark:border-gray-800">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-xl">{{ $author->followers_count }}</span>
                        <span class="text-xs uppercase tracking-widest text-gray-400">Pengikut</span>
                    </div>
                    <div class="flex flex-col items-center md:items-start px-4 border-l border-gray-100 dark:border-gray-800">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-xl">{{ $author->following_count }}</span>
                        <span class="text-xs uppercase tracking-widest text-gray-400">Mengikuti</span>
                    </div>
                    <div class="flex flex-col items-center md:items-start px-4 border-l border-gray-100 dark:border-gray-800">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-xl">{{ $author->poems_count }}</span>
                        <span class="text-xs uppercase tracking-widest text-gray-400">Puisi</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Latest Poem Highlight -->
        @if($latestPoem)
            <section class="mb-20">
                <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-amber-600 mb-6">Karya Terbaru</h2>
                <div class="bg-amber-50/50 dark:bg-amber-900/10 rounded-3xl p-8 md:p-12 border border-amber-100/50 dark:border-amber-900/30 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 opacity-[0.05] dark:opacity-[0.1] transform group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.419.91-3.996 3.638-3.996 5.845h3.997v10h-9.997z"/></svg>
                    </div>

                    <div class="relative z-10 max-w-3xl">
                        <a href="{{ route('poems.show', $latestPoem->slug) }}">
                            <h3 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-6 group-hover:text-amber-600 transition-colors">
                                {{ $latestPoem->title }}
                            </h3>
                            <p class="font-serif italic text-xl leading-relaxed text-gray-700 dark:text-gray-300 mb-8 whitespace-pre-wrap line-clamp-4">
                                {{ $latestPoem->excerpt ?? Str::limit($latestPoem->content, 300) }}
                            </p>
                        </a>
                        
                        <div class="flex items-center justify-between pt-8 border-t border-amber-200/30 dark:border-amber-900/30">
                            <div class="flex items-center gap-6 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                    {{ $latestPoem->likes_count }} Suka
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ $latestPoem->views }} Dilihat
                                </span>
                            </div>
                            <a href="{{ route('poems.show', $latestPoem->slug) }}" class="inline-flex items-center gap-2 font-bold text-amber-600 hover:text-amber-700 transition-colors">
                                Baca Selengkapnya 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- List Section -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400">Arsip Puisi</h2>
                <div class="h-px flex-1 bg-gray-100 dark:bg-gray-800 ml-6"></div>
            </div>

            @if($poems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($poems as $poem)
                        @if(!$latestPoem || $poem->id !== $latestPoem->id)
                            <article class="bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all group">
                                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-4 block">{{ $poem->category->name ?? 'Puisi' }}</span>
                                
                                <a href="{{ route('poems.show', $poem->slug) }}" class="block">
                                    <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-amber-600 transition-colors">
                                        {{ $poem->title }}
                                    </h3>
                                    <p class="font-serif italic text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                        {{ $poem->excerpt ?? Str::limit($poem->content, 120) }}
                                    </p>
                                </a>

                                <div class="flex items-center justify-between pt-6 border-t border-gray-50 dark:border-gray-700">
                                    <div class="flex items-center gap-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3 text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                            {{ $poem->likes_count }}
                                        </span>
                                        <span>{{ $poem->published_at ? $poem->published_at->format('d M Y') : '' }}</span>
                                    </div>
                                    <a href="{{ route('poems.show', $poem->slug) }}" class="text-xs font-bold text-amber-600 hover:underline">Baca</a>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $poems->links() }}
                </div>
            @else
                <div class="py-20 text-center bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-100 dark:border-gray-800">
                    <p class="font-serif italic text-gray-500">Penyair ini belum memiliki arsip puisi yang lain.</p>
                </div>
            @endif
        </section>
    </div>
@endsection
