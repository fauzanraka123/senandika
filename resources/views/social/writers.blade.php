@extends('layouts.app')

@section('title', 'Para Penyair - Senandika')

@section('content')
    <div class="bg-[#FDFCFB] dark:bg-gray-950 border-b border-gray-100 dark:border-gray-900 py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-serif text-gray-900 dark:text-gray-100 tracking-tight mb-4">Ruang Para Penyair</h1>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto font-serif italic text-lg leading-relaxed">
                Menemukan jiwa-jiwa yang merangkai kata menjadi bait doa dan senandika.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($writers->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($writers as $writer)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 hover:shadow-md transition-all group flex flex-col items-center text-center">
                        <div class="mb-6 relative">
                            @if($writer->avatar)
                                <img src="{{ $writer->avatar }}" alt="{{ $writer->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-amber-50 dark:border-amber-900/30">
                            @else
                                <div class="w-24 h-24 rounded-full bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-500 font-serif text-3xl font-bold">
                                    {{ substr($writer->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute -bottom-1 -right-1 bg-white dark:bg-gray-800 rounded-full p-1.5 shadow-sm border border-gray-100 dark:border-gray-700">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                        </div>

                        <h2 class="text-2xl font-serif font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-amber-600 transition-colors">
                            {{ $writer->name }}
                        </h2>
                        
                        <div class="flex items-center gap-4 text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                            <span>{{ $writer->poems_count }} Puisi</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                            <span>{{ $writer->followers_count }} Pengikut</span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 font-serif italic mb-8 line-clamp-2 h-12 leading-relaxed">
                            {{ $writer->bio ?: 'Merasakan dunia melalui setiap bait yang tertulis.' }}
                        </p>

                        <div class="w-full pt-6 border-t border-gray-50 dark:border-gray-700 flex flex-col gap-3">
                            <a href="{{ route('authors.show', $writer->username ?: $writer->id) }}" class="w-full py-3 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-bold text-sm hover:bg-amber-600 hover:text-white dark:hover:bg-amber-600 transition-all">
                                Lihat Profil
                            </a>
                            
                            @auth
                                @if(auth()->id() !== $writer->id)
                                    <form action="{{ route('authors.' . (auth()->user()->isFollowing($writer) ? 'unfollow' : 'follow'), $writer->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 text-xs font-bold uppercase tracking-widest transition-colors {{ auth()->user()->isFollowing($writer) ? 'text-gray-400 hover:text-red-500' : 'text-amber-600 hover:text-amber-700' }}">
                                            {{ auth()->user()->isFollowing($writer) ? 'Berhenti Mengikuti' : 'Ikuti Penyair' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                {{ $writers->links() }}
            </div>
        @else
            <div class="py-24 text-center bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-100 dark:border-gray-700">
                <p class="text-xl font-serif text-gray-500 italic">Belum ada penyair yang mempublikasikan puisi.</p>
                <a href="{{ route('login') }}" class="mt-6 inline-block bg-amber-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-amber-700 transition-all">
                    Jadilah Penyair Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
