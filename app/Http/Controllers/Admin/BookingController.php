<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // ─── List & Filter ──────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'service', 'branch', 'staff'])
            ->orderBy('appointment_at', 'asc');

        // Filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_at', $request->date);
        } else {
            // Default: show today and future
            $query->where('appointment_at', '>=', today());
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        $bookings = $query->paginate(20);
        $branches = Branch::active()->get();
        $staff    = Staff::active()->with('branch')->get();

        // Dashboard counters
        $stats = [
            'pending'   => Booking::pending()->whereDate('appointment_at', '>=', today())->count(),
            'today'     => Booking::today()->count(),
            'completed' => Booking::completed()->whereDate('appointment_at', today())->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'branches', 'staff', 'stats'));
    }

    // ─── Create Manual Booking ───────────────────────────────────────────────

    public function create()
    {
        $branches = Branch::active()->get();
        $services = Service::active()->orderBy('category_type')->get();
        $staff    = Staff::active()->with('branch')->get();

        return view('admin.bookings.create', compact('branches', 'services', 'staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:100',
            'phone'          => 'required|string|max:30',
            'service_id'     => 'required|exists:services,id',
            'branch_id'      => 'required|exists:branches,id',
            'staff_id'       => [
                'nullable',
                Rule::exists('staff', 'id')->where(function ($query) use ($request) {
                    $query->where('branch_id', $request->input('branch_id'));
                }),
            ],
            'appointment_at' => 'required|date',
            'notes'          => 'nullable|string|max:500',
        ]);

        // Find or create customer
        $customer = Customer::findOrCreateByPhone($validated['phone'], $validated['customer_name']);
        $service  = Service::find($validated['service_id']);

        Booking::create([
            'customer_id'      => $customer->id,
            'service_id'       => $validated['service_id'],
            'branch_id'        => $validated['branch_id'],
            'staff_id'         => $validated['staff_id'] ?? null,
            'appointment_at'   => $validated['appointment_at'],
            'duration_minutes' => $service->duration_minutes,
            'notes'            => $validated['notes'] ?? null,
            'status'           => Booking::STATUS_CONFIRMED, // Manual = confirmed immediately
            'source'           => Booking::SOURCE_MANUAL,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم إضافة الحجز بنجاح.');
    }

    // ─── Show Single Booking ─────────────────────────────────────────────────

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'service', 'branch', 'staff']);
        $staff = Staff::active()->forBranch($booking->branch_id)->get();

        return view('admin.bookings.show', compact('booking', 'staff'));
    }

    // ─── Status Changes ──────────────────────────────────────────────────────

    public function confirm(Booking $booking)
    {
        $booking->confirm();
        return back()->with('success', 'تم تأكيد الحجز.');
    }

    public function complete(Booking $booking)
    {
        $booking->complete();
        return back()->with('success', 'تم تسجيل الجلسة كمكتملة.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate(['reason' => 'nullable|string|max:255']);
        $booking->cancel($request->reason ?? '');

        return back()->with('success', 'تم إلغاء الحجز.');
    }

    // ─── Assign Staff (AJAX) ─────────────────────────────────────────────────

    public function assignStaff(Request $request, Booking $booking): JsonResponse
    {
        $request->validate([
            'staff_id' => [
                'required',
                Rule::exists('staff', 'id')->where(function ($query) use ($booking) {
                    $query->where('branch_id', $booking->branch_id);
                }),
            ],
        ]);

        $booking->update([
            'staff_id' => $request->staff_id,
            'status'   => Booking::STATUS_CONFIRMED,
        ]);

        $staffMember = Staff::find($request->staff_id);

        return response()->json([
            'success'    => true,
            'staff_name' => $staffMember->name,
            'message'    => "تم تعيين {$staffMember->name} على الحجز.",
        ]);
    }

    // ─── Customer Lookup (AJAX) ──────────────────────────────────────────────

    public function lookupCustomer(Request $request): JsonResponse
    {
        $request->validate(['phone' => 'required|string']);

        $customer = Customer::where('phone', $request->phone)
            ->withCount('bookings')
            ->first();

        if (!$customer) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found'        => true,
            'name'         => $customer->name,
            'phone'        => $customer->phone,
            'total_visits' => $customer->total_visits,
            'last_visit'   => $customer->last_visit_at?->format('Y-m-d'),
        ]);
    }
}
