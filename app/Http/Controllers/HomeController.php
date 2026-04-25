<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Service;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $videos = Video::where('is_published', true)
            ->with('service')
            ->orderBy('sort_order')
            ->orderByDesc('is_featured')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $services = Service::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(4)
            ->get();

        $blogCategories = Category::where('is_active', true)
            ->withCount([
                'blogs as published_blogs_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->having('published_blogs_count', '>', 0)
            ->orderByDesc('published_blogs_count')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('index', compact(
            'blogs',
            'videos',
            'services',
            'blogCategories'
        ));
    }
}
