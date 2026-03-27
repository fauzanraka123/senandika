@extends('layouts.app')

@section('title', 'Discover Topics')

@section('content')
    <div
        class="bg-white dark:bg-[#151515] border-b border-stone-200 dark:border-stone-800 py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="text-sm font-semibold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.2em] mb-4 block">Arsip
                Puisi</span>
            <h1
                class="text-4xl md:text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-4 transition-colors">
                Temukan Tema</h1>
            <p class="text-stone-600 dark:text-stone-400 max-w-2xl mx-auto font-serif italic">
                Jelajahi puisi dari sudut pandang dan emosi yang beragam.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="group bg-white dark:bg-[#151515] p-8 rounded-2xl border border-stone-200 dark:border-stone-800 hover:border-[#8B5E3C] dark:hover:border-[#C9A27C] transition-all text-center shadow-sm hover:shadow-md">
                    <h2
                        class="text-2xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors mb-2">
                        {{ $category->name }}
                    </h2>
                    <p class="text-stone-500 dark:text-stone-400 text-sm italic">
                        {{ $category->poems_count }} published
                        {{ \Illuminate\Support\Str::plural('poem', $category->poems_count) }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
@endsection