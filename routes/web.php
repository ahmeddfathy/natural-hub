<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ShopController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\BlogController;


// ===== الصفحات الرئيسية =====
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::get('/videos', function () {
    return view('videos');
})->name('videos');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');


Route::get('/services', [ServiceController::class, 'index'])->name('services');

// ===== المدونة =====
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

// Redirect /insights to /blog (301 Permanent)
Route::redirect('/insights', '/blog', 301)->name('insights');
Route::redirect('/article', '/blog', 301)->name('article');
Route::redirect('/case-study', '/blog', 301)->name('case-study');

Route::get('/library', [LibraryController::class, 'index'])->name('library');


// ===== Dynamic Sitemap =====
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ===== Public API (Booking + AJAX data) =====
Route::prefix('api')->name('api.')->group(function () {
    // Booking submission from the website form
    Route::post('/book', [BookingController::class, 'store'])->name('book');

    // Booking status check (customer-facing)
    Route::get('/booking/{id}/status', [BookingController::class, 'status'])
        ->where('id', '[0-9]+')
        ->name('booking.status');

    // Data for the booking form dropdowns
    Route::get('/branches', [BookingController::class, 'branches'])->name('branches');
    Route::get('/services', [BookingController::class, 'services'])->name('services');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // إذا كان المستخدم أدمن، وجهه على لوحة التحكم المخصصة
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        // إذا كان مستخدم عادي، وجهه على الصفحة الرئيسية
        return redirect()->route('home');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth:sanctum', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-sort-order', [DashboardController::class, 'updateSortOrder'])->name('update-sort-order');
    
    // User Management Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);

    // Fields Routes
    Route::resource('fields', \App\Http\Controllers\Admin\FieldController::class)->except(['show']);
    
    // Blog Routes
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->except(['show']);
    Route::post('blogs/{blog}/toggle-status', [\App\Http\Controllers\Admin\BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');
    Route::post('blogs/upload-image', [\App\Http\Controllers\Admin\BlogController::class, 'uploadImage'])->name('blogs.upload-image');
    Route::post('blogs/upload-temp-media', [\App\Http\Controllers\Admin\BlogController::class, 'uploadTempMedia'])->name('blogs.upload-temp-media');
    Route::post('blogs/remove-temp-media', [\App\Http\Controllers\Admin\BlogController::class, 'removeTempMedia'])->name('blogs.remove-temp-media');
    Route::post('blogs/clear-temp-images', [\App\Http\Controllers\Admin\BlogController::class, 'clearTempImages'])->name('blogs.clear-temp-images');
    
    // Category Routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    
    // Video Categories Routes (غير مستخدمة — الفيديوهات تستخدم category_type الآن)
    // Route::resource('video-categories', \App\Http\Controllers\Admin\VideoCategoryController::class)->except(['show']);

    // Video Routes
    Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class)->except(['show']);
    Route::post('videos/{video}/toggle-status', [\App\Http\Controllers\Admin\VideoController::class, 'toggleStatus'])->name('videos.toggle-status');

    // Services Routes
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['show']);
    Route::post('services/{service}/toggle-status', [\App\Http\Controllers\Admin\ServiceController::class, 'toggleStatus'])->name('services.toggle-status');

    // ── Phase 2: New Admin Routes ────────────────────────────────────────────

    // Branches
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class)->except(['show']);
    Route::post('branches/{branch}/toggle-status', [\App\Http\Controllers\Admin\BranchController::class, 'toggleStatus'])->name('branches.toggle-status');

    // Staff
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class)->except(['show']);

    // Bookings
    Route::get('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [\App\Http\Controllers\Admin\BookingController::class, 'create'])->name('bookings.create');
    Route::get('bookings/lookup-customer', [\App\Http\Controllers\Admin\BookingController::class, 'lookupCustomer'])->name('bookings.lookup-customer');
    Route::post('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/confirm', [\App\Http\Controllers\Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/complete', [\App\Http\Controllers\Admin\BookingController::class, 'complete'])->name('bookings.complete');
    Route::post('bookings/{booking}/cancel', [\App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/assign-staff', [\App\Http\Controllers\Admin\BookingController::class, 'assignStaff'])->name('bookings.assign-staff');

    // Customers (CRM)
    Route::get('customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::patch('customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customers.update');

    // Gallery CMS
    Route::get('gallery', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('gallery.index');
    Route::post('gallery', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('gallery.store');
    Route::patch('gallery/{galleryImage}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('gallery/{galleryImage}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('gallery/{galleryImage}/toggle-status', [\App\Http\Controllers\Admin\GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
    Route::post('gallery/sort-order', [\App\Http\Controllers\Admin\GalleryController::class, 'updateSortOrder'])->name('gallery.sort-order');

    // Shop CMS — Bundles
    Route::get('shop', [\App\Http\Controllers\Admin\ShopController::class, 'index'])->name('shop.index');
    Route::get('shop/bundles/create', [\App\Http\Controllers\Admin\ShopController::class, 'createBundle'])->name('shop.bundles.create');
    Route::post('shop/bundles', [\App\Http\Controllers\Admin\ShopController::class, 'storeBundle'])->name('shop.bundles.store');
    Route::get('shop/bundles/{bundle}/edit', [\App\Http\Controllers\Admin\ShopController::class, 'editBundle'])->name('shop.bundles.edit');
    Route::put('shop/bundles/{bundle}', [\App\Http\Controllers\Admin\ShopController::class, 'updateBundle'])->name('shop.bundles.update');
    Route::delete('shop/bundles/{bundle}', [\App\Http\Controllers\Admin\ShopController::class, 'destroyBundle'])->name('shop.bundles.destroy');

    // Shop CMS — Products
    Route::get('shop/products/create', [\App\Http\Controllers\Admin\ShopController::class, 'createProduct'])->name('shop.products.create');
    Route::post('shop/products', [\App\Http\Controllers\Admin\ShopController::class, 'storeProduct'])->name('shop.products.store');
    Route::get('shop/products/{product}/edit', [\App\Http\Controllers\Admin\ShopController::class, 'editProduct'])->name('shop.products.edit');
    Route::put('shop/products/{product}', [\App\Http\Controllers\Admin\ShopController::class, 'updateProduct'])->name('shop.products.update');
    Route::delete('shop/products/{product}', [\App\Http\Controllers\Admin\ShopController::class, 'destroyProduct'])->name('shop.products.destroy');

    Route::post('shop/products/{product}/toggle-stock', [\App\Http\Controllers\Admin\ShopController::class, 'toggleStock'])->name('shop.products.toggle-stock');

    // ── Reports (Phase 3) ──────────────────────────────────────────────────
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenueJson'])->name('reports.revenue');
    Route::get('reports/daily-chart', [\App\Http\Controllers\Admin\ReportController::class, 'dailyChartJson'])->name('reports.daily-chart');

});

