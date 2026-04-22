<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    /**
     * POST /api/book
     * Receives a booking from the website frontend.
     * Creates customer (or finds existing one), then creates the booking.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone'         => ['required', 'string', 'max:30', 'regex:/^[\d\s\+\-\(\)]+$/'],
            'service_id'    => 'required|exists:services,id',
            'branch_id'     => 'required|exists:branches,id',
            'appointment_at'=> 'required|date|after:now',
            'notes'         => 'nullable|string|max:500',
        ]);

        // Find or create customer by phone (zero-friction: no account needed)
        $customer = Customer::findOrCreateByPhone(
            $validated['phone'],
            $validated['customer_name']
        );

        // Fetch service to inherit duration
        $service = Service::findOrFail($validated['service_id']);

        // Create the booking (website bookings start as "pending")
        $booking = Booking::create([
            'customer_id'      => $customer->id,
            'service_id'       => $service->id,
            'branch_id'        => $validated['branch_id'],
            'staff_id'         => null, // assigned later from admin
            'appointment_at'   => $validated['appointment_at'],
            'duration_minutes' => $service->duration_minutes,
            'notes'            => $validated['notes'] ?? null,
            'status'           => Booking::STATUS_PENDING,
            'source'           => Booking::SOURCE_WEBSITE,
        ]);

        // TODO Phase 3: Fire WhatsApp confirmation notification here
        // event(new BookingCreated($booking));

        return response()->json([
            'success' => true,
            'message' => 'تم استلام طلب حجزك! سيتم تأكيده من فريقنا قريباً.',
            'booking_id' => $booking->id,
        ], 201);
    }

    /**
     * GET /api/booking/{id}/status
     * Allow customer to check their booking status by booking ID.
     */
    public function status(int $id): JsonResponse
    {
        $booking = Booking::with(['service', 'branch', 'staff'])
            ->findOrFail($id);

        return response()->json([
            'status'       => $booking->status,
            'status_label' => $booking->status_label,
            'service'      => $booking->service->title,
            'branch'       => $booking->branch->name,
            'appointment'  => $booking->appointment_at->format('Y-m-d H:i'),
            'staff'        => $booking->staff?->name,
        ]);
    }

    /**
     * GET /api/branches
     * Active branches list for the booking form dropdown.
     */
    public function branches(): JsonResponse
    {
        $branches = Branch::active()
            ->select('id', 'name', 'address', 'phone', 'whatsapp')
            ->get();

        return response()->json($branches);
    }

    /**
     * GET /api/services
     * Active services list (optionally filtered by branch) for the booking form.
     */
    public function services(Request $request): JsonResponse
    {
        $query = Service::active()
            ->select('id', 'title', 'category_type', 'price_min', 'price_max', 'price_label', 'duration_minutes')
            ->orderBy('category_type')
            ->orderBy('sort_order');

        if ($request->filled('branch_id')) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('branch_id')
                  ->orWhere('branch_id', $request->branch_id);
            });
        }

        return response()->json($query->get()->groupBy('category_type'));
    }
}
