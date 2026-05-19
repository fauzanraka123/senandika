@extends('layouts.app')

@section('title', 'Puisi')

@section('content')
    <div
        class="bg-white dark:bg-[#151515] border-b border-stone-200 dark:border-stone-800 py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1
                class="text-4xl md:text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-4 transition-colors">
                Puisi</h1>
            <p class="text-lg text-stone-500 dark:text-stone-400 font-serif italic max-w-2xl mx-auto">
                Jelajahi puisi dari penulis di seluruh dunia.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        @if($poems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach($poems as $poem)
                    @include('components.poem-card', ['poem' => $poem])
                @endforeach
            </div>

            <div class="mt-16 md:mt-24">
                {{ $poems->links() }}
            </div>
        @else
            <div class="text-center py-24 md:py-32 bg-white dark:bg-[#1A1A1A] rounded-[3rem] border border-stone-100 dark:border-stone-800 shadow-sm px-6 md:px-10">
                <div class="w-24 h-24 bg-stone-50 dark:bg-[#151515] rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border border-stone-100 dark:border-stone-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-stone-300 dark:text-stone-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-3xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-4">Belum ada puisi</h3>
                <p class="text-stone-500 dark:text-stone-400 mb-10 font-serif italic text-lg max-w-sm mx-auto">Jadilah yang pertama untuk mempublikasikan puisi di arsip ini.</p>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-3 px-8 py-4 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-full font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all uppercase tracking-widest text-xs">
                    Tulis Puisi
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
@endsection