<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Poem;

class AuthorController extends Controller
{
    public function show($username)
    {
        $author = User::where('username', $username)
            ->orWhere('id', $username)
            ->withCount(['followers', 'following', 'poems' => function ($query) {
                $query->where('status', 'published');
            }])
            ->firstOrFail();

        $latestPoem = Poem::where('user_id', $author->id)
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->withCount('likes')
            ->latest()
            ->first();

        $poems = Poem::where('user_id', $author->id)
            ->where('status', 'published')
            ->with(['user', 'category'])
            ->withCount('likes')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('authors.show', compact('author', 'latestPoem', 'poems'));
    }
}
