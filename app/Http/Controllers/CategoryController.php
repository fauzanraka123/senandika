<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Poem;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['poems' => function ($query) {
            $query->where('status', 'published');
        }])->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $poems = $category->poems()
            ->where('status', 'published')
            ->with('user')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('categories.show', compact('category', 'poems'));
    }
}
