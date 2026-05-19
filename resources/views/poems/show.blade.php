@extends('layouts.app')

@section('title', $poem->title)

@section('content')
    <article 
        class="bg-[#F8F6F2] dark:bg-[#0F0F0F] min-h-screen pt-8 pb-24 transition-colors duration-300" 
        id="reading-container"
        x-data="poemInteraction({{ $poem->id }}, {{ auth()->check() ? 'true' : 'false' }}, {{ auth()->check() && $poem->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }}, {{ $poem->likes->count() }}, {{ $poem->comments->count() }})"
    >
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Top Navigation & Controls -->
            <div class="mb-8 reading-ui flex items-center justify-between">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/poems' }}" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                
                <button id="focus-btn" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-stone-600 dark:text-stone-300 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-white dark:bg-[#1A1A1A] px-5 py-2.5 rounded-full shadow-sm border border-stone-200 dark:border-stone-800 hover:shadow-md focus:outline-none" title="Mode Fokus">
                    <svg id="focus-icon-on" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l-5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <svg id="focus-icon-off" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l-4-4m11 8V4m0 0h-4m4 0l-4-4M4 16v4m0 0h4m-4 0l-4 4m11-8v4m0 0h-4m4 0l4 4" />
                    </svg>
                    <span id="focus-text" class="hidden sm:inline">Mode Fokus</span>
                </button>
            </div>

            <!-- Main Content Card -->
            <div id="poem-card" class="bg-white dark:bg-[#1A1A1A] rounded-[2rem] p-8 md:p-16 shadow-lg border border-stone-100 dark:border-stone-800 transition-all duration-500">
                <!-- Header -->
                <header class="text-center mb-16">
                    @if($poem->category)
                        <a href="/categories/{{ $poem->category->slug }}" class="inline-block px-4 py-1.5 rounded-full bg-stone-100 dark:bg-[#151515] text-xs font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-wider mb-6 hover:bg-stone-200 dark:hover:bg-[#202020] transition-colors">
                            {{ $poem->category->name }}
                        </a>
                    @endif
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] tracking-tight mb-8 leading-tight transition-colors font-bold">
                        {{ $poem->title }}
                    </h1>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 text-stone-500 dark:text-stone-400 border-b border-stone-100 dark:border-stone-800 pb-8 transition-colors">
                        <a href="/penyair/{{ $poem->user->username ?: $poem->user->id }}" class="flex items-center gap-3 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors group bg-stone-50 dark:bg-[#151515] pr-5 rounded-full">
                            @if($poem->user->avatar)
                                <img src="{{ $poem->user->avatar }}" alt="{{ $poem->user->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-serif text-lg font-bold shadow-sm">
                                    {{ substr($poem->user->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-bold text-sm sm:text-base">{{ $poem->user->name }}</span>
                        </a>
                        
                        <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest">
                            <span class="flex items-center gap-1.5 bg-stone-50 dark:bg-[#151515] px-4 py-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $poem->published_at ? $poem->published_at->translatedFormat('d M Y') : 'Baru' }}
                            </span>
                            <span class="flex items-center gap-1.5 bg-stone-50 dark:bg-[#151515] px-4 py-2 rounded-full" title="Penayangan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $poem->views }}
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Poem Content -->
                <div class="font-serif text-xl md:text-2xl leading-loose whitespace-pre-line text-[#1A1A1A] dark:text-[#EAEAEA] max-w-2xl mx-auto">
                    {{ $poem->content }}
                </div>

                <!-- Tags -->
                @if($poem->tags->count() > 0)
                    <div class="mt-20 pt-8 border-t border-stone-100 dark:border-stone-800 text-center reading-ui transition-colors">
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach($poem->tags as $tag)
                                <span class="px-4 py-1.5 bg-stone-50 dark:bg-[#151515] text-stone-600 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] rounded-full text-[10px] uppercase font-bold tracking-widest transition-colors cursor-pointer">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Interaction Actions -->
                <div class="mt-12 flex flex-wrap justify-center items-center gap-4 reading-ui border-t border-stone-100 dark:border-stone-800 pt-10">
                    <div class="flex items-center bg-stone-50 dark:bg-[#151515] rounded-full overflow-hidden shadow-sm">
                        <!-- Like Button -->
                        <button 
                            @click="toggleLike" 
                            class="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-rose-500 transition-colors px-6 py-3 border-r border-stone-200 dark:border-stone-800"
                            :class="{'text-rose-500': isLiked}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform transform" :class="{'fill-current scale-110': isLiked, 'hover:scale-110': !isLiked}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="font-bold font-sans" x-text="likesCount"></span>
                        </button>
                        
                        <!-- See Who Liked Button -->
                        <button @click="openLikersModal" class="px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-stone-500 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors" x-show="likesCount > 0" x-cloak>
                            Lihat
                        </button>
                    </div>
                    
                    <!-- Comment Button -->
                    <button @click="focusComment" class="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-sky-500 transition-colors bg-stone-50 dark:bg-[#151515] px-6 py-3 rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="font-bold font-sans" x-text="commentsCount"></span>
                    </button>
                    
                    <!-- Share Button -->
                    <button @click="sharePoem" class="flex items-center gap-2 text-stone-500 dark:text-stone-400 hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors bg-stone-50 dark:bg-[#151515] px-6 py-3 rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        <span class="font-bold uppercase text-[10px] tracking-widest">Bagikan</span>
                    </button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-12 reading-ui max-w-3xl mx-auto">
                <h3 class="text-xl font-serif font-bold text-[#1A1A1A] dark:text-[#EAEAEA] mb-8 flex items-center gap-2">
                    Komentar <span class="bg-stone-200 dark:bg-stone-800 text-stone-600 dark:text-stone-400 text-sm px-3 py-1 rounded-full font-sans" x-text="commentsCount"></span>
                </h3>

                <!-- Comment Form -->
                @auth
                    <form @submit.prevent="submitComment" class="mb-12 flex gap-4">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-[#8B5E3C] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <textarea 
                                x-model="newComment"
                                x-ref="commentInput"
                                rows="2" 
                                class="w-full bg-white dark:bg-[#1A1A1A] border border-stone-200 dark:border-stone-800 rounded-2xl px-4 py-3 text-[#1A1A1A] dark:text-[#EAEAEA] focus:ring-2 focus:ring-[#8B5E3C] focus:border-transparent transition-all resize-none shadow-sm placeholder-stone-400"
                                placeholder="Tuliskan apresiasi atau pemikiranmu..."
                                required
                            ></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="bg-[#8B5E3C] hover:bg-[#704B30] dark:bg-[#C9A27C] dark:text-[#1A1A1A] dark:hover:bg-[#DEB887] text-white px-6 py-2 rounded-full font-bold text-[10px] uppercase tracking-widest shadow-md hover:shadow-lg transition-all" :disabled="isSubmitting" :class="{'opacity-50 cursor-not-allowed': isSubmitting}">
                                    <span x-show="!isSubmitting">Kirim Komentar</span>
                                    <span x-show="isSubmitting">Mengirim...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="mb-12 bg-white dark:bg-[#1A1A1A] p-6 rounded-[2rem] border border-stone-100 dark:border-stone-800 shadow-sm text-center">
                        <p class="text-stone-500 dark:text-stone-400 mb-4 font-serif italic">Masuk untuk ikut berdiskusi dan memberikan apresiasi.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-[#8B5E3C] dark:bg-[#C9A27C] dark:text-[#1A1A1A] text-white px-6 py-2 rounded-full font-bold text-[10px] uppercase tracking-widest hover:bg-[#704B30] transition-colors shadow-md">Masuk</a>
                    </div>
                @endauth

                <!-- Comment List -->
                <div class="space-y-6">
                    <template x-for="comment in comments" :key="comment.id">
                        <div class="bg-white dark:bg-[#1A1A1A] p-6 rounded-[2rem] shadow-sm border border-stone-100 dark:border-stone-800 flex gap-4 transition-all hover:shadow-md">
                            <div class="flex-shrink-0">
                                <template x-if="comment.user.avatar">
                                    <img :src="comment.user.avatar" class="w-10 h-10 rounded-full object-cover">
                                </template>
                                <template x-if="!comment.user.avatar">
                                    <div class="w-10 h-10 rounded-full bg-stone-200 dark:bg-[#151515] border border-stone-100 dark:border-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-bold text-sm" x-text="comment.user.name.charAt(0)"></div>
                                </template>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <a :href="'/penyair/' + comment.user.username" class="font-bold text-[#1A1A1A] dark:text-[#EAEAEA] hover:text-[#8B5E3C] dark:hover:text-[#C9A27C] transition-colors" x-text="comment.user.name"></a>
                                        <span class="text-[10px] text-stone-400 uppercase tracking-widest ml-2" x-text="comment.created_at"></span>
                                    </div>
                                    <!-- Delete Button (Only for owner or admin) -->
                                    <template x-if="canDeleteComment(comment)">
                                        <button @click="deleteComment(comment.id)" class="text-stone-400 hover:text-red-500 transition-colors p-1" title="Hapus komentar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </template>
                                </div>
                                <p class="text-stone-700 dark:text-stone-300 leading-relaxed font-sans text-sm whitespace-pre-line" x-text="comment.body"></p>
                            </div>
                        </div>
                    </template>
                    <div x-show="comments.length === 0" class="text-center py-10 bg-white dark:bg-[#1A1A1A] rounded-[2rem] border border-stone-100 dark:border-stone-800" x-cloak>
                        <p class="text-stone-400 font-serif italic text-lg">Belum ada komentar. Jadilah yang pertama memberikan apresiasi!</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Likers Modal -->
        <div x-show="likersModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="likersModalOpen = false" x-transition.opacity></div>
            
            <div class="bg-white dark:bg-[#1A1A1A] rounded-[2rem] shadow-2xl w-full max-w-md relative z-10 overflow-hidden transform transition-all" @click.stop x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                <div class="px-6 py-4 border-b border-stone-100 dark:border-stone-800 flex justify-between items-center bg-stone-50 dark:bg-[#151515]">
                    <h3 class="font-bold text-[#1A1A1A] dark:text-[#EAEAEA] uppercase tracking-widest text-sm">Menyukai Puisi Ini</h3>
                    <button @click="likersModalOpen = false" class="text-stone-400 hover:text-[#1A1A1A] dark:hover:text-[#EAEAEA] transition-colors p-1 bg-white dark:bg-[#1A1A1A] rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto p-2">
                    <template x-for="liker in likers" :key="liker.id">
                        <a :href="'/penyair/' + liker.username" class="flex items-center gap-3 p-4 hover:bg-stone-50 dark:hover:bg-[#151515] rounded-[1.5rem] transition-colors">
                            <template x-if="liker.avatar">
                                <img :src="liker.avatar" class="w-10 h-10 rounded-full object-cover">
                            </template>
                            <template x-if="!liker.avatar">
                                <div class="w-10 h-10 rounded-full bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center font-bold text-sm border border-stone-100 dark:border-stone-800" x-text="liker.name.charAt(0)"></div>
                            </template>
                            <div>
                                <h4 class="font-bold text-sm text-[#1A1A1A] dark:text-[#EAEAEA]" x-text="liker.name"></h4>
                                <p class="text-[10px] text-stone-500 uppercase tracking-widest mt-0.5">Penyair</p>
                            </div>
                        </a>
                    </template>
                    <div x-show="likersLoading" class="p-8 text-center text-stone-400">
                        <svg class="animate-spin h-6 w-6 mx-auto mb-2 text-[#8B5E3C]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memuat...
                    </div>
                </div>
            </div>
        </div>

    </article>

    @php
        $formattedComments = $poem->comments()->with('user')->latest()->get()->map(function($comment) {
            return [
                'id' => $comment->id,
                'body' => $comment->body,
                'user_id' => $comment->user_id,
                'user' => [
                    'name' => $comment->user->name,
                    'username' => $comment->user->username ?: $comment->user->id,
                    'avatar' => $comment->user->avatar,
                ],
                'created_at' => $comment->created_at->diffForHumans()
            ];
        });

        $formattedLikers = $poem->likes()->with('user')->get()->map(function($like) {
            return [
                'id' => $like->user->id,
                'name' => $like->user->name,
                'username' => $like->user->username ?: $like->user->id,
                'avatar' => $like->user->avatar
            ];
        });
    @endphp

    <script>
        // AlpineJS Component for Poem Interactions
        document.addEventListener('alpine:init', () => {
            Alpine.data('poemInteraction', (poemId, isAuthenticated, initialIsLiked, initialLikesCount, initialCommentsCount) => ({
                poemId: poemId,
                isAuthenticated: isAuthenticated,
                isLiked: initialIsLiked,
                likesCount: initialLikesCount,
                commentsCount: initialCommentsCount,
                
                // Comments state
                comments: @json($formattedComments),
                newComment: '',
                isSubmitting: false,
                currentUserId: {{ auth()->id() ?? 'null' }},
                isAdmin: {{ auth()->check() && auth()->user()->isAdmin() ? 'true' : 'false' }},

                // Likers Modal state
                likersModalOpen: false,
                likers: [],
                likersLoading: false,

                async toggleLike() {
                    if (!this.isAuthenticated) {
                        window.location.href = '/login';
                        return;
                    }

                    // Optimistic update
                    this.isLiked = !this.isLiked;
                    this.likesCount += this.isLiked ? 1 : -1;

                    try {
                        const response = await fetch(`/poems/${this.poemId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '{{ csrf_token() }}'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.isLiked = data.is_liked;
                            this.likesCount = data.likes_count;
                        } else {
                            // Revert on error
                            this.isLiked = !this.isLiked;
                            this.likesCount += this.isLiked ? 1 : -1;
                        }
                    } catch (error) {
                        console.error('Error toggling like:', error);
                        // Revert on error
                        this.isLiked = !this.isLiked;
                        this.likesCount += this.isLiked ? 1 : -1;
                    }
                },

                async submitComment() {
                    if (!this.newComment.trim() || this.isSubmitting) return;
                    
                    this.isSubmitting = true;

                    try {
                        const response = await fetch(`/poems/${this.poemId}/comments`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ body: this.newComment })
                        });
                        const data = await response.json();
                        
                        if (data.success) {
                            // Add new comment at the top
                            this.comments.unshift(data.comment);
                            this.commentsCount = data.comments_count;
                            this.newComment = '';
                        }
                    } catch (error) {
                        console.error('Error submitting comment:', error);
                        alert('Gagal mengirim komentar. Silakan coba lagi.');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                canDeleteComment(comment) {
                    return this.isAuthenticated && (this.currentUserId === comment.user_id || this.isAdmin);
                },

                async deleteComment(commentId) {
                    if (!confirm('Apakah Anda yakin ingin menghapus komentar ini?')) return;

                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        
                        if (data.success) {
                            this.comments = this.comments.filter(c => c.id !== commentId);
                            this.commentsCount = data.comments_count;
                        }
                    } catch (error) {
                        console.error('Error deleting comment:', error);
                    }
                },

                openLikersModal() {
                    this.likersModalOpen = true;
                    this.fetchLikers();
                },

                async fetchLikers() {
                    this.likersLoading = true;
                    this.likers = [];
                    // Inject likers inline via Blade JSON
                    this.likers = @json($formattedLikers);
                    this.likersLoading = false;
                },

                focusComment() {
                    if (!this.isAuthenticated) {
                        window.location.href = '/login';
                        return;
                    }
                    this.$refs.commentInput?.focus();
                },

                sharePoem() {
                    if (navigator.share) {
                        navigator.share({
                            title: '{{ addslashes($poem->title) }} oleh {{ addslashes($poem->user->name) }}',
                            text: 'Baca puisi "{{ addslashes($poem->title) }}" di RupaKata.',
                            url: window.location.href
                        }).catch(console.error);
                    } else {
                        // Fallback to copy clipboard
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            alert('Tautan puisi berhasil disalin ke clipboard!');
                        });
                    }
                }
            }));
        });

        // Legacy Focus Mode Script (adapted to not break)
        const focusBtn = document.getElementById('focus-btn');
        const iconOn = document.getElementById('focus-icon-on');
        const iconOff = document.getElementById('focus-icon-off');
        const focusText = document.getElementById('focus-text');
        const readingUiElements = document.querySelectorAll('.reading-ui');
        const nav = document.querySelector('nav');
        const footer = document.querySelector('footer');
        const poemCard = document.getElementById('poem-card');
        let focusMode = false;

        if (focusBtn) {
            focusBtn.addEventListener('click', () => {
                focusMode = !focusMode;
                
                if (focusMode) {
                    iconOn.classList.add('hidden');
                    iconOff.classList.remove('hidden');
                    focusText.textContent = "Keluar Fokus";
                    
                    if(nav) nav.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    if(footer) footer.classList.add('opacity-0', 'pointer-events-none');
                    
                    // Hide UI elements with smooth transition
                    readingUiElements.forEach(el => {
                        if(el !== focusBtn.parentElement) {
                            el.style.opacity = '0';
                            el.style.pointerEvents = 'none';
                            el.style.height = '0';
                            el.style.overflow = 'hidden';
                            el.style.margin = '0';
                            el.style.padding = '0';
                        }
                    });
                    
                    // Make card minimalist
                    poemCard.classList.remove('shadow-lg', 'bg-white', 'dark:bg-[#1A1A1A]', 'border', 'border-stone-100', 'dark:border-stone-800', 'p-8', 'md:p-16');
                    poemCard.classList.add('shadow-none', 'bg-transparent', 'border-transparent', 'p-4', 'md:p-8');
                } else {
                    iconOff.classList.add('hidden');
                    iconOn.classList.remove('hidden');
                    focusText.textContent = "Mode Fokus";
                    
                    if(nav) nav.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
                    if(footer) footer.classList.remove('opacity-0', 'pointer-events-none');
                    
                    // Restore UI elements
                    readingUiElements.forEach(el => {
                        if(el !== focusBtn.parentElement) {
                            el.style.opacity = '';
                            el.style.pointerEvents = '';
                            el.style.height = '';
                            el.style.overflow = '';
                            el.style.margin = '';
                            el.style.padding = '';
                        }
                    });
                    
                    // Restore card style
                    poemCard.classList.add('shadow-lg', 'bg-white', 'dark:bg-[#1A1A1A]', 'border', 'border-stone-100', 'dark:border-stone-800', 'p-8', 'md:p-16');
                    poemCard.classList.remove('shadow-none', 'bg-transparent', 'border-transparent', 'p-4', 'md:p-8');
                }
            });
        }
    </script>
@endsection
