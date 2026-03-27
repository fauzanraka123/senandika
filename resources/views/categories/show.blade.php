@extends('layouts.app')

@section('title', 'Poems about ' . $category->name)

@section('content')
    <div
        class="bg-white dark:bg-[#151515] border-b border-stone-200 dark:border-stone-800 py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="text-sm font-semibold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.2em] mb-4 block">Tema
                Puisi</span>
            <h1
                class="text-4xl md:text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-4 transition-colors">
                {{ $category->name }}
            </h1>

            <div
                class="mt-6 text-sm font-medium text-stone-500 bg-stone-100 dark:bg-stone-800 dark:text-stone-400 px-4 py-1.5 rounded-full inline-block">
                {{ $poems->total() }} {{ \Illuminate\Support\Str::plural('poem', $poems->total()) }}
            </div>
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
                <p class="text-stone-500 dark:text-stone-400">Puisi belum tersedia dalam tema ini.</p>
            </div>
        @endif
    </div>
@endsection