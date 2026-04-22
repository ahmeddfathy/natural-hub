<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::with(['category.parent', 'field']);

        if ($request->filled('field_id')) {
            $query->where('field_id', $request->field_id);
        }

        $portfolios = $query
            ->orderBy('field_id')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $fields = Field::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'featured' => Portfolio::where('is_featured', true)->count(),
            'this_month' => Portfolio::whereMonth('created_at', now()->month)->count(),
            'types' => Portfolio::whereNotNull('portfolio_category_id')
                ->distinct('portfolio_category_id')
                ->count('portfolio_category_id'),
        ];

        return view('admin.portfolio.index', compact('portfolios', 'fields', 'stats'));
    }

    public function create()
    {
        $fields = Field::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = PortfolioCategory::where('is_active', true)
            ->with(['parent', 'fields'])
            ->orderBy('name')
            ->get();

        return view('admin.portfolio.create', compact('fields', 'categories'));
    }

    public function store(Request $request)
    {
        $isExternal = $request->boolean('is_external');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:portfolios,slug',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'is_external' => 'nullable|boolean',
            'external_url' => $isExternal ? 'required|url|max:500' : 'nullable|url|max:500',
            'description' => 'nullable',
            'short_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:10240',
            'temp_image' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'client_name' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'project_type' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'field_id' => 'required|exists:fields,id,is_active,1',
            'portfolio_category_id' => 'required|exists:portfolio_categories,id,is_active,1',
        ]);

        $validated['is_external'] = $isExternal;
        if (empty($validated['description'])) {
            $validated['description'] = '';
        }

        // إذا لم يتم إدخال slug، يتم توليده من العنوان
        if (empty($validated['slug'])) {
            $baseSlug = $this->generateArabicSlug($validated['title']);
            $slug = $baseSlug;

            $count = 1;
            while (Portfolio::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        } else {
            // تنظيف الـ slug المدخل يدوياً (يدعم العربي)
            $validated['slug'] = $this->generateArabicSlug($validated['slug']);
        }

        if (!empty($validated['technologies'])) {
            $validated['technologies'] = json_encode($validated['technologies']);
        }

        $this->ensureCategoryBelongsToField((int) $validated['field_id'], (int) $validated['portfolio_category_id']);
        $validated['project_type'] = $this->resolveProjectType((int) $validated['portfolio_category_id']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('portfolio', 'public');
        } elseif ($request->filled('temp_image')) {
            $validated['image'] = $this->moveTempImage($request, $request->input('temp_image'));
        }

        Portfolio::create($validated);

        // Save videos
        $this->syncVideos($request, Portfolio::latest()->first());

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->technologies) {
            $portfolio->technologies = json_decode($portfolio->technologies);
        }

        $fields = Field::where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = PortfolioCategory::where('is_active', true)
            ->with(['parent', 'fields'])
            ->orderBy('name')
            ->get();

        $portfolio->load('videos');

        return view('admin.portfolio.edit', compact('portfolio', 'fields', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $isExternal = $request->boolean('is_external');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:portfolios,slug,' . $portfolio->id,
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'is_external' => 'nullable|boolean',
            'external_url' => $isExternal ? 'required|url|max:500' : 'nullable|url|max:500',
            'description' => 'nullable',
            'short_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:10240',
            'temp_image' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'client_name' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'project_type' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'field_id' => 'required|exists:fields,id,is_active,1',
            'portfolio_category_id' => 'required|exists:portfolio_categories,id,is_active,1',
        ]);

        $validated['is_external'] = $isExternal;
        if (empty($validated['description'])) {
            $validated['description'] = '';
        }

        // التعامل مع الـ slug
        if (isset($validated['slug']) && !empty($validated['slug'])) {
            // إذا تم إدخال slug يدوياً، نستخدمه بعد تنظيفه (يدعم العربي)
            $validated['slug'] = $this->generateArabicSlug($validated['slug']);
        } elseif ($portfolio->title !== $validated['title']) {
            // إذا تغير العنوان ولم يتم إدخال slug، نولده من العنوان الجديد
            $baseSlug = $this->generateArabicSlug($validated['title']);
            $slug = $baseSlug;

            $count = 1;
            while (Portfolio::where('slug', $slug)->where('id', '!=', $portfolio->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
        }

        if (!empty($validated['technologies'])) {
            $validated['technologies'] = json_encode($validated['technologies']);
        }

        $this->ensureCategoryBelongsToField((int) $validated['field_id'], (int) $validated['portfolio_category_id']);
        $validated['project_type'] = $this->resolveProjectType((int) $validated['portfolio_category_id']);

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $validated['image'] = $request->file('image')->store('portfolio', 'public');
        } elseif ($request->filled('temp_image')) {
            $movedImage = $this->moveTempImage($request, $request->input('temp_image'));
            if ($movedImage) {
                if ($portfolio->image) {
                    Storage::disk('public')->delete($portfolio->image);
                }
                $validated['image'] = $movedImage;
            }
        }

        $portfolio->update($validated);

        // Sync videos
        $this->syncVideos($request, $portfolio);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }

    public function uploadTempImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $path = $request->file('image')->store('temp/portfolio', 'public');
        $this->rememberTempImage($request, $path);

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    public function removeTempImage(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $path = $validated['path'];
        if (!Str::startsWith($path, 'temp/portfolio/')) {
            return response()->json(['success' => false], 422);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $this->forgetTempImage($request, $path);

        return response()->json(['success' => true]);
    }

    public function clearTempImages(Request $request)
    {
        foreach ($request->session()->get('temp_portfolio_images', []) as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $request->session()->forget('temp_portfolio_images');

        return response()->json(['success' => true]);
    }

    /**
     * Sync portfolio videos from request
     */
    private function syncVideos(Request $request, Portfolio $portfolio): void
    {
        $portfolio->videos()->delete();

        $titles    = $request->input('video_titles', []);
        $urls      = $request->input('video_urls', []);
        $providers = $request->input('video_providers', []);

        foreach ($urls as $i => $url) {
            $url = trim($url);
            if (!$url) continue;

            $provider = $providers[$i] ?? 'youtube';
            $youtubeId = null;
            $driveId   = null;

            if ($provider === 'drive') {
                $driveId = \App\Models\Video::extractGoogleDriveFileId($url);
            } else {
                $youtubeId = \App\Models\Video::extractYoutubeVideoId($url);
                $provider  = 'youtube';
            }

            $portfolio->videos()->create([
                'title'            => $titles[$i] ?? 'Video ' . ($i + 1),
                'url'              => $url,
                'video_provider'   => $provider,
                'youtube_video_id' => $youtubeId,
                'drive_file_id'    => $driveId,
                'sort_order'       => $i,
            ]);
        }
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

    private function rememberTempImage(Request $request, string $path): void
    {
        $paths = $request->session()->get('temp_portfolio_images', []);

        if (!in_array($path, $paths, true)) {
            $paths[] = $path;
            $request->session()->put('temp_portfolio_images', $paths);
        }
    }

    private function forgetTempImage(Request $request, string $path): void
    {
        $paths = array_values(array_filter(
            $request->session()->get('temp_portfolio_images', []),
            fn ($storedPath) => $storedPath !== $path
        ));

        $request->session()->put('temp_portfolio_images', $paths);
    }

    private function moveTempImage(Request $request, string $tempPath): ?string
    {
        if (!Str::startsWith($tempPath, 'temp/portfolio/') || !Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $newPath = 'portfolio/' . Str::uuid() . ($extension ? '.' . $extension : '');

        Storage::disk('public')->move($tempPath, $newPath);
        $this->forgetTempImage($request, $tempPath);

        return $newPath;
    }

    private function ensureCategoryBelongsToField(int $fieldId, int $categoryId): void
    {
        $matchesField = PortfolioCategory::whereKey($categoryId)
            ->whereHas('fields', function ($query) use ($fieldId) {
                $query->whereKey($fieldId);
            })
            ->exists();

        if (!$matchesField) {
            throw ValidationException::withMessages([
                'portfolio_category_id' => 'التصنيف المختار غير مرتبط بالمجال المحدد.',
            ]);
        }
    }

    private function resolveProjectType(int $categoryId): string
    {
        $category = PortfolioCategory::with('parent')->findOrFail($categoryId);

        return $category->project_type_label;
    }
}
