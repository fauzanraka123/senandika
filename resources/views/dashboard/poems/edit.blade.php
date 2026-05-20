@extends('layouts.dashboard')

@section('title', 'Edit Puisi: ' . $poem->title)
@section('header', 'Edit Puisi')

@section('content')
<div x-data="{ 
    title: '{{ addslashes($poem->title) }}', 
    content: `{{ addslashes($poem->content) }}`, 
    category: '{{ $poem->category_id }}',
    categories: {{ $categories->toJson() }},
    get categoryName() {
        let cat = this.categories.find(c => c.id == this.category);
        return cat ? cat.name : 'Pilih Kategori';
    }
}" class="h-[calc(100vh-120px)] flex flex-col -m-8">
    <form action="{{ route('dashboard.poems.update', $poem) }}" method="POST" enctype="multipart/form-data" class="flex flex-1 overflow-hidden">
        @csrf
        @method('PUT')
        
        <!-- Editor Side -->
        <div class="w-1/2 p-8 overflow-y-auto bg-white dark:bg-[#0F0F0F] border-r border-stone-200 dark:border-stone-800 custom-scrollbar">
            <div class="max-w-xl mx-auto space-y-8 pb-20">
                <!-- Title -->
                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Judul Puisi</label>
                    <input type="text" name="title" x-model="title" placeholder="Tuliskan judul puisi Anda..." 
                        class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-lg font-serif transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0 placeholder-stone-400 px-4 py-3"
                        required>
                </div>

                <!-- Meta Row -->
                <div class="w-full">
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Tema / Kategori</label>
                    <select name="category_id" x-model="category" 
                        class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-sm transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0 px-4 py-3">
                        <option value="">Pilih Tema</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Excerpt -->
                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Ringkasan / Sinopsis (Opsional)</label>
                    <textarea name="excerpt" placeholder="Bisikan singkat tentang apa yang ada di dalamnya..." 
                        class="w-full bg-stone-50 dark:bg-stone-900 border-stone-200 dark:border-stone-800 rounded-xl text-sm transition-colors focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] focus:ring-0 p-4 h-24 resize-none placeholder-stone-400">{{ old('excerpt', $poem->excerpt) }}</textarea>
                </div>

                <!-- Content Area -->
                <div class="relative min-h-[400px] flex flex-col" x-init="
                    const quill = new Quill($refs.quillEditor, {
                        theme: 'snow',
                        placeholder: 'Biarkan kata-kata mengalir...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                ['blockquote'],
                                [{ 'align': [] }],
                                ['clean']
                            ]
                        }
                    });
                    
                    if (content) {
                        quill.root.innerHTML = content;
                    }
                    
                    quill.on('text-change', () => {
                        let html = quill.root.innerHTML;
                        content = html === '<p><br></p>' ? '' : html;
                    });
                ">
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">Isi Puisi</label>
                    <input type="hidden" name="content" :value="content" required>
                    <div class="flex-grow bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl overflow-hidden transition-colors flex flex-col">
                        <div x-ref="quillEditor" class="flex-grow font-serif text-lg leading-relaxed text-[#1A1A1A] dark:text-[#EAEAEA]"></div>
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

                <div class="font-serif text-xl md:text-2xl leading-[2.2] text-stone-900 dark:text-[#D1D1D1] text-center transition-all quill-content" 
                    :class="!content && 'opacity-30'">
                    <template x-if="content">
                        <div x-html="content"></div>
                    </template>
                    <template x-if="!content">
                        <p class="italic">Tinta menanti sentuhanmu...</p>
                    </template>
                </div>
            </div>
        </div>

        <!-- Float Actions -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 flex items-center bg-white dark:bg-[#151515] p-2 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-2xl z-50">
            <button type="submit" name="status" value="published" 
                class="px-8 py-3 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-xl font-bold text-sm shadow-sm hover:opacity-90 transition-all">
                {{ $poem->status === 'published' ? 'Perbarui Puisi' : 'Terbitkan Puisi' }}
            </button>
            @if($poem->status !== 'published')
            <button type="submit" name="status" value="draft" 
                class="px-8 py-3 bg-transparent text-stone-600 dark:text-stone-400 rounded-xl font-bold text-sm hover:bg-stone-50 dark:hover:bg-stone-900 transition-all">
                Tetap sebagai Draf
            </button>
            @endif
            <div class="w-px h-6 bg-stone-100 dark:bg-stone-800 mx-2"></div>
            <a href="{{ route('dashboard.poems.index') }}" 
                class="px-6 py-3 text-stone-400 hover:text-red-500 rounded-xl text-sm font-medium transition-all">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    /* Quill custom styling for RuangKata */
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e5e7eb !important;
        font-family: ui-sans-serif, system-ui, sans-serif !important;
        padding: 12px 16px !important;
    }
    .dark .ql-toolbar.ql-snow {
        border-bottom-color: #27272a !important;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-family: inherit !important;
        font-size: inherit !important;
    }
    .ql-editor {
        min-height: 300px;
        padding: 20px !important;
    }
    .ql-editor.ql-blank::before {
        color: #a8a29e;
        font-style: italic;
    }
    .dark .ql-editor.ql-blank::before {
        color: #52525b;
    }
    .dark .ql-snow .ql-stroke {
        stroke: #a1a1aa;
    }
    .dark .ql-snow .ql-fill, .dark .ql-snow .ql-stroke.ql-fill {
        fill: #a1a1aa;
    }
    .dark .ql-snow .ql-picker {
        color: #a1a1aa;
    }
    
    /* Quill content styles for preview */
    .quill-content p {
        margin-bottom: 1.5em;
    }
    .quill-content blockquote {
        border-left: 4px solid #8B5E3C;
        padding-left: 1rem;
        margin-left: 0;
        margin-right: 0;
        font-style: italic;
        color: #57534e;
    }
    .dark .quill-content blockquote {
        border-left-color: #C9A27C;
        color: #a8a29e;
    }

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
