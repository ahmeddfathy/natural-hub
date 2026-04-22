@extends('admin.layout')

@section('title', 'لوحة التحكم الرئيسية')
@section('page-title', 'لوحة التحكم الرئيسية')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/dashboard.css') }}">
@endsection

@section('content')
<div class="dash-shell">

<!-- Hero Welcome Card -->
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
            <p>هذه نظرة عامة على موقعك. تابع أحدث الإحصائيات والمحتوى وأدِر كل شيء من مكان واحد.</p>
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

<!-- Stats Grid -->
<div class="dash-stats-grid">
    <div class="dash-stat-card dash-stat-card--primary">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="dash-stat-trend dash-stat-trend--up">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="dash-stat-number">{{ $stats['total_blogs'] }}</div>
        <div class="dash-stat-label">إجمالي المقالات</div>
        <div class="dash-stat-bar">
            <div class="dash-stat-bar-fill" style="width: 100%;"></div>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--success">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="dash-stat-trend dash-stat-trend--up">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="dash-stat-number">{{ $stats['published_blogs'] }}</div>
        <div class="dash-stat-label">مقالات منشورة</div>
        <div class="dash-stat-bar">
            <div class="dash-stat-bar-fill" style="width: {{ $stats['total_blogs'] > 0 ? ($stats['published_blogs'] / $stats['total_blogs']) * 100 : 0 }}%;"></div>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--amber">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon">
                <i class="fas fa-images"></i>
            </div>
            <div class="dash-stat-trend dash-stat-trend--up">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="dash-stat-number">{{ $stats['gallery_images'] }}</div>
        <div class="dash-stat-label">صور المعرض</div>
        <div class="dash-stat-bar">
            <div class="dash-stat-bar-fill" style="width: 75%;"></div>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--purple">
        <div class="dash-stat-shimmer"></div>
        <div class="dash-stat-top">
            <div class="dash-stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="dash-stat-trend dash-stat-trend--up">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="dash-stat-number">{{ $stats['total_categories'] }}</div>
        <div class="dash-stat-label">الفئات</div>
        <div class="dash-stat-bar">
            <div class="dash-stat-bar-fill" style="width: 80%;"></div>
        </div>
    </div>
</div>

<!-- Quick Actions Ribbon -->
<div class="dash-actions-ribbon">
    <div class="dash-actions-header">
        <div class="dash-actions-title">
            <div class="dash-actions-icon">
                <i class="fas fa-bolt"></i>
            </div>
            <h3>إجراءات سريعة</h3>
        </div>
        <p>ابدأ بإضافة محتوى جديد أو إدارة المحتوى الحالي</p>
    </div>
    <div class="dash-actions-grid">
        <a href="{{ route('admin.blogs.create') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--blue">
                <i class="fas fa-pen-nib"></i>
            </div>
            <span class="dash-action-label">مقال جديد</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--amber">
                <i class="fas fa-images"></i>
            </div>
            <span class="dash-action-label">إدارة المعرض</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--purple">
                <i class="fas fa-layer-group"></i>
            </div>
            <span class="dash-action-label">إدارة الفئات</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
        <a href="{{ route('home') }}" target="_blank" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon--green">
                <i class="fas fa-external-link-alt"></i>
            </div>
            <span class="dash-action-label">عرض الموقع</span>
            <i class="fas fa-arrow-left dash-action-arrow"></i>
        </a>
    </div>
</div>

<!-- Content Section -->
<div class="row">
    <!-- Latest Blogs -->
    <div class="col-lg-7 mb-4">
        <div class="dash-panel">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--blue">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h4>أحدث المقالات</h4>
                </div>
                <a href="{{ route('admin.blogs.index') }}" class="dash-panel-link">
                    عرض الكل
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="dash-panel-body">
                @forelse($latestBlogs as $index => $blog)
                <div class="dash-list-item" style="animation-delay: {{ $index * 0.06 }}s;">
                    <div class="dash-list-thumb">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                        @else
                            <div class="dash-list-thumb-empty">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>
                    <div class="dash-list-info">
                        <h6>{{ Str::limit($blog->title, 45) }}</h6>
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
                    <div class="dash-empty-icon">
                        <i class="fas fa-pen-nib"></i>
                    </div>
                    <h5>لا توجد مقالات بعد</h5>
                    <p>ابدأ بكتابة أول مقال لك</p>
                    <a href="{{ route('admin.blogs.create') }}" class="dash-empty-btn">
                        <i class="fas fa-plus"></i>
                        أضف أول مقال
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-lg-5 mb-4">
        <div class="dash-panel">
            <div class="dash-panel-header">
                <div class="dash-panel-title">
                    <div class="dash-panel-icon dash-panel-icon--amber">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4>حجوزات اليوم</h4>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="dash-panel-link">
                    عرض الكل
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="dash-panel-body">
                @forelse($todayBookings as $index => $booking)
                <div class="dash-list-item" style="animation-delay: {{ $index * 0.06 }}s;">
                    <div class="dash-list-thumb" style="background:rgba(201,163,107,.15);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-spa" style="color:#c9a36b;"></i>
                    </div>
                    <div class="dash-list-info">
                        <h6>{{ $booking->customer->name ?? 'عميل' }} — {{ $booking->service->title ?? '' }}</h6>
                        <div class="dash-list-meta">
                            <span class="dash-pill dash-pill--{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
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
                    <div class="dash-empty-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5>لا توجد حجوزات اليوم</h5>
                    <p>ستظهر هنا حجوزات اليوم فور إضافتها</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Bottom Stats Strip -->
<div class="dash-bottom-strip">
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--slate">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">مسودات</span>
            <span class="dash-strip-value">{{ $stats['total_blogs'] - $stats['published_blogs'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--gold">
            <i class="fas fa-spa"></i>
        </div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">الخدمات</span>
            <span class="dash-strip-value">{{ $stats['total_services'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
    <div class="dash-strip-card">
        <div class="dash-strip-icon dash-strip-icon--teal">
            <i class="fas fa-users"></i>
        </div>
        <div class="dash-strip-info">
            <span class="dash-strip-label">المستخدمين</span>
            <span class="dash-strip-value">{{ $stats['total_users'] }}</span>
        </div>
        <div class="dash-strip-glow"></div>
    </div>
</div>

</div>
@endsection
