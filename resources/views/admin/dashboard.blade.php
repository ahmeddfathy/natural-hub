@extends('admin.layout')

@section('title', 'لوحة التحكم الرئيسية')
@section('page-title', 'لوحة التحكم الرئيسية')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/dashboard.css') }}">
@endsection

@section('content')
<div class="dash-shell">

{{-- ── Hero Welcome ──────────────────────────────────────────── --}}
<div class="dash-hero">
    <div class="dash-hero-bg">
        <div class="dash-hero-orb dash-hero-orb--1"></div>
        <div class="dash-hero-orb dash-hero-orb--2"></div>
        <div class="dash-hero-orb dash-hero-orb--3"></div>
        <div class="dash-hero-grid"></div>
    </div>
    <div class="dash-hero-content">
        <div class="dash-hero-text">
            <span class="dash-hero-greeting">مرحباً بعودتك</span>
            <h1>{{ auth()->user()->name }} <span class="dash-hero-wave">👋</span></h1>
            <p>هذه نظرة شاملة على مركزك. تابع الحجوزات والإيرادات وأدِر كل شيء من مكان واحد.</p>
        </div>
        <div class="dash-hero-meta">
            <div class="dash-hero-date">
                <div class="dash-hero-date-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <span class="dash-hero-date-label">اليوم</span>
                    <span class="dash-hero-date-value">{{ now()->translatedFormat('l، d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Stats Grid — 2 rows of 4 ─────────────────────────────── --}}
<div class="dash-stats-grid">
    {{-- Row 1: Bookings --}}
    <div class="dash-stat-card dash-stat-card--gold">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="dash-stat-trend dash-stat-trend--up"><i class="fas fa-arrow-up"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['bookings_today'] }}</div>
        <div class="dash-stat-label">حجوزات اليوم</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:{{ min($stats['bookings_today'] * 10, 100) }}%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--amber">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-clock"></i></div>
            @if($stats['bookings_pending'] > 0)
                <div class="dash-stat-trend dash-stat-trend--down"><i class="fas fa-exclamation"></i></div>
            @endif
        </div>
        <div class="dash-stat-number">{{ $stats['bookings_pending'] }}</div>
        <div class="dash-stat-label">بانتظار التأكيد</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:{{ $stats['bookings_today'] > 0 ? min(($stats['bookings_pending'] / max($stats['bookings_today'],1)) * 100, 100) : 0 }}%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--success">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="dash-stat-trend dash-stat-trend--up"><i class="fas fa-arrow-up"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['completed_today'] }}</div>
        <div class="dash-stat-label">مكتملة اليوم</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:{{ $stats['bookings_today'] > 0 ? ($stats['completed_today'] / $stats['bookings_today']) * 100 : 0 }}%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--sky">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-calendar-alt"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['bookings_this_month'] }}</div>
        <div class="dash-stat-label">حجوزات الشهر</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:80%"></div></div>
    </div>

    {{-- Row 2: Operations --}}
    <div class="dash-stat-card dash-stat-card--purple">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-spa"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['total_services'] }}</div>
        <div class="dash-stat-label">الخدمات</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:100%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--rose">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-heart"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['total_customers'] }}</div>
        <div class="dash-stat-label">العميلات</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:85%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--teal">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-store"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['active_branches'] }}<small style="font-size:.55em;color:var(--text-muted)"> / {{ $stats['total_branches'] }}</small></div>
        <div class="dash-stat-label">الفروع النشطة</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:{{ $stats['total_branches'] > 0 ? ($stats['active_branches']/$stats['total_branches'])*100 : 0 }}%"></div></div>
    </div>

    <div class="dash-stat-card dash-stat-card--primary">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="dash-stat-number">{{ $stats['active_staff'] }}<small style="font-size:.55em;color:var(--text-muted)"> / {{ $stats['total_staff'] }}</small></div>
        <div class="dash-stat-label">الموظفات النشطات</div>
        <div class="dash-stat-bar"><div class="dash-stat-bar-fill" style="width:{{ $stats['total_staff'] > 0 ? ($stats['active_staff']/$stats['total_staff'])*100 : 0 }}%"></div></div>
    </div>
</div>

