<div class="space-y-6 bg-white p-8 rounded-xl border border-stone-200 shadow-sm">
    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-stone-700 mb-2">Judul Puisi</label>
        <input type="text" name="title" id="title" value="{{ old('title', $poem->title ?? '') }}" 
            class="w-full px-4 py-3 border border-stone-200 rounded-lg focus:ring-2 focus:ring-[#8B5E3C] focus:border-[#8B5E3C] outline-none transition-all font-serif text-xl"
            placeholder="Masukan Judul Puisi..." required>
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div>
        <label for="category_id" class="block text-sm font-medium text-stone-700 mb-2">Kategori</label>
        <select name="category_id" id="category_id" 
            class="w-full px-4 py-3 border border-stone-200 rounded-lg focus:ring-2 focus:ring-[#8B5E3C] focus:border-[#8B5E3C] outline-none transition-all cursor-pointer">
            <option value="" disabled {{ !isset($poem) ? 'selected' : '' }}>Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $poem->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Excerpt (Optional) -->
    <div>
        <label for="Kutipan" class="block text-sm font-medium text-stone-700 mb-2">Kutipan <span class="text-stone-400 font-normal">(Sedikit kutipan untuk daftar)</span></label>
        <textarea name="excerpt" id="excerpt" rows="2" 
            class="w-full px-4 py-3 border border-stone-200 rounded-lg focus:ring-2 focus:ring-[#8B5E3C] focus:border-[#8B5E3C] outline-none transition-all italic font-serif"
            placeholder="Komponen refleksi singkat dalam puisi Anda...">{{ old('excerpt', $poem->excerpt ?? '') }}</textarea>
        @error('excerpt')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <label for="Puisi" class="block text-sm font-medium text-stone-700 mb-2">Isi Puisi</label>
        <textarea name="content" id="content" rows="12" 
            class="w-full px-4 py-6 border border-stone-200 rounded-lg focus:ring-2 focus:ring-[#8B5E3C] focus:border-[#8B5E3C] outline-none transition-all font-serif text-lg leading-relaxed whitespace-pre-wrap"
            placeholder="Masukan Isi Puisi..." required>{{ old('content', $poem->content ?? '') }}</textarea>
        <p class="mt-2 text-xs text-stone-400 italic">Line breaks and spacing will be preserved exactly as you write them.</p>
        @error('content')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
