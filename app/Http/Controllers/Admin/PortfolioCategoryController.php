<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioCategoryController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::with('parent')
            ->withCount(['portfolios', 'children'])
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.portfolio-categories.index', compact('categories'));
    }

    public function create()
    {
        $fields = Field::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.portfolio-categories.create', compact('fields'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:portfolio_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'field_ids' => 'nullable|array',
            'field_ids.*' => 'integer|exists:fields,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('portfolio-categories', 'public');
        }

        $portfolioCategory = PortfolioCategory::create($validated);
        $portfolioCategory?->fields()->sync($validated['field_ids'] ?? []);

        return redirect()->route('admin.portfolio-categories.index')
            ->with('success', 'تم إنشاء التصنيف بنجاح');
    }

    public function edit(PortfolioCategory $portfolioCategory)
    {
        $fields = Field::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.portfolio-categories.edit', compact('portfolioCategory', 'fields'));
    }

    public function update(Request $request, PortfolioCategory $portfolioCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:portfolio_categories,slug,' . $portfolioCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'field_ids' => 'nullable|array',
            'field_ids.*' => 'integer|exists:fields,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($portfolioCategory->image && Storage::disk('public')->exists($portfolioCategory->image)) {
                Storage::disk('public')->delete($portfolioCategory->image);
            }

            $validated['image'] = $request->file('image')->store('portfolio-categories', 'public');
        }

        $portfolioCategory->update($validated);
        $portfolioCategory->fields()->sync($validated['field_ids'] ?? []);

        return redirect()->route('admin.portfolio-categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(PortfolioCategory $portfolioCategory)
    {
        if ($portfolioCategory->children()->exists()) {
            return redirect()->route('admin.portfolio-categories.index')
                ->with('error', 'لا يمكن حذف هذا التصنيف لأنه يحتوي على تصنيفات فرعية.');
        }

        if ($portfolioCategory->portfolios()->exists()) {
            return redirect()->route('admin.portfolio-categories.index')
                ->with('error', 'لا يمكن حذف هذا التصنيف لأنه مرتبط بأعمال موجودة.');
        }

        if ($portfolioCategory->image && Storage::disk('public')->exists($portfolioCategory->image)) {
            Storage::disk('public')->delete($portfolioCategory->image);
        }

        $portfolioCategory->delete();

        return redirect()->route('admin.portfolio-categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح');
    }
}
