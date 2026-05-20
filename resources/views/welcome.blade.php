@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            
            <!-- Main Feed (Left Column) -->
            <div class="lg:w-2/3 space-y-16">
                
                <!-- Section 3: Puisi dari Penyair yang Diikuti (Conditional) -->
                @auth
                    <section>
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl md:text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Dari Penyair yang Kamu Ikuti</h2>
                        </div>
                        
                        @if($followingPoems->count() > 0)
                            <div class="grid grid-cols-1 gap-8">
                                @foreach($followingPoems as $poem)
                                    <div class="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 p-6 md:p-8 hover:shadow-xl transition-all relative overflow-hidden group">
                                        <div class="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                                        <div class="relative z-10">
                                            <div class="flex items-center gap-3 mb-6">
                                                @if($poem->user->avatar)
                                                    <img src="{{ $poem->user->avatar }}" class="w-10 h-10 rounded-full border border-stone-100 dark:border-stone-800 object-cover shadow-sm">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold text-sm shadow-sm border border-stone-100 dark:border-stone-800">
                                                        {{ substr($poem->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{{ $poem->user->name }}</span>
                                                    <span class="text-[10px] text-stone-500 font-bold uppercase tracking-widest">{{ $poem->published_at ? $poem->published_at->diffForHumans() : 'Baru saja' }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('poems.show', $poem->slug) }}" class="block group/title">
                                                <h3 class="text-2xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-3">
                                                    {{ $poem->title }}
                                                </h3>
                                                <p class="font-serif italic text-lg leading-relaxed text-stone-600 dark:text-stone-400 line-clamp-3 mb-6">
                                                    "{{ $poem->excerpt ?? Str::limit($poem->content, 150) }}"
                                                </p>
                                            </a>
                                            <div class="flex items-center justify-between mt-4 pt-5 border-t border-stone-100 dark:border-stone-800/60">
                                                <div class="flex items-center gap-3 text-stone-500">
                                                    <span class="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs" title="Suka">
                                                        <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                                        {{ $poem->likes_count }}
                                                    </span>
                                                    <span class="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs" title="Penayangan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        {{ $poem->views }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('poems.show', $poem->slug) }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] hover:text-[#704B30] dark:hover:text-[#DEB887] uppercase tracking-widest bg-[#8B5E3C]/5 dark:bg-[#C9A27C]/5 px-3 py-1.5 rounded-full transition-colors">
                                                    Selengkapnya
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white dark:bg-[#1A1A1A] rounded-[3rem] p-10 text-center border border-stone-100 dark:border-stone-800 shadow-sm">
                                <div class="w-16 h-16 bg-stone-50 dark:bg-[#151515] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-stone-100 dark:border-stone-800">
                                    <svg class="w-8 h-8 text-stone-300 dark:text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <p class="text-stone-600 dark:text-stone-400 font-serif italic text-lg mb-6">Ikuti penyair untuk melihat karya mereka secara eksklusif di sini.</p>
                                <a href="{{ route('writers.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-full font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all uppercase tracking-widest text-[10px]">Temukan Penyair</a>
                            </div>
                        @endif
                    </section>
                @endauth

                <!-- Section 1: Puisi Terbaru -->
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl md:text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">Puisi Terbaru</h2>
                    </div>

                    @if($latestPoems->count() > 0)
                        <div class="space-y-8">
                            @foreach($latestPoems as $poem)
                                <article class="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 p-6 md:p-8 hover:shadow-xl transition-all duration-300 relative overflow-hidden group">
                                    <div class="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                                    <div class="relative z-10 flex flex-col md:flex-row gap-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-5">
                                                <a href="{{ route('authors.show', $poem->user->username ?: $poem->user->id) }}" class="flex items-center gap-2 group/author">
                                                    @if($poem->user->avatar)
                                                        <img src="{{ $poem->user->avatar }}" class="w-8 h-8 rounded-full border border-stone-100 dark:border-stone-800 object-cover shadow-sm">
                                                    @else
                                                        <div class="w-8 h-8 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold text-xs shadow-sm border border-stone-100 dark:border-stone-800">
                                                            {{ substr($poem->user->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/author:text-[#8B5E3C] dark:group-hover/author:text-[#C9A27C] transition-colors">{{ $poem->user->name }}</span>
                                                </a>
                                                <span class="text-stone-300 dark:text-stone-700 hidden sm:inline">&bull;</span>
                                                <span class="text-[10px] text-stone-500 font-bold uppercase tracking-widest">{{ $poem->published_at ? $poem->published_at->format('d M Y') : 'Baru' }}</span>
                                            </div>

                                            <a href="{{ route('poems.show', $poem->slug) }}" class="block group/title">
                                                <h3 class="text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/title:text-[#8B5E3C] dark:group-hover/title:text-[#C9A27C] transition-colors mb-4">
                                                    {{ $poem->title }}
                                                </h3>
                                                <p class="font-serif italic text-lg leading-relaxed text-stone-600 dark:text-stone-400 mb-8 line-clamp-3">
                                                    "{{ $poem->excerpt ?? Str::limit($poem->content, 200) }}"
                                                </p>
                                            </a>

                                            <div class="flex items-center justify-between pt-5 border-t border-stone-100 dark:border-stone-800/60">
                                                <div class="flex items-center gap-3 text-sm text-stone-500">
                                                    <span class="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs">
                                                        <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                                        {{ $poem->likes_count }}
                                                    </span>
                                                    <span class="flex items-center gap-1.5 font-medium bg-stone-50 dark:bg-[#151515] px-2.5 py-1 rounded-full text-xs">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        {{ $poem->views }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('poems.show', $poem->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-stone-50 dark:bg-[#151515] text-[#1A1A1A] dark:text-[#EAEAEA] rounded-full text-[10px] uppercase tracking-widest font-bold hover:bg-[#8B5E3C] hover:text-white dark:hover:bg-[#C9A27C] dark:hover:text-[#1A1A1A] transition-all shadow-sm">
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
                        <div class="py-20 text-center bg-white dark:bg-[#1A1A1A] rounded-[3rem] border border-stone-100 dark:border-stone-800 shadow-sm">
                            <p class="text-xl font-serif text-stone-500 dark:text-stone-400 italic">Belum ada puisi yang dipublikasikan.</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Sidebar (Right Column) -->
            <aside class="lg:w-1/3 space-y-12">
                
                <!-- Section 2: Puisi Populer -->
                <section>
                    <h2 class="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#8B5E3C] dark:text-[#C9A27C]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/></svg>
                        Puisi Populer
                    </h2>
                    <div class="space-y-4">
                        @foreach($popularPoems as $poem)
                            <a href="{{ route('poems.show', $poem->slug) }}" class="block group p-5 bg-white dark:bg-[#1A1A1A] rounded-[1.5rem] border border-stone-100 dark:border-stone-800 hover:border-[#8B5E3C]/30 dark:hover:border-[#C9A27C]/30 transition-all shadow-sm hover:shadow-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none z-0"></div>
                                <div class="relative z-10">
                                    <h3 class="text-base font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors mb-2 line-clamp-1">
                                        {{ $poem->title }}
                                    </h3>
                                    <p class="text-xs text-stone-500 mb-3 font-serif italic">oleh {{ $poem->user->name }}</p>
                                    <div class="flex items-center gap-3 text-[10px] text-stone-400 font-bold">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                            {{ $poem->likes_count }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            {{ $poem->views }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <!-- Section 4: Sidebar Penyair -->
                <section>
                    <h2 class="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#8B5E3C] dark:text-[#C9A27C]" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3.005 3.005 0 013.75-2.906z"/></svg>
                        Penyair Populer
                    </h2>
                    <div class="space-y-4">
                        @foreach($topWriters as $writer)
                            <div class="flex items-center justify-between group bg-white dark:bg-[#1A1A1A] p-4 rounded-[1.5rem] border border-stone-100 dark:border-stone-800 shadow-sm hover:shadow-md transition-all">
                                <a href="{{ route('authors.show', $writer->username ?: $writer->id) }}" class="flex items-center gap-3">
                                    @if($writer->avatar)
                                        <img src="{{ $writer->avatar }}" class="w-10 h-10 rounded-full object-cover shadow-sm border border-stone-100 dark:border-stone-800">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-stone-100 dark:bg-[#151515] flex items-center justify-center text-stone-600 dark:text-stone-300 font-serif font-bold shadow-sm border border-stone-100 dark:border-stone-800">
                                            {{ substr($writer->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors">{{ $writer->name }}</h4>
                                        <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mt-0.5">{{ $writer->followers_count }} Pengikut</p>
                                    </div>
                                </a>
                                
                                @auth
                                    @if(auth()->id() !== $writer->id)
                                        <form action="{{ route('authors.' . (auth()->user()->isFollowing($writer) ? 'unfollow' : 'follow'), $writer->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-bold px-4 py-2 rounded-full transition-all uppercase tracking-widest {{ auth()->user()->isFollowing($writer) ? 'bg-stone-100 text-stone-600 hover:bg-stone-200 dark:bg-[#151515] dark:text-stone-300 dark:hover:bg-[#202020]' : 'bg-[#8B5E3C] text-white hover:bg-[#704B30] dark:bg-[#C9A27C] dark:text-[#1A1A1A] dark:hover:bg-[#DEB887]' }}">
                                                {{ auth()->user()->isFollowing($writer) ? 'Mengikuti' : 'Ikuti' }}
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="text-[10px] font-bold px-4 py-2 rounded-full bg-[#8B5E3C] text-white hover:bg-[#704B30] dark:bg-[#C9A27C] dark:text-[#1A1A1A] dark:hover:bg-[#DEB887] transition-all uppercase tracking-widest">
                                        Ikuti
                                    </a>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 border-t border-stone-100 dark:border-stone-800 text-center">
                        <a href="{{ route('writers.index') }}" class="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] hover:underline uppercase tracking-widest">Lihat Semua Penyair</a>
                    </div>
                </section>

                <!-- Footer Compact -->
                <div class="pt-12 text-center">
                    <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest">&copy; 2024 RuangKata Poetry Platform</p>
                </div>

            </aside>
        </div>
    </div>
@endsection