{{-- ── Quick Actions ─────────────────────────────────────────── --}}
<div class="dash-actions-ribbon">
    <div class="dash-actions-header">
        <div class="dash-actions-title">
            <div class="dash-actions-icon"><i class="fas fa-bolt"></i></div>
            <h3>إجراءات سريعة</h3>
        </div>
        <p>الوصول السريع لأهم المهام اليومية</p>
    </div>
    <div class="dash-actions-grid">
        <a href="{{ route('admin.bookings.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--gold"><i class="fas fa-calendar-plus"></i></div>
            <span class="dash-action-label">الحجوزات</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.customers.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--rose"><i class="fas fa-heart"></i></div>
            <span class="dash-action-label">العميلات</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.blogs.create') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--blue"><i class="fas fa-pen-nib"></i></div>
            <span class="dash-action-label">مقال جديد</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.services.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--purple"><i class="fas fa-spa"></i></div>
            <span class="dash-action-label">الخدمات</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--amber"><i class="fas fa-images"></i></div>
            <span class="dash-action-label">المعرض</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('home') }}" target="_blank" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--green"><i class="fas fa-external-link-alt"></i></div>
            <span class="dash-action-label">عرض الموقع</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
    </div>
</div>

{{-- ── Main Content: 3 Columns ───────────────────────────────── --}}
<div class="row g-4">

    {{-- Column 1: Weekly Chart + Revenue --}}
    <div class="col-lg-4 mb-4">
        {{-- Weekly Bookings Chart --}}
        <div class="dash-panel" style="margin-bottom:1.5rem;">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--gold"><i class="fas fa-chart-bar"></i></div>
                    <h4>حجوزات الأسبوع</h4>
                </div>
            </div>
            <div class="dash-panel-body">
                <div class="dash-chart-wrap">
                    @php $maxChart = max(array_column($weeklyChart, 'total') ?: [1]); @endphp
                    <div class="dash-chart-bars">
                        @foreach($weeklyChart as $day)
                        <div class="dash-chart-col">
                            <span class="dash-chart-val">{{ $day['total'] }}</span>
                            <div class="dash-chart-bar-track">
                                <div class="dash-chart-bar-fill" style="height:{{ $maxChart > 0 ? max(($day['total'] / $maxChart) * 100, 4) : 4 }}%"></div>
                            </div>
                            <span class="dash-chart-label">{{ $day['label_ar'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue per Branch --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--green"><i class="fas fa-coins"></i></div>
                    <h4>إيرادات الشهر</h4>
                </div>
            </div>
            <div class="dash-panel-body">
                @forelse($monthRevenue as $branch)
                <div class="dash-revenue-row">
                    <div class="dash-revenue-icon"><i class="fas fa-store"></i></div>
                    <div class="dash-revenue-info">
                        <h6>{{ $branch->branch_name }}</h6>
                        <small>{{ $branch->completed }} حجز مكتمل</small>
                    </div>
                    <div class="dash-revenue-amount">{{ number_format($branch->revenue) }} ج.م</div>
                </div>
                @empty
                <div class="dash-empty">
                    <div class="dash-empty-icon"><i class="fas fa-coins"></i></div>
                    <h5>لا توجد إيرادات بعد</h5>
                    <p>ستظهر هنا إيرادات الشهر الحالي</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Column 2: Today's Bookings --}}
    <div class="col-lg-4 mb-4">
        <div class="dash-panel">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--amber"><i class="fas fa-calendar-check"></i></div>
                    <h4>حجوزات اليوم</h4>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="dash-panel-link">
                    عرض الكل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="dash-panel-body">
                @forelse($todayBookings as $index => $booking)
                <div class="dash-list-item" style="animation-delay:{{ $index * 0.06 }}s;">
                    <div class="dash-list-thumb" style="background:rgba(201,163,107,.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-spa" style="color:#c9a36b;"></i>
                    </div>
                    <div class="dash-list-info">
                        <h6>{{ $booking->customer->name ?? 'عميلة' }}</h6>
                        <div class="dash-list-meta">
                            <span class="dash-pill dash-pill--{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                                <i class="fas {{ $booking->status === 'confirmed' ? 'fa-check' : 'fa-clock' }}"></i>
                                {{ $booking->status === 'confirmed' ? 'مؤكد' : 'معلق' }}
                            </span>
                            <span class="dash-list-time">
                                <i class="far fa-clock"></i>
                                {{ $booking->appointment_at?->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.bookings.show', $booking) }}" class="dash-list-action" title="عرض">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @empty
                <div class="dash-empty">
                    <div class="dash-empty-icon"><i class="fas fa-calendar-check"></i></div>
                    <h5>لا توجد حجوزات اليوم</h5>
                    <p>ستظهر هنا حجوزات اليوم فور إضافتها</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Column 3: Pending Alerts + Latest Blogs --}}
    <div class="col-lg-4 mb-4">
        {{-- Pending Bookings (Alerts) --}}
        @if($pendingBookings->count() > 0)
        <div class="dash-panel" style="margin-bottom:1.5rem; border-color: rgba(245,158,11,.15);">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--amber"><i class="fas fa-bell"></i></div>
                    <h4>تحتاج تأكيد <span class="dash-pill dash-pill--warning" style="margin-right:8px;">{{ $pendingBookings->count() }}</span></h4>
                </div>
            </div>
            <div class="dash-panel-body">
                @foreach($pendingBookings as $index => $pending)
                <div class="dash-alert-card" style="animation-delay:{{ $index * 0.06 }}s;">
                    <div class="dash-alert-icon"><i class="fas fa-exclamation"></i></div>
                    <div class="dash-alert-info">
                        <h6>{{ $pending->customer->name ?? 'عميلة' }} — {{ $pending->service->title ?? '' }}</h6>
                        <small><i class="far fa-clock"></i> {{ $pending->appointment_at?->format('d/m — h:i A') }}</small>
                    </div>
                    <a href="{{ route('admin.bookings.show', $pending) }}" class="dash-alert-action">عرض</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Latest Blogs --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--blue"><i class="fas fa-newspaper"></i></div>
                    <h4>أحدث المقالات</h4>
                </div>
                <a href="{{ route('admin.blogs.index') }}" class="dash-panel-link">
                    عرض الكل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="dash-panel-body">
                @forelse($latestBlogs as $index => $blog)
                <div class="dash-list-item" style="animation-delay:{{ $index * 0.06 }}s;">
                    <div class="dash-list-thumb">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                        @else
                            <div class="dash-list-thumb-empty"><i class="fas fa-image"></i></div>
                        @endif
                    </div>
                    <div class="dash-list-info">
                        <h6>{{ Str::limit($blog->title, 35) }}</h6>
                        <div class="dash-list-meta">
                            <span class="dash-pill {{ $blog->is_published ? 'dash-pill--success' : 'dash-pill--warning' }}">
                                <i class="fas {{ $blog->is_published ? 'fa-check' : 'fa-clock' }}"></i>
                                {{ $blog->is_published ? 'منشور' : 'مسودة' }}
                            </span>
                            <span class="dash-list-time">
                                <i class="far fa-clock"></i>
                                {{ $blog->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="dash-list-action" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                @empty
                <div class="dash-empty">
                    <div class="dash-empty-icon"><i class="fas fa-pen-nib"></i></div>
                    <h5>لا توجد مقالات بعد</h5>
                    <p>ابدأ بكتابة أول مقال لك</p>
                    <a href="{{ route('admin.blogs.create') }}" class="dash-empty-btn">
                        <i class="fas fa-plus"></i> أضف أول مقال
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ── Bottom Stats Strip ────────────────────────────────────── --}}
<div class="dash-bottom-strip">
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--slate"><i class="fas fa-newspaper"></i></div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">المقالات</span>
            <span class="dash-strip-value">{{ $stats['total_blogs'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--gold"><i class="fas fa-images"></i></div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">صور المعرض</span>
            <span class="dash-strip-value">{{ $stats['gallery_images'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--teal"><i class="fas fa-users"></i></div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">المستخدمين</span>
            <span class="dash-strip-value">{{ $stats['total_users'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--rose"><i class="fas fa-user-plus"></i></div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">عميلات جدد اليوم</span>
            <span class="dash-strip-value">{{ $stats['new_customers_today'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
</div>

</div>
@endsection
