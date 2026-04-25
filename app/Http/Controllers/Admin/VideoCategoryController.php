<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoCategoryController extends Controller
{
    public function index()
    {
        $categories = VideoCategory::withCount('videos')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.video-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.video-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:video_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = $this->prepareSlug($validated['slug'] ?? null, $validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('video-categories', 'public');
        }

        VideoCategory::create($validated);

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'تم إنشاء تصنيف الفيديو بنجاح');
    }

    public function edit(VideoCategory $videoCategory)
    {
        return view('admin.video-categories.edit', compact('videoCategory'));
    }

    public function update(Request $request, VideoCategory $videoCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:video_categories,slug,' . $videoCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = $this->prepareSlug($validated['slug'] ?? null, $validated['name'], $videoCategory->id);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($videoCategory->image && Storage::disk('public')->exists($videoCategory->image)) {
                Storage::disk('public')->delete($videoCategory->image);
            }

            $validated['image'] = $request->file('image')->store('video-categories', 'public');
        }

        $videoCategory->update($validated);

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'تم تحديث تصنيف الفيديو بنجاح');
    }

    public function destroy(VideoCategory $videoCategory)
    {
        if ($videoCategory->videos()->exists()) {
            return redirect()->route('admin.video-categories.index')
                ->with('error', 'لا يمكن حذف هذا التصنيف لأنه يحتوي على فيديوهات.');
        }

        if ($videoCategory->image && Storage::disk('public')->exists($videoCategory->image)) {
            Storage::disk('public')->delete($videoCategory->image);
        }

        $videoCategory->delete();

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'تم حذف تصنيف الفيديو بنجاح');
    }

    private function prepareSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $baseSlug = $this->generateArabicSlug($slug ?: $name);
        $generatedSlug = $baseSlug;
        $count = 1;

        while (
            VideoCategory::where('slug', $generatedSlug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $generatedSlug = $baseSlug . '-' . $count++;
        }

        return $generatedSlug;
    }

    private function generateArabicSlug(string $text): string
    {
        $slug = trim($text);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^\x{0600}-\x{06FF}a-zA-Z0-9\-_]/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }
}
