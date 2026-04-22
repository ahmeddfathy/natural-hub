<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('category');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status == 'published');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $blogs = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.blog.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $isExternal = $request->boolean('is_external');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:blogs,slug',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'is_external' => 'nullable|boolean',
            'external_url' => $isExternal ? 'required|url|max:500' : 'nullable|url|max:500',
            'content' => 'nullable',
            'featured_image' => 'nullable|image|max:10240',
            'temp_featured_image' => 'nullable|string|max:255',
            'featured_image_alt' => 'nullable|string|max:255',
            'gallery_images.*' => 'nullable|image|max:10240',
            'temp_gallery_images' => 'nullable|array',
            'temp_gallery_images.*' => 'nullable|string|max:255',
            'image_captions.*' => 'nullable|string|max:255',
            'image_alts.*' => 'nullable|string|max:255',
            'tags' => 'nullable',
            'blog_highlights' => 'nullable',
            'contact_info' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id,is_active,1',
        ]);

        // تعيين حالة المقال الخارجي
        $validated['is_external'] = $isExternal;
        if (empty($validated['content'])) {
            $validated['content'] = '';
        }

        // إذا لم يتم إدخال slug، يتم توليده من العنوان
        if (empty($validated['slug'])) {
            $baseSlug = $this->generateArabicSlug($validated['title']);
            $slug = $baseSlug;

            $count = 1;
            while (Blog::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        } else {
            // تنظيف الـ slug المدخل يدوياً (يدعم العربي)
            $validated['slug'] = $this->generateArabicSlug($validated['slug']);
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = json_encode(explode(',', $validated['tags']), JSON_UNESCAPED_UNICODE);
        }

        if (!empty($validated['blog_highlights'])) {
            $validated['blog_highlights'] = json_encode(explode(',', $validated['blog_highlights']), JSON_UNESCAPED_UNICODE);
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        } elseif ($request->filled('temp_featured_image')) {
            $validated['featured_image'] = $this->moveTempFile($request, $request->input('temp_featured_image'), 'temp/blogs/featured/', 'blogs');
        }

        $isDraft = $request->boolean('save_as_draft');
        if ($isDraft) {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        } elseif ($request->has('is_published') && $request->is_published) {
            $validated['is_published'] = true;
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['is_published'] = false;
            $validated['published_at'] = $validated['published_at'] ?? null;
        }

        DB::beginTransaction();

        try {
            $blog = Blog::create($validated);

            if ($request->hasFile('gallery_images')) {
                $gallery_images = $request->file('gallery_images');
                $captions = $request->input('image_captions', []);
                $alts = $request->input('image_alts', []);

                foreach ($gallery_images as $index => $image) {
                    $path = $image->store('blogs/gallery', 'public');

                    $blog->images()->create([
                        'image_path' => $path,
                        'alt_text' => $alts[$index] ?? null,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $index,
                        'is_primary' => $index === 0
                    ]);
                }
            }

            if ($request->filled('temp_gallery_images')) {
                $captions = $request->input('image_captions', []);
                $alts = $request->input('image_alts', []);
                $startOrder = $blog->images()->max('sort_order') ?? -1;

                foreach ($request->input('temp_gallery_images', []) as $index => $tempPath) {
                    $path = $this->moveTempFile($request, $tempPath, 'temp/blogs/gallery/', 'blogs/gallery');
                    if (!$path) {
                        continue;
                    }

                    $startOrder++;

                    $blog->images()->create([
                        'image_path' => $path,
                        'alt_text' => $alts[$index] ?? null,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $startOrder,
                        'is_primary' => $startOrder === 0,
                    ]);
                }
            }

            if (!$isExternal) {
                $this->cleanupUnusedQuillImages($validated['content'], $request);
            }

            DB::commit();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog created successfully with ' .
                    ($request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0) .
                    ' gallery images.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to create blog: ' . $e->getMessage());
        }
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $rawTags = $blog->tags;
        if (is_string($rawTags)) {
            $blog->tags = json_decode($rawTags, true) ?: [];
        } elseif (is_array($rawTags)) {
            $blog->tags = $rawTags;
        } else {
            $blog->tags = [];
        }

        $rawHighlights = $blog->blog_highlights;
        if (is_string($rawHighlights)) {
            $blog->blog_highlights = json_decode($rawHighlights, true) ?: [];
        } elseif (is_array($rawHighlights)) {
            $blog->blog_highlights = $rawHighlights;
        } else {
            $blog->blog_highlights = [];
        }

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $isExternal = $request->boolean('is_external');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:blogs,slug,' . $blog->id,
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'is_external' => 'nullable|boolean',
            'external_url' => $isExternal ? 'required|url|max:500' : 'nullable|url|max:500',
            'content' => 'nullable',
            'featured_image' => 'nullable|image|max:10240',
            'temp_featured_image' => 'nullable|string|max:255',
            'featured_image_alt' => 'nullable|string|max:255',
            'gallery_images.*' => 'nullable|image|max:10240',
            'temp_gallery_images' => 'nullable|array',
            'temp_gallery_images.*' => 'nullable|string|max:255',
            'image_captions.*' => 'nullable|string|max:255',
            'image_alts.*' => 'nullable|string|max:255',
            'existing_image_captions.*' => 'nullable|string|max:255',
            'existing_image_alts.*' => 'nullable|string|max:255',
            'existing_image_ids.*' => 'nullable|exists:blog_images,id',
            'images_to_delete.*' => 'nullable|exists:blog_images,id',
            'tags' => 'nullable',
            'blog_highlights' => 'nullable',
            'contact_info' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id,is_active,1',
        ]);

        // تعيين حالة المقال الخارجي
        $validated['is_external'] = $isExternal;
        if (empty($validated['content'])) {
            $validated['content'] = '';
        }

        // التعامل مع الـ slug
        if (isset($validated['slug']) && !empty($validated['slug'])) {
            // إذا تم إدخال slug يدوياً، نستخدمه بعد تنظيفه (يدعم العربي)
            $validated['slug'] = $this->generateArabicSlug($validated['slug']);
        } elseif ($blog->title !== $validated['title']) {
            // إذا تغير العنوان ولم يتم إدخال slug، نولده من العنوان الجديد
            $baseSlug = $this->generateArabicSlug($validated['title']);
            $slug = $baseSlug;

            $count = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        }

        if (isset($validated['tags'])) {
            $tagsArray = is_array($validated['tags'])
                ? $validated['tags']
                : explode(',', $validated['tags']);
            $validated['tags'] = json_encode($tagsArray, JSON_UNESCAPED_UNICODE);
        }

        if (isset($validated['blog_highlights'])) {
            $highlightsArray = is_array($validated['blog_highlights'])
                ? $validated['blog_highlights']
                : explode(',', $validated['blog_highlights']);
            $validated['blog_highlights'] = json_encode($highlightsArray, JSON_UNESCAPED_UNICODE);
        }

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        } elseif ($request->filled('temp_featured_image')) {
            $movedFeaturedImage = $this->moveTempFile($request, $request->input('temp_featured_image'), 'temp/blogs/featured/', 'blogs');
            if ($movedFeaturedImage) {
                if ($blog->featured_image) {
                    Storage::disk('public')->delete($blog->featured_image);
                }
                $validated['featured_image'] = $movedFeaturedImage;
            }
        }

        $isDraft = $request->boolean('save_as_draft');
        if ($isDraft) {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        } else {
            $validated['is_published'] = $request->has('is_published') && $request->is_published;
            if ($validated['is_published']) {
                $validated['published_at'] = $validated['published_at'] ?? now();
            } else {
                $validated['published_at'] = $validated['published_at'] ?? null;
            }
        }

        $wasPublished = $blog->is_published;
        $isNowPublished = $validated['is_published'];
        $becomingPublished = !$wasPublished && $isNowPublished;

        DB::beginTransaction();

        try {
            $blog->update($validated);

            if ($request->has('existing_image_captions') && $request->has('existing_image_ids')) {
                $captions = $request->input('existing_image_captions', []);
                $alts = $request->input('existing_image_alts', []);
                $imageIds = $request->input('existing_image_ids', []);

                foreach ($imageIds as $index => $id) {
                    $updateData = [];
                    if (isset($captions[$index])) {
                        $updateData['caption'] = $captions[$index];
                    }
                    if (isset($alts[$index])) {
                        $updateData['alt_text'] = $alts[$index];
                    }
                    if (!empty($updateData)) {
                        BlogImage::where('id', $id)->update($updateData);
                    }
                }
            }

            if ($request->has('images_to_delete')) {
                foreach ($request->input('images_to_delete') as $imageId) {
                    $image = BlogImage::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('gallery_images')) {
                $gallery_images = $request->file('gallery_images');
                $captions = $request->input('image_captions', []);
                $alts = $request->input('image_alts', []);
                $currentMaxOrder = $blog->images()->max('sort_order') ?? -1;

                foreach ($gallery_images as $index => $image) {
                    $path = $image->store('blogs/gallery', 'public');
                    $currentMaxOrder++;

                    $blog->images()->create([
                        'image_path' => $path,
                        'alt_text' => $alts[$index] ?? null,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $currentMaxOrder,
                        'is_primary' => $blog->images()->count() === 0 && $index === 0
                    ]);
                }
            }

            if ($request->filled('temp_gallery_images')) {
                $captions = $request->input('image_captions', []);
                $alts = $request->input('image_alts', []);
                $currentMaxOrder = $blog->images()->max('sort_order') ?? -1;

                foreach ($request->input('temp_gallery_images', []) as $index => $tempPath) {
                    $path = $this->moveTempFile($request, $tempPath, 'temp/blogs/gallery/', 'blogs/gallery');
                    if (!$path) {
                        continue;
                    }

                    $currentMaxOrder++;

                    $blog->images()->create([
                        'image_path' => $path,
                        'alt_text' => $alts[$index] ?? null,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $currentMaxOrder,
                        'is_primary' => $blog->images()->count() === 0 && $index === 0,
                    ]);
                }
            }

            if (!$isExternal) {
                $this->cleanupUnusedQuillImages($validated['content'], $request);
            }

            DB::commit();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to update blog: ' . $e->getMessage());
        }
    }

    public function destroy(Blog $blog)
    {
        DB::beginTransaction();

        try {
            $blogTitle = $blog->title;

            foreach ($blog->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $contentImages = Storage::disk('public')->files('blogs/content');
            foreach ($contentImages as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            $blog->delete();

            DB::commit();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog and all associated images deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete blog: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to delete blog. Please try again. If the problem persists, contact support.');
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            // CKEditor 5 SimpleUploadAdapter يرسل الملف في الحقل "upload"
            // نحافظ على توافق سابق مع "image" إذا استُخدم قبل التغيير.
            $file = $request->file('upload') ?? $request->file('image');

            // تحقق من وجود أي من الحقلين
            if (!$file) {
                return response()->json(['error' => 'No image file was uploaded.'], 400);
            }

            // تحقق من نوع الصورة والحجم لأي من الحقلين المتاحين
            $request->validate([
                'upload' => 'required_without:image|image|max:10240',
                'image' => 'required_without:upload|image|max:10240',
            ]);

            $path = $file->store('blogs/content', 'public');

            if (!$path) {
                return response()->json(['error' => 'Failed to store the image.'], 500);
            }

            $tempImages = $request->session()->get('temp_quill_images', []);
            $tempImages[] = $path;
            $request->session()->put('temp_quill_images', $tempImages);

            return response()->json([
                'url' => asset('storage/' . $path),
            ]);
        } catch (\Exception $e) {
            Log::error('Blog image upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload image. Please try again.'], 500);
        }
    }

    public function uploadTempMedia(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:10240',
            'type' => 'required|in:featured,gallery',
        ]);

        $directory = $validated['type'] === 'featured'
            ? 'temp/blogs/featured'
            : 'temp/blogs/gallery';

        $sessionKey = $validated['type'] === 'featured'
            ? 'temp_blog_featured_images'
            : 'temp_blog_gallery_images';

        $path = $request->file('image')->store($directory, 'public');
        $this->rememberTempPath($request, $sessionKey, $path);

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    public function removeTempMedia(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $path = $validated['path'];
        if (!Str::startsWith($path, 'temp/blogs/')) {
            return response()->json(['success' => false], 422);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $this->forgetTempPath($request, 'temp_blog_featured_images', $path);
        $this->forgetTempPath($request, 'temp_blog_gallery_images', $path);

        return response()->json(['success' => true]);
    }

    private function cleanupUnusedQuillImages($content, Request $request)
    {
        $tempImages = $request->session()->get('temp_quill_images', []);

        if (empty($tempImages)) {
            try {
                $contentImages = Storage::disk('public')->files('blogs/content');
                if (empty($contentImages)) {
                    return;
                }

                foreach ($contentImages as $imagePath) {
                    $filename = basename($imagePath);
                    if (strpos($content, $filename) === false) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
                return;
            } catch (\Exception $e) {
                Log::error('Error cleaning content images: ' . $e->getMessage());
                return;
            }
        }

        $usedImages = [];
        foreach ($tempImages as $imagePath) {
            $filename = basename($imagePath);

            if (strpos($content, $filename) !== false) {
                $usedImages[] = $imagePath;
            } else {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $request->session()->forget('temp_quill_images');
    }

    public function clearTempImages(Request $request)
    {
        $this->clearSessionTempPaths($request, 'temp_quill_images');
        $this->clearSessionTempPaths($request, 'temp_blog_featured_images');
        $this->clearSessionTempPaths($request, 'temp_blog_gallery_images');

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->is_published = !$blog->is_published;

        if ($blog->is_published && !$blog->published_at) {
            $blog->published_at = now();
        } elseif (!$blog->is_published) {
            $blog->published_at = null;
        }

        $blog->save();

        $message = $blog->is_published
            ? 'Blog published successfully.'
            : 'Blog moved to draft successfully.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Generate slug that supports Arabic characters
     */
    private function generateArabicSlug($text)
    {
        // تنظيف النص: إزالة المسافات الزائدة واستبدال المسافات بشرطات
        $slug = trim($text);
        $slug = preg_replace('/\s+/', '-', $slug);
        // إزالة أي حروف غير مرغوبة (نبقي على العربي والإنجليزي والأرقام والشرطات)
        $slug = preg_replace('/[^\x{0600}-\x{06FF}a-zA-Z0-9\-_]/u', '', $slug);
        // إزالة الشرطات المتكررة
        $slug = preg_replace('/-+/', '-', $slug);
        // إزالة الشرطات من البداية والنهاية
        $slug = trim($slug, '-');
        
        return $slug;
    }

    private function rememberTempPath(Request $request, string $key, string $path): void
    {
        $paths = $request->session()->get($key, []);

        if (!in_array($path, $paths, true)) {
            $paths[] = $path;
            $request->session()->put($key, $paths);
        }
    }

    private function forgetTempPath(Request $request, string $key, string $path): void
    {
        $paths = array_values(array_filter(
            $request->session()->get($key, []),
            fn ($storedPath) => $storedPath !== $path
        ));

        $request->session()->put($key, $paths);
    }

    private function clearSessionTempPaths(Request $request, string $key): void
    {
        foreach ($request->session()->get($key, []) as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $request->session()->forget($key);
    }

    private function moveTempFile(Request $request, string $tempPath, string $expectedPrefix, string $targetDirectory): ?string
    {
        if (!Str::startsWith($tempPath, $expectedPrefix) || !Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $newPath = trim($targetDirectory, '/') . '/' . Str::uuid() . ($extension ? '.' . $extension : '');

        Storage::disk('public')->move($tempPath, $newPath);

        $this->forgetTempPath($request, 'temp_blog_featured_images', $tempPath);
        $this->forgetTempPath($request, 'temp_blog_gallery_images', $tempPath);

        return $newPath;
    }
}
