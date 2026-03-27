<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Poem;
use App\Models\Category;

class PoemController extends Controller
{
    public function index()
    {
        $poems = Poem::where('status', 'published')
            ->with(['user', 'category'])
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('poems.index', compact('poems'));
    }

    public function show($slug)
    {
        $poem = Poem::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'category', 'tags', 'comments.user'])
            ->firstOrFail();

        // Increment views
        $poem->increment('views');

        return view('poems.show', compact('poem'));
    }
}
