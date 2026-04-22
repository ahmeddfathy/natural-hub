<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('branch')->orderBy('branch_id')->orderBy('sort_order');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $staff    = $query->paginate(15);
        $branches = Branch::active()->get();

        $stats = [
            'total'    => Staff::count(),
            'active'   => Staff::where('status', 'active')->count(),
            'on_leave' => Staff::where('status', 'on_leave')->count(),
        ];

        return view('admin.staff.index', compact('staff', 'branches', 'stats'));
    }

    public function create()
    {
        $branches = Branch::active()->get();
        return view('admin.staff.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStaff($request);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('staff', 'public');
        }

        Staff::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'تم إضافة الموظفة بنجاح.');
    }

    public function edit(Staff $staff)
    {
        $branches = Branch::active()->get();
        return view('admin.staff.edit', compact('staff', 'branches'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $this->validateStaff($request);

        if ($request->hasFile('avatar')) {
            if ($staff->avatar) {
                Storage::disk('public')->delete($staff->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('staff', 'public');
        }

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'تم تحديث بيانات الموظفة.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->avatar) {
            Storage::disk('public')->delete($staff->avatar);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'تم حذف الموظفة بنجاح.');
    }

    // ─── Validation ──────────────────────────────────────────────────────────

    private function validateStaff(Request $request): array
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'branch_id'   => 'required|exists:branches,id',
            'specialty'   => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:30',
            'avatar'      => 'nullable|image|max:5120',
            'status'      => 'required|in:active,inactive,on_leave',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        return $validated;
    }
}
