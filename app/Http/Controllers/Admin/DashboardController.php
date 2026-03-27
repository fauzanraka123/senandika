<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Poem;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_poems' => Poem::count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentPoems = Poem::with(['user', 'category'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentPoems'));
    }
}
