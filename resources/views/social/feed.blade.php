@extends('layouts.app')

@section('title', 'Beranda Puisi Anda')

@section('content')
    <div class="bg-white dark:bg-[#151515] border-b border-stone-200 dark:border-stone-800 py-24 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.4em] mb-6 block">Antologi Pribadi</span>
            <h1 class="text-5xl md:text-6xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-6 transition-colors font-bold">Gema Sanandika</h1>
            <p class="text-stone-500 dark:text-stone-400 max-w-xl mx-auto font-serif italic text-lg leading-relaxed">
                Suara yang Anda ikuti, bait-bait yang menyapa jiwa.
            </p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        @if($poems->count() > 0)
            <div class="space-y-24">
                @foreach($poems as $poem)
                    <article class="group relative">
                        <!-- Left decoration -->
                        <div class="absolute -left-12 top-0 bottom-0 w-px bg-stone-100 dark:bg-stone-800 group-hover:bg-[#8B5E3C] dark:group-hover:bg-[#C9A27C] transition-colors"></div>
                        
                        <div class="flex items-center gap-4 mb-8">
                            <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="relative">
                                @if($poem->user->avatar)
                                    <img src="{{ $poem->user->avatar }}" class="w-12 h-12 rounded-full object-cover border-2 border-stone-50 dark:border-stone-900 shadow-sm group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-500 font-serif border-2 border-stone-50 dark:border-stone-900 group-hover:scale-105 transition-transform">
                                        {{ substr($poem->user->name, 0, 1) }}
                                    </div>
                                @endif
                            </a>
                            <div>
                                <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="text-base font-bold text-[#1A1A1A] dark:text-[#EAEAEA] hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">{{ $poem->user->name }}</a>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] text-stone-400 uppercase tracking-widest font-bold">{{ $poem->published_at->format('M d, Y') }}</p>
                                    @if($poem->category)
                                        <span class="text-stone-300">&bull;</span>
                                        <a href="{{ route('categories.show', $poem->category->slug) }}" class="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest hover:underline">{{ $poem->category->name }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('poems.show', $poem->slug) }}" class="block group/title">
                            <h2 class="text-4xl md:text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-6 leading-tight font-medium">{{ $poem->title }}</h2>
                        </a>

                        <div class="font-serif text-xl leading-[1.8] text-stone-700 dark:text-stone-300 line-clamp-4 whitespace-pre-wrap mb-8 italic opacity-80 group-hover:opacity-100 transition-opacity">
                            "{{ $poem->excerpt ?? \Illuminate\Support\Str::limit($poem->content, 250) }}"
                        </div>

                        <div class="flex items-center gap-8">
                            <a href="{{ route('poems.show', $poem->slug) }}" class="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest hover:underline flex items-center gap-2">
                                Selami lebih dalam
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            <div class="h-px flex-1 bg-stone-100 dark:bg-stone-800"></div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-24">
                {{ $poems->links() }}
            </div>
        @else
            <div class="text-center py-32 bg-stone-50 dark:bg-stone-900/30 rounded-[3rem] border-2 border-dashed border-stone-200 dark:border-stone-800 px-10">
                <div class="w-20 h-20 bg-white dark:bg-[#151515] rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                    <svg class="w-10 h-10 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-4">Beranda Anda masih sunyi</h3>
                <p class="text-stone-500 dark:text-stone-400 mb-10 font-serif italic text-lg max-w-sm mx-auto">Ikuti penyair lain untuk mengisi ruang ini dengan bait-bait terbaru mereka.</p>
                <a href="{{ route('writers.index') }}" class="inline-block px-10 py-4 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-2xl font-bold shadow-xl hover:opacity-90 transition-all uppercase tracking-[0.2em] text-xs">Jelajahi Kolektif</a>
            </div>
        @endif
    </div>
@endsection
