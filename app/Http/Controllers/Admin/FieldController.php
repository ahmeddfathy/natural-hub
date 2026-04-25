<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::withCount(['categories'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        return view('admin.fields.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:fields,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = $this->prepareSlug($validated['slug'] ?? null, $validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fields', 'public');
        }

        Field::create($validated);

        return redirect()->route('admin.fields.index')
            ->with('success', 'تم إنشاء المجال بنجاح');
    }

    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:fields,slug,' . $field->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = $this->prepareSlug($validated['slug'] ?? null, $validated['name'], $field->id);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($field->image && Storage::disk('public')->exists($field->image)) {
                Storage::disk('public')->delete($field->image);
            }

            $validated['image'] = $request->file('image')->store('fields', 'public');
        }

        $field->update($validated);

        return redirect()->route('admin.fields.index')
            ->with('success', 'تم تحديث المجال بنجاح');
    }

    public function destroy(Field $field)
    {
        if ($field->categories()->exists()) {
            return redirect()->route('admin.fields.index')
                ->with('error', 'لا يمكن حذف هذا المجال لأنه مرتبط بتصنيفات موجودة.');
        }

        if ($field->image && Storage::disk('public')->exists($field->image)) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'تم حذف المجال بنجاح');
    }

    private function prepareSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $baseSlug = $this->generateArabicSlug($slug ?: $name);
        $generatedSlug = $baseSlug;
        $count = 1;

        while (
            Field::where('slug', $generatedSlug)
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
