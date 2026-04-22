<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;

class LibraryController extends Controller
{
    public function index()
    {
        // Featured hero video
        $featuredVideo = Video::where('is_published', true)
            ->where('is_featured', true)
            ->with(['category', 'field'])
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->first();

        // One row per VideoCategory, featured videos first inside each row
        $videoCategories = VideoCategory::where('is_active', true)
            ->with(['videos' => function ($query) {
                $query->where('is_published', true)
                    ->with(['category', 'field'])
                    ->orderBy('sort_order')
                    ->orderByDesc('is_featured')
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
            }])
            ->withCount([
                'videos as published_videos_count' => function ($q) {
                    $q->where('is_published', true);
                },
                'videos as featured_videos_count' => function ($q) {
                    $q->where('is_published', true)->where('is_featured', true);
                },
            ])
            ->having('published_videos_count', '>', 0)
            ->orderByDesc('featured_videos_count')
            ->orderByDesc('published_videos_count')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->filter(fn($c) => $c->videos->isNotEmpty())
            ->values();

        return view('library', compact('featuredVideo', 'videoCategories'));
    }
}
