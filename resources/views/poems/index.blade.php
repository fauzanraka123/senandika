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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($poems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($poems as $poem)
                    @include('components.poem-card', ['poem' => $poem])
                @endforeach
            </div>

            <div class="mt-16">
                {{ $poems->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-stone-300 dark:text-stone-700 mb-6"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-2xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] mb-2">No poems found</h3>
                <p class="text-stone-500 dark:text-stone-400">Be the first to publish a poem in this archive.</p>
                <a href="{{ route('dashboard') }}"
                    class="inline-block mt-6 px-6 py-2 bg-[#8B5E3C] hover:bg-[#6a4428] text-white rounded-full font-medium transition-colors">Tulis
                    Puisi</a>
            </div>
        @endif
    </div>
@endsection