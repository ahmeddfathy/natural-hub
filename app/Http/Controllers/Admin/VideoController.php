<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{
    // الأقسام المتاحة — نفس نظام الخدمات والمعرض
    private const CATEGORIES = [
        'Hair'    => 'شعر',
        'Skin'    => 'بشرة',
        'Lashes'  => 'رموش',
        'General' => 'عام',
    ];

    public function index(Request $request)
    {
        $query = Video::query();

        if ($request->filled('category')) {
            $query->where('category_type', $request->category);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('excerpt', 'like', "%{$term}%");
            });
        }

        $videos = $query->orderBy('category_type')->orderBy('sort_order')->orderByDesc('created_at')
            ->paginate(20)->withQueryString();

        $services   = Service::active()->orderBy('category_type')->orderBy('title')->get();
        $categories = self::CATEGORIES;

        $stats = [
            'total'     => Video::count(),
            'published' => Video::where('is_published', true)->count(),
            'drafts'    => Video::where('is_published', false)->count(),
            'featured'  => Video::where('is_featured', true)->count(),
        ];

        return view('admin.videos.index', compact('videos', 'categories', 'services', 'stats'));
    }

    public function create()
    {
        $services   = Service::active()->orderBy('category_type')->orderBy('title')->get();
        $categories = self::CATEGORIES;

        return view('admin.videos.create', compact('services', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateVideo($request);
        $validated['youtube_video_id'] = $this->extractYoutubeId($validated['youtube_url']);
        $validated['video_provider']   = 'youtube';
        $validated['slug']             = $this->prepareSlug($validated['slug'] ?? null, $validated['title']);
        $validated['is_featured']      = $request->boolean('is_featured');
        $validated['is_portrait']      = $request->boolean('is_portrait');
        $this->applyPublishingState($validated, $request);

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'تم إضافة الفيديو بنجاح.');
    }

    public function edit(Video $video)
    {
        $services   = Service::active()->orderBy('category_type')->orderBy('title')->get();
        $categories = self::CATEGORIES;

        return view('admin.videos.edit', compact('video', 'services', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $this->validateVideo($request, $video);
        $validated['youtube_video_id'] = $this->extractYoutubeId($validated['youtube_url']);
        $validated['video_provider']   = 'youtube';
        $validated['slug']             = $this->prepareSlug($validated['slug'] ?? null, $validated['title'], $video->id);
        $validated['is_featured']      = $request->boolean('is_featured');
        $validated['is_portrait']      = $request->boolean('is_portrait');
        $this->applyPublishingState($validated, $request);

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'تم تحديث الفيديو بنجاح.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'تم حذف الفيديو.');
    }

    public function toggleStatus(Video $video)
    {
        $video->is_published = !$video->is_published;
        $video->published_at = $video->is_published ? ($video->published_at ?? now()) : null;
        $video->save();

        return back()->with('success', $video->is_published ? 'تم نشر الفيديو.' : 'تم تحويله لمسودة.');
    }

    // ─── Private ──────────────────────────────────────────────────────────

    private function validateVideo(Request $request, ?Video $video = null): array
    {
        return $request->validate([
            'title'         => 'required|max:255',
            'slug'          => 'nullable|max:255|unique:videos,slug,' . ($video?->id ?? 'NULL'),
            'youtube_url'   => 'required|string|max:500',
            'category_type' => 'required|in:' . implode(',', array_keys(self::CATEGORIES)),
            'service_id'    => 'nullable|exists:services,id',
            'excerpt'       => 'nullable|string|max:500',
            'description'   => 'nullable|string',
            'is_featured'   => 'nullable|boolean',
            'is_published'  => 'nullable|boolean',
            'is_portrait'   => 'nullable|boolean',
            'published_at'  => 'nullable|date',
            'sort_order'    => 'nullable|integer|min:0',
        ]);
    }

    private function extractYoutubeId(string $url): string
    {
        // Supports: watch?v=, youtu.be/, embed/, shorts/
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        if (empty($matches[1])) {
            throw ValidationException::withMessages([
                'youtube_url' => 'رابط YouTube غير صحيح. مثال: https://www.youtube.com/watch?v=XXXXXXXXXXX',
            ]);
        }

        return $matches[1];
    }

    private function prepareSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ?: $title;
        $base = trim(preg_replace('/[^\x{0600}-\x{06FF}a-zA-Z0-9]+/u', '-', $base), '-');

        $candidate = $base;
        $i = 1;
        while (Video::where('slug', $candidate)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base . '-' . $i++;
        }

        return $candidate;
    }

    private function applyPublishingState(array &$validated, Request $request): void
    {
        if ($request->boolean('save_as_draft')) {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
            return;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published']
            ? ($validated['published_at'] ?? now())
            : null;
    }
}
