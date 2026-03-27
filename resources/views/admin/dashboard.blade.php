@extends('layouts.admin')

@section('header', 'System Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm">
            <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-2">Total Poems</p>
            <div class="text-3xl font-bold text-stone-900">{{ number_format($stats['total_poems']) }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm">
            <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-2">Total Users</p>
            <div class="text-3xl font-bold text-stone-900">{{ number_format($stats['total_users']) }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm">
            <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-2">Categories</p>
            <div class="text-3xl font-bold text-stone-900">{{ number_format($stats['total_categories']) }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm">
            <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-2">Pending Comments</p>
            <div class="text-3xl font-bold text-orange-500">{{ number_format($stats['pending_comments']) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-stone-100 flex items-center justify-between">
                <h2 class="font-bold text-stone-800">Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-[#8B5E3C] hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-stone-100">
                @foreach($recentUsers as $user)
                    <li class="p-4 flex items-center gap-4">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" class="w-10 h-10 rounded-full">
                        @else
                            <div class="w-10 h-10 rounded-full bg-stone-100 flex items-center justify-center text-stone-400 font-bold uppercase">{{ substr($user->name, 0, 1) }}</div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-bold text-stone-900">{{ $user->name }}</p>
                            <p class="text-xs text-stone-500">{{ $user->email }}</p>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2 py-1 rounded bg-stone-100 text-stone-600">{{ $user->role }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Recent Poems -->
        <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-stone-100 flex items-center justify-between">
                <h2 class="font-bold text-stone-800">Recent Poems</h2>
                <a href="/poems" target="_blank" class="text-sm text-[#8B5E3C] hover:underline">View Public</a>
            </div>
            <ul class="divide-y divide-stone-100">
                @foreach($recentPoems as $poem)
                    <li class="p-4">
                        <p class="text-sm font-bold text-stone-900 truncate">{{ $poem->title }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-stone-500">By {{ $poem->user->name }}</span>
                            <span class="text-stone-300">&bull;</span>
                            <span class="text-xs text-[#8B5E3C]">{{ $poem->category->name ?? 'N/A' }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
