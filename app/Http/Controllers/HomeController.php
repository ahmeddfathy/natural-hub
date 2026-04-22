<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Field;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('category.parent')
            ->orderBy('sort_order')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $blogs = Blog::where('is_published', true)
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $videos = Video::where('is_published', true)
            ->with('category.parent')
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

        $fields = Field::where('is_active', true)
            ->withCount([
                'videos as featured_videos_count' => function ($query) {
                    $query->where('is_published', true)
                        ->where('is_featured', true);
                },
                'videos as published_videos_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->orderByDesc('featured_videos_count')
            ->orderByDesc('published_videos_count')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(6)
            ->get();

        $videoFields = Field::where('is_active', true)
            ->with(['videos' => function ($query) {
                $query->where('is_published', true)
                    ->with('category')
                    ->orderBy('sort_order')
                    ->orderByDesc('is_featured')
                    ->orderBy('published_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->take(10);
            }])
            ->withCount([
                'videos as featured_videos_count' => function ($query) {
                    $query->where('is_published', true)
                        ->where('is_featured', true);
                },
                'videos as published_videos_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->having('published_videos_count', '>', 0)
            ->orderByDesc('featured_videos_count')
            ->orderByDesc('published_videos_count')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(6)
            ->get();

        $videoFields = $videoFields->filter(function ($field) {
            return $field->videos->isNotEmpty();
        })->values();

        return view('index', compact(
            'portfolios',
            'blogs',
            'videos',
            'services',
            'blogCategories',
            'fields',
            'videoFields'
        ));
    }
}
