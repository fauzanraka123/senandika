<article class="bg-white dark:bg-[#151515] p-6 rounded-2xl border border-stone-200 dark:border-stone-800 shadow-sm hover:shadow-md transition-all group h-full flex flex-col">
    @if($poem->category)
        <a href="/categories/{{ $poem->category->slug }}" class="text-xs font-semibold text-[#8B5E3C] dark:text-[#C9A27C] uppercase tracking-wider hover:opacity-80 mb-3 block">
            {{ $poem->category->name }}
        </a>
    @endif
    
    <a href="/poems/{{ $poem->slug }}" class="block mb-2 flex-grow">
        <h4 class="text-2xl font-serif text-[#1A1A1A] dark:text-[#EAEAEA] group-hover:text-[#8B5E3C] dark:group-hover:text-[#C9A27C] transition-colors line-clamp-2">
            {{ $poem->title }}
        </h4>
        <p class="mt-3 text-stone-600 dark:text-stone-400 font-serif italic text-base leading-relaxed line-clamp-3">
            {{ $poem->excerpt ?? \Illuminate\Support\Str::limit($poem->content, 120) }}
        </p>
    </a>
    
    <div class="mt-6 flex items-center justify-between border-t border-stone-100 dark:border-stone-800 pt-4">
        <a href="/authors/{{ $poem->user->id }}" class="flex items-center gap-2 group/author">
            @if($poem->user->avatar)
                <img src="{{ $poem->user->avatar }}" alt="{{ $poem->user->name }}" class="w-8 h-8 rounded-full border border-stone-200 dark:border-stone-700">
            @else
                <div class="w-8 h-8 rounded-full bg-stone-200 dark:bg-stone-700 text-stone-600 dark:text-stone-300 flex items-center justify-center font-serif text-sm">
                    {{ substr($poem->user->name, 0, 1) }}
                </div>
            @endif
            <span class="text-sm font-medium text-stone-600 dark:text-stone-400 group-hover/author:text-[#8B5E3C] dark:group-hover/author:text-[#C9A27C] transition-colors">{{ $poem->user->name }}</span>
        </a>
        <div class="flex items-center gap-3">
            <span class="text-xs text-stone-400 dark:text-stone-500 flex items-center gap-1" title="Views">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ $poem->views }}
            </span>
            <span class="text-xs text-stone-400 dark:text-stone-500">{{ $poem->published_at->format('M d, Y') }}</span>
        </div>
    </div>
</article>
