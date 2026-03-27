<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poem;
use Illuminate\Http\Request;

class DiscoveryController extends Controller
{
    public function writers()
    {
        $writers = User::has('poems')
            ->withCount(['followers', 'poems' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderByDesc('followers_count')
            ->paginate(12);

        return view('social.writers', compact('writers'));
    }

    public function feed()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');

        $poems = Poem::whereIn('user_id', $followingIds)
            ->where('status', 'published')
            ->with(['user', 'category'])
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('social.feed', compact('poems'));
    }
}
