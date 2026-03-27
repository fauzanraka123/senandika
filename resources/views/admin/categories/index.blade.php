@extends('layouts.admin')

@section('header', 'Manage Categories')

@section('content')
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-lg text-sm border border-green-200 mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-200 mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Add Category Form -->
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm sticky top-24">
                <h3 class="font-bold text-stone-800 mb-4 text-sm uppercase tracking-wider">Add New Category</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-bold text-stone-500 mb-1 tracking-tight">Name</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-2 focus:ring-[#8B5E3C] outline-none text-sm" placeholder="e.g. Surrealism">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#8B5E3C] hover:bg-[#6a4428] text-white rounded-lg text-sm font-bold transition-colors">
                        Create Category
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden text-sm">
                <table class="w-full text-left">
                    <thead class="bg-stone-50 border-b border-stone-100 uppercase text-[10px] font-bold text-stone-500 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Poems</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-stone-50">
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $category->name }}" class="bg-transparent border-none focus:ring-1 focus:ring-stone-200 rounded px-1 -mx-1 font-medium text-stone-900 w-full">
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-stone-500 font-mono text-[11px]">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-stone-500 font-bold">{{ $category->poems_count }}</td>
                                <td class="px-6 py-4 text-right flex justify-end gap-3">
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-stone-400 hover:text-red-500 transition-colors">
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
            </div>
            <p class="mt-4 text-[10px] text-stone-400 italic">Tip: Click on a category name and press enter to rename it.</p>
        </div>
    </div>
@endsection
