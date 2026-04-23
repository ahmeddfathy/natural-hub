@extends('admin.layout')
@section('title', 'إدارة الحجوزات')
@section('page-title', 'إدارة الحجوزات')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/bookings.css') }}">
@endsection

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div class="blogs-alert blogs-alert-success" style="background:rgba(16,185,129,.08);color:#059669;border:1px solid rgba(16,185,129,.15);display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;font-weight:600;animation:fadeSlideUp .4s ease both;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:rgba(220,38,38,.06);color:#dc2626;border:1px solid rgba(220,38,38,.12);display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;font-weight:600;animation:fadeSlideUp .4s ease both;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- Banner --}}
<div class="bk-banner" style="background:var(--bg-card);border:1px solid var(--border);border-radius:20px;padding:1.5rem;margin-bottom:1.5rem;">
    <div class="bk-banner-top">
        <div class="bk-banner-title">
            <i class="fas fa-calendar-check"></i>
            <div>
                <h4 style="font-weight:800;color:var(--accent);margin:0;">إدارة الحجوزات</h4>
                <p style="color:var(--text-muted);font-size:.9rem;margin:5px 0 0;">إدارة جميع مواعيد الجلسات</p>
            </div>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="bk-banner-btn">
            <i class="fas fa-plus"></i> حجز يدوي جديد
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="bk-stats-grid">
    <div class="bk-stat-card" style="animation-delay:.05s">
        <div class="bk-stat-card-icon pending"><i class="fas fa-clock"></i></div>
        <div class="bk-stat-value">{{ $stats['pending'] }}</div>
        <div class="bk-stat-label">قيد الانتظار</div>
    </div>
    <div class="bk-stat-card" style="animation-delay:.1s">
        <div class="bk-stat-card-icon today"><i class="fas fa-calendar-day"></i></div>
        <div class="bk-stat-value">{{ $stats['today'] }}</div>
        <div class="bk-stat-label">حجوزات اليوم</div>
    </div>
    <div class="bk-stat-card" style="animation-delay:.15s">
        <div class="bk-stat-card-icon completed"><i class="fas fa-check-double"></i></div>
        <div class="bk-stat-value">{{ $stats['completed'] }}</div>
        <div class="bk-stat-label">مكتملة اليوم</div>
    </div>
    <div class="bk-stat-card" style="animation-delay:.2s">
        <div class="bk-stat-card-icon total"><i class="fas fa-calendar-alt"></i></div>
        <div class="bk-stat-value">{{ $bookings->total() }}</div>
        <div class="bk-stat-label">إجمالي النتائج</div>
    </div>
</div>

{{-- Filters --}}
<div class="bk-filter-card">
    <div class="bk-filter-header">
        <i class="fas fa-filter"></i>
        <h5>تصفية الحجوزات</h5>
    </div>
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label small">الفرع</label>
            <select name="branch_id" class="form-select">
                <option value="">كل الفروع</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>قيد الانتظار</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>مؤكد</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>مكتمل</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>ملغي</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">الموظفة</label>
            <select name="staff_id" class="form-select">
                <option value="">كل الموظفات</option>
                @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} — {{ $s->branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">التاريخ</label>
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="bk-banner-btn flex-fill" style="padding:.5rem;font-size:.82rem;">
                <i class="fas fa-search"></i> فلترة
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="bk-back-btn" style="padding:.5rem .75rem;">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bk-table-card">
    <div class="bk-table-header">
        <i class="fas fa-list-ul"></i>
        <h5>جدول الحجوزات</h5>
    </div>
    <div class="table-responsive">
        <table class="bk-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>العميلة</th>
                    <th>الخدمة</th>
                    <th>الفرع</th>
                    <th>الموظفة</th>
                    <th>الموعد</th>
                    <th>المصدر</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td style="font-size:.78rem;color:var(--text-muted);">{{ $booking->id }}</td>
                    <td>
                        <div class="bk-customer-cell">
                            <span class="bk-name">{{ $booking->customer->name }}</span>
                            <span class="bk-phone">{{ $booking->customer->phone }}</span>
                        </div>
                    </td>
                    <td>{{ $booking->service->title }}</td>
                    <td>{{ $booking->branch->name }}</td>
                    <td>
                        @if($booking->staff)
                            <span class="bk-staff-badge">{{ $booking->staff->name }}</span>
                        @else
                            <span class="bk-staff-unassigned"><i class="fas fa-exclamation-triangle"></i> لم تُعيَّن</span>
                        @endif
                    </td>
                    <td>
                        <div class="bk-date-cell">
                            <span class="bk-date">{{ $booking->appointment_at->format('Y-m-d') }}</span>
                            <span class="bk-time">{{ $booking->appointment_at->format('H:i') }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="bk-source {{ $booking->source === 'website' ? 'bk-source-website' : 'bk-source-manual' }}">
                            {{ $booking->source === 'website' ? 'موقع' : 'يدوي' }}
                        </span>
                    </td>
                    <td>
                        <span class="bk-status bk-status-{{ $booking->status }}">
                            {{ $booking->status_label }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="bk-view-btn" title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="bk-empty">
                            <i class="fas fa-calendar-times"></i>
                            <p>لا توجد حجوزات تطابق الفلتر الحالي</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="bk-pagination">
        {{ $bookings->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
