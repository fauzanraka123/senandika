<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Poem;
use App\Models\Like;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_poems' => $user->poems()->count(),
            'published_poems' => $user->poems()->where('status', 'published')->count(),
            'draft_poems' => $user->poems()->where('status', 'draft')->count(),
            'total_views' => $user->poems()->sum('views'),
            'total_likes' => Like::whereIn('poem_id', $user->poems()->pluck('id'))->count(),
            'followers_count' => $user->followers()->count(),
        ];

        $recentPoems = $user->poems()->latest()->take(5)->get();
        
        $followingIds = $user->following()->pluck('users.id');
        $socialFeed = Poem::whereIn('user_id', $followingIds)
            ->where('status', 'published')
            ->with(['user', 'category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('dashboard.index', compact('stats', 'recentPoems', 'socialFeed'));
    }
}
