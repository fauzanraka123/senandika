@extends('layouts.dashboard')

@section('title', 'Puisi Saya')
@section('header', 'Arsip Anda')

@push('header-actions')
    <a href="{{ route('dashboard.poems.create') }}" class="px-5 py-2.5 bg-[#8B5E3C] dark:bg-[#C9A27C] hover:opacity-90 text-white dark:text-[#1A1A1A] rounded-xl font-bold transition-all text-xs shadow-sm flex items-center gap-2 uppercase tracking-widest">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Puisi Baru
    </a>
@endpush

@section('content')
    <div class="mb-8">
        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('dashboard.poems.index') }}" class="px-4 py-2 rounded-full transition-all {{ !request('status') ? 'bg-white dark:bg-[#151515] text-[#8B5E3C] dark:text-[#C9A27C] shadow-sm' : 'text-stone-500 hover:text-stone-700' }}">Semua Puisi</a>
            <a href="{{ route('dashboard.poems.index', ['status' => 'published']) }}" class="px-4 py-2 rounded-full transition-all {{ request('status') === 'published' ? 'bg-white dark:bg-[#151515] text-[#8B5E3C] dark:text-[#C9A27C] shadow-sm' : 'text-stone-500 hover:text-stone-700' }}">Terbit</a>
            <a href="{{ route('dashboard.poems.index', ['status' => 'draft']) }}" class="px-4 py-2 rounded-full transition-all {{ request('status') === 'draft' ? 'bg-white dark:bg-[#151515] text-[#8B5E3C] dark:text-[#C9A27C] shadow-sm' : 'text-stone-500 hover:text-stone-700' }}">Draf</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/10 text-green-700 dark:text-green-400 p-4 rounded-xl mb-8 text-sm border border-green-100 dark:border-green-900/30 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-[#151515] rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm overflow-hidden transition-colors">
        @if($poems->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50 dark:bg-stone-900/50 border-b border-stone-100 dark:border-stone-800">
                            <th class="px-8 py-5 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em]">Detail Karya</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em]">Metrik</th>
                            <th class="px-8 py-5 text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 dark:divide-stone-800">
                        @foreach($poems as $poem)
                            <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-900/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        @if($poem->cover_image)
                                            <img src="{{ asset('storage/' . $poem->cover_image) }}" class="w-12 h-12 rounded-lg object-cover border border-stone-200 dark:border-stone-800 shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 flex items-center justify-center text-stone-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-serif text-lg font-bold text-[#1A1A1A] dark:text-[#EAEAEA]">{{ $poem->title }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest">{{ $poem->category ? $poem->category->name : 'Tanpa Kategori' }}</span>
                                                <span class="text-stone-300 dark:text-stone-700">&bull;</span>
                                                <span class="text-[10px] text-stone-400 uppercase tracking-widest">{{ $poem->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $poem->status === 'published' ? 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400 border border-green-100 dark:border-green-900/30' : 'bg-stone-100 text-stone-500 dark:bg-stone-800 dark:text-stone-400 border border-stone-200 dark:border-stone-700' }}">
                                        <div class="w-1.5 h-1.5 rounded-full {{ $poem->status === 'published' ? 'bg-green-500' : 'bg-stone-400' }}"></div>
                                        {{ $poem->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-stone-700 dark:text-stone-300">{{ number_format($poem->views) }}</span>
                                            <span class="text-[9px] text-stone-400 uppercase tracking-widest">Dilihat</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-stone-700 dark:text-stone-300">{{ number_format($poem->likes_count ?? 0) }}</span>
                                            <span class="text-[9px] text-stone-400 uppercase tracking-widest">Disukai</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($poem->status === 'published')
                                            <a href="{{ route('poems.show', $poem->slug) }}" target="_blank" class="p-2 text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] hover:bg-stone-100 dark:hover:bg-stone-800 rounded-lg transition-all" title="Lihat Publik">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endif
                                        <a href="{{ route('dashboard.poems.edit', $poem) }}" class="p-2 text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] hover:bg-stone-100 dark:hover:bg-stone-800 rounded-lg transition-all" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.poems.destroy', $poem) }}" method="POST" onsubmit="return confirm('Hapus puisi ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-stone-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($poems->hasPages())
                <div class="px-8 py-6 border-t border-stone-100 dark:border-stone-800 bg-stone-50/50 dark:bg-stone-900/20">
                    {{ $poems->links() }}
                </div>
            @endif
        @else
            <div class="py-24 text-center">
                <div class="w-20 h-20 bg-stone-100 dark:bg-stone-900 rounded-3xl flex items-center justify-center mx-auto mb-6 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-stone-300 dark:text-stone-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-2 transition-colors">Tidak ada puisi ditemukan</h3>
                <p class="text-stone-500 dark:text-stone-400 mb-8 max-w-sm mx-auto italic font-serif transition-colors">Arsip Anda saat ini adalah taman yang sunyi. Mungkin saatnya membiarkan tinta berkembang.</p>
                <a href="{{ route('dashboard.poems.create') }}" class="px-8 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-xl font-bold shadow-sm hover:opacity-90 transition-all uppercase tracking-widest text-xs">
                    Tulis Puisi Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
