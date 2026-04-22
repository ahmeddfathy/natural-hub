<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::where('is_published', true)
            ->with('category')
            ->orderBy('published_at', 'desc');

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $blogs      = $query->paginate(9);
        $categories = Category::withCount('blogs')->orderBy('sort_order')->get();

        // Latest 3 for the featured strip (exclude paginated results when searching)
        $featuredBlogs = Blog::where('is_published', true)
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('blog.index', compact('blogs', 'categories', 'featuredBlogs'));

    }

    public function show(Blog $blog)
    {
        abort_unless($blog->is_published, 404);

        // Related posts (same category)
        $relatedBlogs = Blog::where('is_published', true)
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Recent posts for sidebar
        $recentBlogs = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $categories = Category::withCount('blogs')->orderBy('sort_order')->get();

        return view('blog.show', compact('blog', 'relatedBlogs', 'recentBlogs', 'categories'));

    }
}

