<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('bookings')
            ->orderByDesc('last_visit_at');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        $customers = $query->paginate(20);

        $stats = [
            'total'   => Customer::count(),
            'new'     => Customer::whereDate('created_at', today())->count(),
            'regular' => Customer::where('total_visits', '>=', 3)->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['bookings.service', 'bookings.branch', 'bookings.staff']);

        $bookings = $customer->bookings()
            ->with(['service', 'branch', 'staff'])
            ->orderByDesc('appointment_at')
            ->get();

        return view('admin.customers.show', compact('customer', 'bookings'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $customer->update($request->only('name', 'notes'));

        return back()->with('success', 'تم تحديث بيانات العميلة.');
    }
}
