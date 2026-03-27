@extends('layouts.app')

@section('title', $poem->title)

@section('content')
    <article class="bg-[#F8F6F2] dark:bg-[#0F0F0F] min-h-screen pt-12 pb-24 transition-colors duration-300" id="reading-container">
        
        <!-- Focus Mode Controls -->
        <div class="fixed bottom-8 right-8 z-40 hidden md:block">
            <button id="focus-btn" class="bg-white dark:bg-[#151515] text-stone-500 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] border border-stone-200 dark:border-stone-800 rounded-full p-3 shadow-sm hover:shadow-md transition-all focus:outline-none" title="Mode Fokus">
                <svg id="focus-icon-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
                <svg id="focus-icon-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l-4-4m11 8V4m0 0h-4m4 0l4-4M4 16v4m0 0h4m-4 0l-4 4m11-8v4m0 0h-4m4 0l4 4" />
                </svg>
            </button>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="/poems" class="inline-flex items-center gap-2 text-sm text-stone-500 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] mb-8 transition-colors reading-ui">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Arsip
            </a>

            <!-- Header -->
            <header class="text-center mb-16">
                @if($poem->category)
                    <a href="/categories/{{ $poem->category->slug }}" class="text-xs font-semibold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.2em] mb-4 block hover:opacity-80 transition-opacity">
                        {{ $poem->category->name }}
                    </a>
                @endif
                
                <h1 class="text-4xl md:text-6xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-8 leading-tight transition-colors">
                    {{ $poem->title }}
                </h1>
                
                <div class="flex flex-col items-center justify-center gap-4 text-stone-500 dark:text-stone-400 font-serif italic mb-8 border-b border-stone-200 dark:border-stone-800 pb-8 transition-colors">
                    <a href="/authors/{{ $poem->user->id }}" class="flex items-center gap-3 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors group">
                        @if($poem->user->avatar)
                            <img src="{{ $poem->user->avatar }}" alt="{{ $poem->user->name }}" class="w-10 h-10 rounded-full border border-stone-200 dark:border-stone-700">
                        @else
                            <div class="w-10 h-10 rounded-full bg-stone-200 dark:bg-stone-800 text-stone-600 dark:text-stone-300 flex items-center justify-center font-serif not-italic font-bold">
                                {{ substr($poem->user->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-lg">Oleh <span class="group-hover:underline underline-offset-4">{{ $poem->user->name }}</span></span>
                    </a>
                    
                    <div class="flex items-center gap-4 text-sm mt-2">
                        <span>{{ $poem->published_at->translatedFormat('M d, Y') }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-300 dark:bg-stone-700"></span>
                        <span class="flex items-center gap-1" title="Penayangan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $poem->views }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Poem Content -->
            <div class="font-serif text-lg leading-normal whitespace-pre-line">
                {{ $poem->content }}
            </div>

            <!-- Tags -->
            @if($poem->tags->count() > 0)
                <div class="mt-20 pt-8 border-t border-stone-200 dark:border-stone-800 text-center reading-ui transition-colors">
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach($poem->tags as $tag)
                            <span class="px-3 py-1 bg-white dark:bg-[#151515] border border-stone-200 dark:border-stone-800 text-stone-500 dark:text-stone-400 rounded-full text-xs font-medium tracking-wide">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Actions (Likes, Share) Placeholder -->
            <div class="mt-12 flex justify-center items-center gap-6 reading-ui">
                <button class="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-red-500 dark:hover:text-red-400 transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 group-hover:fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="font-medium text-lg">{{ $poem->likes->count() }}</span>
                </button>
            </div>

        </div>
    </article>

    <script>
        // Focus Mode Logic
        const focusBtn = document.getElementById('focus-btn');
        const iconOn = document.getElementById('focus-icon-on');
        const iconOff = document.getElementById('focus-icon-off');
        const readingUiElements = document.querySelectorAll('.reading-ui');
        const nav = document.querySelector('nav');
        const footer = document.querySelector('footer');
        let focusMode = false;

        if (focusBtn) {
            focusBtn.addEventListener('click', () => {
                focusMode = !focusMode;
                
                if (focusMode) {
                    iconOn.classList.add('hidden');
                    iconOff.classList.remove('hidden');
                    nav.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    footer.classList.add('opacity-0', 'pointer-events-none');
                    
                    readingUiElements.forEach(el => {
                        el.classList.add('opacity-0', 'pointer-events-none');
                        el.style.transition = 'opacity 0.5s ease';
                    });
                } else {
                    iconOff.classList.add('hidden');
                    iconOn.classList.remove('hidden');
                    nav.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    footer.classList.remove('opacity-0', 'pointer-events-none');
                    
                    readingUiElements.forEach(el => {
                        el.classList.remove('opacity-0', 'pointer-events-none');
                    });
                }
            });
        }
    </script>
@endsection
