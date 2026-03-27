@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil')
@section('header', 'Profil Anda')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/10 text-green-700 dark:text-green-400 p-4 rounded-2xl mb-8 text-sm border border-green-100 dark:border-green-900/30 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: Basic Info -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-[#151515] p-8 rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm space-y-6 transition-colors duration-300">
                        <h2 class="text-sm font-bold text-stone-400 uppercase tracking-[0.2em] mb-4">Identitas</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full px-4 py-3 bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl focus:ring-0 focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] outline-none transition-all text-sm"
                                    placeholder="Nama Anda" required>
                                @error('name') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="username" class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Username</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 text-sm">@</span>
                                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" 
                                        class="w-full pl-8 pr-4 py-3 bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl focus:ring-0 focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] outline-none transition-all text-sm"
                                        placeholder="poet_name">
                                </div>
                                @error('username') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="bio" class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Biografi Penulis</label>
                            <textarea name="bio" id="bio" rows="4" 
                                class="w-full px-4 py-3 bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl focus:ring-0 focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] outline-none transition-all font-serif italic text-lg"
                                placeholder="Tuliskan refleksi dari jiwamu...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#151515] p-8 rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm space-y-6 transition-colors duration-300">
                        <h2 class="text-sm font-bold text-stone-400 uppercase tracking-[0.2em] mb-4">Jejaring Sosial</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="social_instagram" class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Username Instagram</label>
                                <input type="text" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $user->social_links['instagram'] ?? '') }}" 
                                    class="w-full px-4 py-3 bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl focus:ring-0 focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] outline-none transition-all text-sm"
                                    placeholder="username">
                            </div>
                            <div>
                                <label for="social_twitter" class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Username Twitter / X</label>
                                <input type="text" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $user->social_links['twitter'] ?? '') }}" 
                                    class="w-full px-4 py-3 bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl focus:ring-0 focus:border-[#8B5E3C] dark:focus:border-[#C9A27C] outline-none transition-all text-sm"
                                    placeholder="username">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Photo -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-[#151515] p-8 rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm text-center transition-colors duration-300">
                        <h2 class="text-sm font-bold text-stone-400 uppercase tracking-[0.2em] mb-6 text-left">Pas Foto</h2>

                        <div x-data="{ photoName: null, photoPreview: null }" class="space-y-6">
                            <input type="file" class="hidden" x-ref="photo"
                                        @change="
                                            photoName = $event.target.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($event.target.files[0]);
                                        " name="avatar">

                            <div class="relative inline-block mx-auto group">
                                <div x-show="!photoPreview" class="w-32 h-32 rounded-full overflow-hidden border-4 border-stone-50 dark:border-[#0A0A0A] shadow-lg transition-all">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#8B5E3C] text-white flex items-center justify-center font-serif text-5xl italic">{{ substr($user->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div x-show="photoPreview" style="display: none;" class="w-32 h-32 rounded-full overflow-hidden border-4 border-stone-50 dark:border-[#0A0A0A] shadow-lg">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </div>
                                <button type="button" @click.prevent="$refs.photo.click()" class="absolute -bottom-2 -right-2 bg-white dark:bg-[#1A1A1A] p-2 rounded-full shadow-lg border border-stone-200 dark:border-stone-800 hover:text-[#8B5E3C] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                            </div>

                            <p class="text-xs text-stone-400 leading-relaxed px-4">Unggah foto berkualitas tinggi. PNG, JPG hingga 1MB.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-[#8B5E3C] dark:bg-[#C9A27C] text-white dark:text-[#1A1A1A] rounded-2xl font-bold shadow-lg hover:opacity-90 transition-all uppercase tracking-widest text-xs">
                            Simpan
                        </button>
                        <a href="{{ route('dashboard') }}" class="w-full py-4 bg-white dark:bg-[#151515] text-stone-400 rounded-2xl font-bold border border-stone-200 dark:border-stone-800 hover:bg-stone-50 dark:hover:bg-stone-900 transition-all uppercase tracking-widest text-xs text-center">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
