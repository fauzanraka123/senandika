<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Poem;
use App\Models\Category;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Puisi Terbaru (Paginated)
        $latestPoems = Poem::where('status', 'published')
            ->with(['user', 'category'])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        // 2. Puisi Populer
        $popularPoems = Poem::where('status', 'published')
            ->with(['user'])
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // 3. Puisi dari Penyair yang Diikuti
        $followingPoems = collect();
        if (auth()->check()) {
            $followingIds = auth()->user()->following()->pluck('users.id');
            $followingPoems = Poem::whereIn('user_id', $followingIds)
                ->where('status', 'published')
                ->with(['user', 'category'])
                ->withCount('likes')
                ->latest()
                ->take(5)
                ->get();
        }

        // 4. Sidebar: Penyair Populer
        $topWriters = User::withCount('followers')
            ->where('role', 'writer')
            ->orderByDesc('followers_count')
            ->take(5)
            ->get();

        return view('welcome', compact(
            'latestPoems', 
            'popularPoems', 
            'followingPoems', 
            'topWriters'
        ));
    }
}
