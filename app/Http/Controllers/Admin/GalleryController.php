<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryImage::orderBy('sort_order')->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $images     = $query->paginate(20);
        $categories = GalleryImage::categories();

        $stats = [
            'total'         => GalleryImage::count(),
            'active'        => GalleryImage::where('is_active', true)->count(),
            'before_after'  => GalleryImage::where('is_before_after', true)->count(),
        ];

        return view('admin.gallery.index', compact('images', 'categories', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'              => 'required|array|min:1',
            'images.*'            => 'required|image|max:10240',
            'category'            => 'required|in:Hair,Skin,Lashes,General',
            'caption'             => 'nullable|string|max:255',
            'is_before_after'     => 'nullable|boolean',
        ]);

        $uploaded = 0;
        $sort = GalleryImage::max('sort_order') + 1;

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery', 'public');

            GalleryImage::create([
                'url'             => $path,
                'alt'             => $request->category . ' — Natural Hub',
                'caption'         => $request->caption,
                'category'        => $request->category,
                'is_before_after' => $request->boolean('is_before_after'),
                'is_active'       => true,
                'sort_order'      => $sort++,
            ]);
            $uploaded++;
        }

        return back()->with('success', "تم رفع {$uploaded} صورة بنجاح.");
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $request->validate([
            'category'        => 'required|in:Hair,Skin,Lashes,General',
            'caption'         => 'nullable|string|max:255',
            'alt'             => 'nullable|string|max:255',
            'is_before_after' => 'nullable|boolean',
            'is_active'       => 'nullable|boolean',
            'sort_order'      => 'nullable|integer|min:0',
        ]);

        $galleryImage->update([
            'category'        => $request->category,
            'caption'         => $request->caption,
            'alt'             => $request->alt,
            'is_before_after' => $request->boolean('is_before_after'),
            'is_active'       => $request->boolean('is_active'),
            'sort_order'      => $request->input('sort_order', $galleryImage->sort_order),
        ]);

        return back()->with('success', 'تم تحديث الصورة.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        Storage::disk('public')->delete($galleryImage->url);
        $galleryImage->delete();

        return back()->with('success', 'تم حذف الصورة.');
    }

    public function toggleStatus(GalleryImage $galleryImage)
    {
        $galleryImage->update(['is_active' => !$galleryImage->is_active]);
        return back()->with('success', 'تم تغيير حالة الصورة.');
    }

    /** AJAX — update sort order via drag & drop */
    public function updateSortOrder(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $item) {
            GalleryImage::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
