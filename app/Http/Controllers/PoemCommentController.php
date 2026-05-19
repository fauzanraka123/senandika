<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poem;
use App\Models\Comment;

class PoemCommentController extends Controller
{
    public function store(Request $request, Poem $poem)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $poem->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
            'is_approved' => true, // Auto approve for now
        ]);
        
        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'user' => [
                    'name' => $comment->user->name,
                    'username' => $comment->user->username ?? $comment->user->id,
                    'avatar' => $comment->user->avatar,
                ],
                'created_at' => $comment->created_at->diffForHumans(),
            ],
            'comments_count' => $poem->comments()->count(),
        ]);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id && !$request->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $poemId = $comment->poem_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'comments_count' => Comment::where('poem_id', $poemId)->count(),
        ]);
    }
}
