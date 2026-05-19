@extends('layouts.app')

@section('title', 'Beranda Puisi Anda')

@section('content')
    <div class="bg-white dark:bg-[#151515] border-b border-stone-200 dark:border-stone-800 py-16 md:py-24 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.3em] mb-4 block bg-[#8B5E3C]/10 dark:bg-[#C9A27C]/10 inline-block px-4 py-1.5 rounded-full">Antologi Pribadi</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-6 transition-colors font-bold">Gema Syair</h1>
            <p class="text-stone-500 dark:text-stone-400 max-w-xl mx-auto font-serif italic text-lg md:text-xl leading-relaxed">
                Suara yang Anda ikuti, bait-bait yang menyapa jiwa.
            </p>
        </div>
    </div>

    <div class="bg-[#F8F6F2] dark:bg-[#0F0F0F] min-h-screen py-16 md:py-24 transition-colors duration-300">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($poems->count() > 0)
                <div class="space-y-8 md:space-y-12">
                    @foreach($poems as $poem)
                        <article class="bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-6 md:p-10 shadow-sm hover:shadow-xl border border-stone-100 dark:border-stone-800 transition-all duration-300 relative overflow-hidden group">
                            
                            <!-- Header Info -->
                            <div class="flex items-center gap-4 mb-6 relative z-10">
                                <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="relative shrink-0">
                                    @if($poem->user->avatar)
                                        <img src="{{ $poem->user->avatar }}" class="w-12 h-12 md:w-14 md:h-14 rounded-full object-cover shadow-sm ring-2 ring-transparent group-hover:ring-[#8B5E3C]/30 transition-all">
                                    @else
                                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif text-xl font-bold shadow-sm ring-2 ring-transparent group-hover:ring-[#8B5E3C]/30 transition-all">
                                            {{ substr($poem->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </a>
                                <div>
                                    <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="text-base md:text-lg font-bold text-[#1A1A1A] dark:text-[#EAEAEA] hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors">{{ $poem->user->name }}</a>
                                    <div class="flex items-center flex-wrap gap-2 mt-0.5 text-xs md:text-sm">
                                        <p class="text-stone-500 dark:text-stone-400 font-medium">{{ $poem->published_at->format('M d, Y') }}</p>
                                        @if($poem->category)
                                            <span class="text-stone-300 dark:text-stone-700 hidden sm:inline">&bull;</span>
                                            <a href="{{ route('categories.show', $poem->category->slug) }}" class="text-[#8B5E3C] dark:text-[#C9A27C] hover:underline font-bold tracking-wide uppercase text-[10px] sm:text-xs bg-stone-50 dark:bg-[#151515] px-2 py-0.5 rounded-full">{{ $poem->category->name }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <a href="{{ route('poems.show', $poem->slug) }}" class="block relative z-10">
                                <h2 class="text-2xl md:text-3xl lg:text-4xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors mb-4 leading-tight font-bold">{{ $poem->title }}</h2>
                                <div class="font-serif text-lg md:text-xl leading-relaxed text-stone-600 dark:text-stone-400 line-clamp-3 md:line-clamp-4 whitespace-pre-wrap mb-8 italic">
                                    "{{ $poem->excerpt ?? \Illuminate\Support\Str::limit($poem->content, 200) }}"
                                </div>
                            </a>

                            <!-- Footer/Actions -->
                            <div class="flex items-center justify-between relative z-10 pt-6 border-t border-stone-100 dark:border-stone-800/60 mt-auto">
                                <a href="{{ route('poems.show', $poem->slug) }}" class="inline-flex items-center gap-2 text-xs md:text-sm font-bold text-[#8B5E3C] dark:text-[#C9A27C] hover:text-[#704B30] dark:hover:text-[#DEB887] transition-colors uppercase tracking-wider bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5 px-4 py-2 rounded-full">
                                    Baca Puisi
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </a>
                                
                                <div class="flex items-center gap-4 text-stone-400">
                                    <span class="flex items-center gap-1.5 text-sm font-medium bg-stone-50 dark:bg-[#151515] px-3 py-1.5 rounded-full" title="Suka">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        {{ $poem->likes_count ?? ($poem->likes ? $poem->likes->count() : 0) }}
                                    </span>
                                    <span class="flex items-center gap-1.5 text-sm font-medium bg-stone-50 dark:bg-[#151515] px-3 py-1.5 rounded-full" title="Penayangan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ $poem->views ?? 0 }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Subtle hover background effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $poems->links() }}
                </div>
            @else
                <div class="text-center py-24 md:py-32 bg-white dark:bg-[#1A1A1A] rounded-[3rem] border border-stone-100 dark:border-stone-800 shadow-sm px-6 md:px-10">
                    <div class="w-24 h-24 bg-stone-50 dark:bg-[#151515] rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border border-stone-100 dark:border-stone-800">
                        <svg class="w-12 h-12 text-stone-300 dark:text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-4">Beranda Anda masih sunyi</h3>
                    <p class="text-stone-500 dark:text-stone-400 mb-10 font-serif italic text-lg max-w-sm mx-auto">Ikuti penyair lain untuk mengisi ruang ini dengan bait-bait terbaru mereka.</p>
                    <a href="{{ route('writers.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-full font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all uppercase tracking-widest text-xs">
                        Jelajahi Kolektif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
