<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('sort_order')->get();

        $stats = [
            'total'    => $branches->count(),
            'active'   => $branches->where('is_active', true)->count(),
            'inactive' => $branches->where('is_active', false)->count(),
        ];

        return view('admin.branches.index', compact('branches', 'stats'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBranch($request);
        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم إضافة الفرع بنجاح.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $branch->update($this->validateBranch($request));

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم تحديث بيانات الفرع.');
    }

    public function destroy(Branch $branch)
    {
        // Prevent deletion if branch has bookings
        if ($branch->bookings()->exists()) {
            return redirect()->route('admin.branches.index')
                ->with('error', 'لا يمكن حذف الفرع لأن لديه حجوزات مسجلة.');
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم حذف الفرع بنجاح.');
    }

    public function toggleStatus(Branch $branch)
    {
        $branch->update(['is_active' => !$branch->is_active]);

        $msg = $branch->is_active ? 'تم تفعيل الفرع.' : 'تم إيقاف الفرع.';
        return back()->with('success', $msg);
    }

    // ─── Validation ──────────────────────────────────────────────────────────

    private function validateBranch(Request $request): array
    {
        return $request->validate([
            'name'            => 'required|string|max:255',
            'address'         => 'required|string|max:500',
            'city'            => 'nullable|string|max:100',
            'phone'           => 'nullable|string|max:30',
            'whatsapp'        => 'nullable|string|max:30',
            'google_maps_url' => 'nullable|url|max:500',
            'iframe_url'      => 'nullable|string|max:1000',
            'opens_at'        => 'nullable|date_format:H:i',
            'closes_at'       => 'nullable|date_format:H:i',
            'is_active'       => 'nullable|boolean',
            'sort_order'      => 'nullable|integer|min:0',
        ]) + ['is_active' => $request->boolean('is_active'), 'sort_order' => $request->input('sort_order', 0)];
    }
}
