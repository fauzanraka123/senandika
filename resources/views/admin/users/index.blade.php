@extends('layouts.admin')

@section('header', 'Manage Users')

@section('content')
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-lg text-sm border border-green-200 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden text-sm">
        <table class="w-full text-left">
            <thead class="bg-stone-50 border-b border-stone-100 uppercase text-[10px] font-bold text-stone-500 tracking-widest">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Joined</th>
                    <th class="px-6 py-4">Poems</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($users as $user)
                    <tr class="hover:bg-stone-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" class="w-8 h-8 rounded-full">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center text-[10px] font-bold text-stone-400 border border-stone-200">{{ substr($user->name, 0, 1) }}</div>
                                @endif
                                <div>
                                    <p class="font-bold text-stone-900 leading-none">{{ $user->name }}</p>
                                    <p class="text-[10px] text-stone-400 mt-1">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-stone-500 font-bold">{{ $user->poems_count }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()" class="bg-stone-50 border border-stone-200 rounded px-2 py-1 text-[10px] font-bold uppercase tracking-tight {{ $user->role === 'admin' ? 'text-red-600 bg-red-50' : ($user->role === 'writer' ? 'text-blue-600 bg-blue-50' : 'text-stone-600') }}">
                                    <option value="reader" {{ $user->role === 'reader' ? 'selected' : '' }}>Reader</option>
                                    <option value="writer" {{ $user->role === 'writer' ? 'selected' : '' }}>Writer</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Permanently delete this user?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-stone-400 hover:text-red-500 transition-colors {{ $user->id === auth()->id() ? 'opacity-20 cursor-not-allowed' : '' }}" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-stone-100 bg-stone-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
