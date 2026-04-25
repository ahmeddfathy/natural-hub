<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Field;
use App\Models\GalleryImage;
use App\Models\Service;
use App\Models\ShopBundle;
use App\Models\ShopProduct;
use App\Models\Staff;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const SORTABLE_MODELS = [
        'Branch' => Branch::class,
        'Category' => Category::class,
        'Field' => Field::class,
        'GalleryImage' => GalleryImage::class,
        'Service' => Service::class,
        'ShopBundle' => ShopBundle::class,
        'ShopProduct' => ShopProduct::class,
        'Staff' => Staff::class,
        'Video' => Video::class,
        'VideoCategory' => VideoCategory::class,
    ];

    public function index()
    {
        // ── CMS Stats ──────────────────────────────────────────────────────
        $stats = [
            // CMS
            'total_blogs'         => Blog::count(),
            'published_blogs'     => Blog::where('is_published', true)->count(),
            'total_categories'    => Category::count(),
            'total_users'         => User::count(),

            // Operational
            'total_branches'      => Branch::count(),
            'active_branches'     => Branch::where('is_active', true)->count(),
            'total_staff'         => Staff::count(),
            'active_staff'        => Staff::where('status', 'active')->count(),
            'total_customers'     => Customer::count(),
            'new_customers_today' => Customer::whereDate('created_at', today())->count(),

            // Bookings
            'bookings_today'      => Booking::today()->count(),
            'bookings_pending'    => Booking::pending()
                                          ->where('appointment_at', '>=', now())
                                          ->count(),
            'bookings_this_month' => Booking::whereMonth('appointment_at', now()->month)
                                          ->whereYear('appointment_at', now()->year)
                                          ->count(),
            'completed_today'     => Booking::today()->completed()->count(),

            // Services & Gallery
            'total_services'      => Service::count(),
            'gallery_images'      => GalleryImage::count(),
        ];


        // ── Today's Upcoming Bookings ──────────────────────────────────────
        $todayBookings = Booking::with(['customer', 'service', 'branch', 'staff'])
            ->today()
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_at')
            ->take(8)
            ->get();

        // ── Pending Bookings Needing Assignment ────────────────────────────
        $pendingBookings = Booking::with(['customer', 'service', 'branch'])
            ->pending()
            ->where('appointment_at', '>=', now())
            ->orderBy('appointment_at')
            ->take(5)
            ->get();

        // ── Revenue This Month (per branch) ───────────────────────────────
        $monthRevenue = Branch::select('branches.name as branch_name')
            ->selectRaw('COALESCE(SUM(CASE WHEN bookings.status = ? THEN services.price_min ELSE 0 END), 0) as revenue', ['completed'])
            ->selectRaw('COUNT(CASE WHEN bookings.status = ? THEN 1 END) as completed', ['completed'])
            ->leftJoin('bookings', function ($join) {
                $join->on('branches.id', '=', 'bookings.branch_id')
                     ->whereMonth('bookings.appointment_at', now()->month)
                     ->whereYear('bookings.appointment_at', now()->year);
            })
            ->leftJoin('services', 'bookings.service_id', '=', 'services.id')
            ->groupBy('branches.id', 'branches.name')
            ->get();

        // ── Weekly Bookings Chart (last 7 days) ───────────────────────────
        $weeklyChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $weeklyChart[] = [
                'label'    => $day->format('D'),           // Mon, Tue…
                'label_ar' => $this->dayNameAr($day->dayOfWeek),
                'total'    => Booking::whereDate('appointment_at', $day->toDateString())->count(),
                'completed'=> Booking::whereDate('appointment_at', $day->toDateString())
                                 ->where('status', 'completed')->count(),
            ];
        }

        // ── Latest Blog Posts ─────────────────────────────────────────────
        $latestBlogs = Blog::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'todayBookings', 'pendingBookings',
            'monthRevenue', 'weeklyChart', 'latestBlogs'
        ));
    }

    // ─── Sort Order (unchanged) ──────────────────────────────────────────

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'model'      => 'required|string|in:' . implode(',', array_keys(self::SORTABLE_MODELS)),
            'id'         => 'required|integer',
            'sort_order' => 'required|integer',
        ]);

        $modelClass = self::SORTABLE_MODELS[$request->model];
        $instance = $modelClass::find($request->id);

        if ($instance) {
            $oldOrder = (int) $instance->sort_order;
            $newOrder = (int) $request->sort_order;

            if ($oldOrder !== $newOrder) {
                DB::transaction(function () use ($modelClass, $instance, $oldOrder, $newOrder) {
                    $scopeQuery = function ($query) use ($instance, $modelClass) {
                        if ($modelClass === Video::class && !empty($instance->service_id)) {
                            $query->where('service_id', $instance->service_id);
                        } elseif ($modelClass === Video::class && !empty($instance->category_type)) {
                            $query->where('category_type', $instance->category_type);
                        }
                    };

                    if ($oldOrder === 0) {
                        $modelClass::where('sort_order', '>=', $newOrder)
                            ->where('id', '!=', $instance->id)
                            ->where($scopeQuery)
                            ->increment('sort_order');
                    } elseif ($newOrder < $oldOrder) {
                        $modelClass::whereBetween('sort_order', [$newOrder, $oldOrder - 1])
                            ->where('id', '!=', $instance->id)
                            ->where($scopeQuery)
                            ->increment('sort_order');
                    } elseif ($newOrder > $oldOrder) {
                        $modelClass::whereBetween('sort_order', [$oldOrder + 1, $newOrder])
                            ->where('id', '!=', $instance->id)
                            ->where($scopeQuery)
                            ->decrement('sort_order');
                    }

                    $instance->sort_order = $newOrder;
                    $instance->save();
                });
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────

    private function dayNameAr(int $dayOfWeek): string
    {
        return ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'][$dayOfWeek];
    }
}
