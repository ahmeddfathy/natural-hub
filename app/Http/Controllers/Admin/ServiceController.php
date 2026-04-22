<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(12);

        $stats = [
            'total' => Service::count(),
            'active' => Service::where('is_active', true)->count(),
            'inactive' => Service::where('is_active', false)->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'تم إضافة الخدمة بنجاح.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'تم حذف الخدمة بنجاح.');
    }

    private function validateService(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'image' => 'nullable|image|max:10240',
            'image_alt' => 'nullable|string|max:255',
            'features_text' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0|max:99999',
            'is_active' => 'nullable|boolean',
        ]);

        $features = collect(preg_split('/[\r\n,،]+/u', $validated['features_text'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $validated['features'] = $features ?: null;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        unset($validated['features_text']);

        return $validated;
    }
}
