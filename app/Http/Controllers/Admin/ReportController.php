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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    // ─── Main Reports Page ──────────────────────────────────────────────────

    public function index(Request $request)
    {
        $period    = $request->input('period', 'month'); // today | week | month | year | custom
        [$from, $to] = $this->resolvePeriod($period, $request);

        $branches = Branch::active()->get();

        // ── Revenue by Branch ──────────────────────────────────────────────
        $revenueByBranch = $this->revenueByBranch($from, $to);

        // ── Bookings Summary ───────────────────────────────────────────────
        $bookingSummary = $this->bookingSummary($from, $to, $request->branch_id);

        // ── Top Services ───────────────────────────────────────────────────
        $topServices = $this->topServices($from, $to, $request->branch_id);

        // ── Staff Performance ──────────────────────────────────────────────
        $staffPerformance = $this->staffPerformance($from, $to, $request->branch_id);

        // ── Daily Bookings Chart Data ──────────────────────────────────────
        $dailyChart = $this->dailyBookingsChart($from, $to, $request->branch_id);

        // ── CRM Stats ─────────────────────────────────────────────────────
        $crmStats = [
            'total_customers'   => Customer::count(),
            'new_this_period'   => Customer::whereBetween('created_at', [$from, $to])->count(),
            'repeat_customers'  => Customer::where('total_visits', '>=', 2)->count(),
        ];

        return view('admin.reports.index', compact(
            'branches', 'period', 'from', 'to',
            'revenueByBranch', 'bookingSummary', 'topServices',
            'staffPerformance', 'dailyChart', 'crmStats'
        ));
    }

    // ─── AJAX Endpoints (for live chart updates) ─────────────────────────

    public function revenueJson(Request $request): JsonResponse
    {
        [$from, $to] = $this->resolvePeriod($request->period ?? 'month', $request);

        $data = $this->revenueByBranch($from, $to);

        return response()->json([
            'labels' => $data->pluck('branch_name'),
            'values' => $data->pluck('total_revenue'),
        ]);
    }

    public function dailyChartJson(Request $request): JsonResponse
    {
        [$from, $to] = $this->resolvePeriod($request->period ?? 'month', $request);
        $data = $this->dailyBookingsChart($from, $to, $request->branch_id);

        return response()->json($data);
    }

    // ─── Private Builders ────────────────────────────────────────────────

    private function revenueByBranch(Carbon $from, Carbon $to)
    {
        return Branch::select('branches.id', 'branches.name as branch_name')
            ->selectRaw('COUNT(bookings.id) as total_bookings')
            ->selectRaw('COUNT(CASE WHEN bookings.status = ? THEN 1 END) as completed_bookings', ['completed'])
            ->selectRaw('COALESCE(SUM(CASE WHEN bookings.status = ? THEN services.price_min ELSE 0 END), 0) as total_revenue', ['completed'])
            ->leftJoin('bookings', function ($join) use ($from, $to) {
                $join->on('branches.id', '=', 'bookings.branch_id')
                     ->whereBetween('bookings.appointment_at', [$from, $to]);
            })
            ->leftJoin('services', 'bookings.service_id', '=', 'services.id')
            ->groupBy('branches.id', 'branches.name')
            ->orderByDesc('total_revenue')
            ->get();
    }

    private function bookingSummary(Carbon $from, Carbon $to, ?int $branchId = null): array
    {
        $query = Booking::whereBetween('appointment_at', [$from, $to]);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $all = $query->get();

        return [
            'total'     => $all->count(),
            'pending'   => $all->where('status', 'pending')->count(),
            'confirmed' => $all->where('status', 'confirmed')->count(),
            'completed' => $all->where('status', 'completed')->count(),
            'cancelled' => $all->where('status', 'cancelled')->count(),
            'from_website' => $all->where('source', 'website')->count(),
            'from_manual'  => $all->where('source', 'manual')->count(),
        ];
    }

    private function topServices(Carbon $from, Carbon $to, ?int $branchId = null)
    {
        $query = Service::select('services.id', 'services.title', 'services.category_type', 'services.price_min')
            ->selectRaw('COUNT(bookings.id) as bookings_count')
            ->selectRaw('COUNT(CASE WHEN bookings.status = ? THEN 1 END) as completed_count', ['completed'])
            ->leftJoin('bookings', function ($join) use ($from, $to) {
                $join->on('services.id', '=', 'bookings.service_id')
                     ->whereBetween('bookings.appointment_at', [$from, $to]);
            })
            ->groupBy('services.id', 'services.title', 'services.category_type', 'services.price_min')
            ->orderByDesc('bookings_count')
            ->take(10);

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->whereNull('services.branch_id')->orWhere('services.branch_id', $branchId);
            });
        }

        return $query->get();
    }

    private function staffPerformance(Carbon $from, Carbon $to, ?int $branchId = null)
    {
        $query = Staff::select('staff.id', 'staff.name', 'branches.name as branch_name')
            ->selectRaw('COUNT(bookings.id) as total_assigned')
            ->selectRaw('COUNT(CASE WHEN bookings.status = ? THEN 1 END) as completed', ['completed'])
            ->selectRaw('COALESCE(SUM(CASE WHEN bookings.status = ? THEN services.price_min ELSE 0 END), 0) as revenue', ['completed'])
            ->join('branches', 'staff.branch_id', '=', 'branches.id')
            ->leftJoin('bookings', function ($join) use ($from, $to) {
                $join->on('staff.id', '=', 'bookings.staff_id')
                     ->whereBetween('bookings.appointment_at', [$from, $to]);
            })
            ->leftJoin('services', 'bookings.service_id', '=', 'services.id')
            ->groupBy('staff.id', 'staff.name', 'branches.name')
            ->orderByDesc('completed');

        if ($branchId) {
            $query->where('staff.branch_id', $branchId);
        }

        return $query->get();
    }

    private function dailyBookingsChart(Carbon $from, Carbon $to, ?int $branchId = null): array
    {
        $query = Booking::selectRaw('DATE(appointment_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) as completed', ['completed'])
            ->whereBetween('appointment_at', [$from, $to])
            ->groupBy(DB::raw('DATE(appointment_at)'))
            ->orderBy('date');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $rows = $query->get()->keyBy('date');

        // Fill in every date (even empty ones)
        $labels = [];
        $totals = [];
        $completed = [];

        $current = $from->copy();
        while ($current->lte($to)) {
            $dateStr = $current->toDateString();
            $labels[]    = $current->format('d/m');
            $totals[]    = $rows[$dateStr]->total ?? 0;
            $completed[] = $rows[$dateStr]->completed ?? 0;
            $current->addDay();
        }

        return compact('labels', 'totals', 'completed');
    }

    // ─── Period Resolver ─────────────────────────────────────────────────

    private function resolvePeriod(string $period, Request $request): array
    {
        return match ($period) {
            'today'  => [Carbon::today(), Carbon::today()->endOfDay()],
            'week'   => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'month'  => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'year'   => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'custom' => [
                Carbon::parse($request->input('from', now()->subMonth())),
                Carbon::parse($request->input('to', now())),
            ],
            default  => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }
}
