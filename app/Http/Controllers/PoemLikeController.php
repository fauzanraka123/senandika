<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poem;

class PoemLikeController extends Controller
{
    public function toggle(Request $request, Poem $poem)
    {
        $user = $request->user();
        
        $like = $poem->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $poem->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }
        
        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $poem->likes()->count(),
        ]);
    }
}
