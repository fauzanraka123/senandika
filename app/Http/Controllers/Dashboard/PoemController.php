<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->poems()
            ->with(['category', 'tags']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $poems = $query->orderByDesc('created_at')->paginate(10);
            
        return view('dashboard.poems.index', compact('poems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('dashboard.poems.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('covers', 'public');
        }

        $poem = auth()->user()->poems()->create([
            'title' => $validated['title'],
            'slug' => str($validated['title'])->slug() . '-' . rand(1000, 9999),
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? null,
            'status' => $validated['status'],
            'cover_image' => $imagePath,
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => trim($name)], ['slug' => str($name)->slug()]);
                $tagIds[] = $tag->id;
            }
            $poem->tags()->sync($tagIds);
        }

        return redirect()->route('dashboard.poems.index')->with('success', 'Puisi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('dashboard.poems.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $poem = auth()->user()->poems()->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('dashboard.poems.edit', compact('poem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $poem = auth()->user()->poems()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($poem->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($poem->cover_image);
            }
            $poem->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $poem->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? $poem->excerpt,
            'status' => $validated['status'],
            'published_at' => ($poem->status !== 'published' && $validated['status'] === 'published') ? now() : $poem->published_at,
        ]);

        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => trim($name)], ['slug' => str($name)->slug()]);
                $tagIds[] = $tag->id;
            }
            $poem->tags()->sync($tagIds);
        }

        return redirect()->route('dashboard.poems.index')->with('success', 'Puisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poem = auth()->user()->poems()->findOrFail($id);
        $poem->delete();

        return redirect()->route('dashboard.poems.index')->with('success', 'Puisi berhasil dihapus.');
    }
}
