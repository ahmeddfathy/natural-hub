<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::where('is_published', true)
            ->with(['category', 'service'])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        $selectedCategory = null;

        if ($request->filled('category')) {
            $selectedCategory = VideoCategory::where('slug', $request->category)
                ->where('is_active', true)
                ->first();

            if ($selectedCategory) {
                $query->where('video_category_id', $selectedCategory->id);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $videos = $query->paginate(9)->withQueryString();

        $categories = VideoCategory::where('is_active', true)
            ->withCount([
                'videos as published_videos_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->orderBy('name')
            ->get();

        $featuredVideos = Video::where('is_published', true)
            ->with(['category', 'service'])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('videos.index', compact('videos', 'categories', 'selectedCategory', 'featuredVideos'));
    }

    public function show(Video $video)
    {
        if (!$video->is_published) {
            abort(404);
        }

        $relatedVideos = Video::where('is_published', true)
            ->where('id', '!=', $video->id)
            ->when($video->video_category_id, function ($query) use ($video) {
                $query->where('video_category_id', $video->video_category_id);
            }, function ($query) use ($video) {
                if ($video->service_id) {
                    $query->where('service_id', $video->service_id);
                } else {
                    $query->where('category_type', $video->category_type);
                }
            })
            ->with(['category', 'service'])
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $recentVideos = Video::where('is_published', true)
            ->where('id', '!=', $video->id)
            ->with(['category', 'service'])
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $categories = VideoCategory::where('is_active', true)
            ->withCount([
                'videos as published_videos_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->orderBy('name')
            ->get();

        return view('videos.show', compact('video', 'relatedVideos', 'recentVideos', 'categories'));
    }
}
