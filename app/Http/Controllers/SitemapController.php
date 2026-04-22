<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Video;

class SitemapController extends Controller
{
    public function index()
    {
        // ── Static pages ────────────────────────────────────────────────────
        $urls = collect([
            [
                'url'        => route('home'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '1.0',
            ],
            [
                'url'        => route('about'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('services'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.9',
            ],
            [
                'url'        => route('gallery'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('shop'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('blog.index'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('library'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'weekly',
                'priority'   => '0.7',
            ],
            [
                'url'        => route('contact'),
                'lastmod'    => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.7',
            ],
        ]);

        // ── Dynamic blog posts ───────────────────────────────────────────────
        $blogs = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get(['id', 'slug', 'title', 'cover_image', 'updated_at']);

        foreach ($blogs as $blog) {
            $urls->push([
                'url'         => route('blog.show', $blog->slug),
                'lastmod'     => $blog->updated_at->toDateString(),
                'changefreq'  => 'monthly',
                'priority'    => '0.7',
                'image'       => $blog->cover_image ? asset('storage/' . $blog->cover_image) : null,
                'image_title' => $blog->title,
            ]);
        }

        // ── Published videos (YouTube only) ────────────────────────────────
        $videos = Video::where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->get(['id', 'title', 'slug', 'youtube_video_id', 'excerpt', 'published_at', 'updated_at']);

        $content = view('sitemap.index', compact('urls', 'videos'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
