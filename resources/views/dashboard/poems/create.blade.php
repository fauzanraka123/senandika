@extends('layouts.dashboard')

@section('title', 'Tulis Puisi Baru')
@section('header', 'Puisi Baru')

@section('content')
<div x-data="{ 
    title: '', 
    content: '', 
    category: '',
    categories: {{ $categories->toJson() }},
    get categoryName() {
        let cat = this.categories.find(c => c.id == this.category);
        return cat ? cat.name : 'Pilih Kategori';
    }
}" class="h-[calc(100vh-120px)] flex flex-col -m-8">
    <form action="{{ route('dashboard.poems.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-1 overflow-hidden">
        @csrf
        
        <!-- Editor Side -->
        <div class="w-1/2 p-8 overflow-y-auto bg-white dark:bg-[#0F0F0F] border-r border-stone-200 dark:border-stone-800 custom-scrollbar">
            <div class="max-w-xl mx-auto space-y-8 pb-20">
                <!-- Title -->
                <div>
                    <input type="text" name="title" x-model="title" placeholder="Judul Puisi" 
                        class="w-full text-4xl font-serif bg-transparent border-none focus:ring-0 placeholder-stone-300 dark:placeholder-stone-700 text-[#1A1A1A] dark:text-[#EAEAEA] p-0"
                        required>
                    <div class="h-px bg-stone-100 dark:bg-stone-800 mt-4 w-24"></div>
                </div>

                <!-- Meta Row -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Kategori</label>
                        <select name="category_id" x-model="category" 
                            class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-sm transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Tag (Pisahkan dengan koma)</label>
                        <input type="text" name="tags" placeholder="cinta, alam, kehidupan..." 
                            class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-sm transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0 placeholder-stone-400">
                    </div>
                </div>

                <!-- Excerpt -->
                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Ringkasan / Sinopsis (Opsional)</label>
                    <textarea name="excerpt" placeholder="Bisikan singkat tentang apa yang ada di dalamnya..." 
                        class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-sm transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0 p-4 h-24 resize-none placeholder-stone-400"></textarea>
                </div>

                <!-- Content Area -->
                <div class="relative min-h-[400px]">
                    <textarea name="content" x-model="content" placeholder="Biarkan kata-kata mengalir..." 
                        class="w-full h-full min-h-[400px] bg-transparent border-none focus:ring-0 font-serif text-lg leading-relaxed text-stone-800 dark:text-stone-300 p-0 resize-none placeholder-stone-300 dark:placeholder-stone-700 custom-scrollbar"
                        required></textarea>
                </div>

                <!-- Cover Image -->
                <div x-data="{ filename: '' }">
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Sampul Puisi</label>
                    <div class="flex items-center gap-4">
                        <label class="cursor-pointer bg-stone-100 dark:bg-stone-900 px-4 py-2 rounded-xl text-xs font-bold text-stone-600 dark:text-stone-400 hover:bg-stone-200 dark:hover:bg-stone-800 transition-all border border-stone-200 dark:border-stone-800">
                            <span>Pilih Berkas</span>
                            <input type="file" name="cover_image" class="hidden" @change="filename = $event.target.files[0].name">
                        </label>
                        <span class="text-xs text-stone-400 truncate max-w-xs" x-text="filename || 'Tidak ada berkas terpilih'"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Side -->
        <div class="w-1/2 bg-[#F8F6F2] dark:bg-[#0A0A0A] overflow-y-auto p-12 lg:p-20 custom-scrollbar transition-colors">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-16">
                    <span class="text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-[0.3em] mb-4 block" x-text="categoryName"></span>
                    <h1 class="text-5xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] mb-6 leading-tight break-words" x-text="title || 'Karya Tanpa Judul'"></h1>
                    <div class="w-12 h-px bg-stone-300 dark:bg-stone-700 mx-auto"></div>
                </div>

                <div class="font-serif text-xl md:text-2xl leading-[2.2] text-stone-900 dark:text-[#D1D1D1] whitespace-pre-wrap text-center opacity-90 transition-all italic" 
                    :class="!content && 'opacity-30'" x-text="content || 'Tinta menanti sentuhanmu...'">
                </div>
            </div>
        </div>

        <!-- Float Actions -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 flex items-center bg-white dark:bg-[#151515] p-2 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-2xl z-50">
            <button type="submit" name="status" value="published" 
                class="px-8 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-xl font-bold text-sm shadow-sm hover:opacity-90 transition-all">
                Terbitkan Puisi
            </button>
            <button type="submit" name="status" value="draft" 
                class="px-8 py-3 bg-transparent text-stone-600 dark:text-stone-400 rounded-xl font-bold text-sm hover:bg-stone-50 dark:hover:bg-stone-900 transition-all">
                Simpan Draf
            </button>
            <div class="w-px h-6 bg-stone-100 dark:bg-stone-800 mx-2"></div>
            <a href="{{ route('dashboard.poems.index') }}" 
                class="px-6 py-3 text-stone-400 hover:text-red-500 rounded-xl text-sm font-medium transition-all">
                Batalkan
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1e293b;
    }
</style>
@endpush
