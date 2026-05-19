<article class="bg-white dark:bg-[#1A1A1A] p-8 rounded-[2rem] border border-stone-100 dark:border-stone-800 shadow-sm hover:shadow-xl transition-all duration-300 group h-full flex flex-col relative overflow-hidden">
    <!-- Subtle hover background effect -->
    <div class="absolute inset-0 bg-gradient-to-br from-stone-50 to-transparent dark:from-stone-800/10 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>

    <div class="relative z-10 flex-grow flex flex-col">
        @if($poem->category)
            <a href="/categories/{{ $poem->category->slug }}" class="inline-block self-start px-3 py-1 bg-stone-50 dark:bg-[#151515] text-[10px] font-bold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-widest rounded-full hover:bg-stone-100 dark:hover:bg-[#202020] transition-colors mb-4">
                {{ $poem->category->name }}
            </a>
        @endif
        
        <a href="/poems/{{ $poem->slug }}" class="block mb-2 flex-grow">
            <h4 class="text-2xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors line-clamp-2 font-bold mb-3">
                {{ $poem->title }}
            </h4>
            <p class="text-stone-600 dark:text-stone-400 font-serif italic text-lg leading-relaxed line-clamp-3">
                "{{ $poem->excerpt ?? \Illuminate\Support\Str::limit($poem->content, 120) }}"
            </p>
        </a>
    </div>
    
    <div class="mt-6 flex items-center justify-between border-t border-stone-100 dark:border-stone-800/60 pt-5 relative z-10">
        <a href="/authors/{{ $poem->user->id }}" class="flex items-center gap-3 group/author">
            @if($poem->user->avatar)
                <img src="{{ $poem->user->avatar }}" alt="{{ $poem->user->name }}" class="w-10 h-10 rounded-full border border-stone-100 dark:border-stone-800 object-cover shadow-sm">
            @else
                <div class="w-10 h-10 rounded-full bg-stone-100 dark:bg-[#151515] text-stone-600 dark:text-stone-300 flex items-center justify-center font-serif font-bold text-sm shadow-sm border border-stone-100 dark:border-stone-800">
                    {{ substr($poem->user->name, 0, 1) }}
                </div>
            @endif
            <span class="text-sm font-bold text-[#1A1A1A] dark:text-[#EAEAEA] group-hover/author:text-[#8B5E3C] dark:group-hover/author:text-[#C9A27C] transition-colors">{{ $poem->user->name }}</span>
        </a>
        <div class="flex flex-col items-end gap-1.5">
            <span class="text-[10px] text-stone-400 font-bold uppercase tracking-widest">{{ $poem->published_at->format('M d, Y') }}</span>
            <div class="flex items-center gap-1.5">
                <span class="text-xs text-stone-500 flex items-center gap-1 font-medium bg-stone-50 dark:bg-[#151515] px-2 py-0.5 rounded-full" title="Views">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ $poem->views }}
                </span>
                <span class="text-xs text-stone-500 flex items-center gap-1 font-medium bg-stone-50 dark:bg-[#151515] px-2 py-0.5 rounded-full" title="Likes">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ $poem->likes_count ?? ($poem->likes ? $poem->likes->count() : 0) }}
                </span>
            </div>
        </div>
    </div>
</article>
