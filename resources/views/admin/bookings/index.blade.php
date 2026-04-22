@extends('admin.layout')
@section('title', 'إدارة الحجوزات')
@section('page-title', 'إدارة الحجوزات')

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fas fa-calendar-check text-primary me-2"></i>الحجوزات</h4>
        <p class="text-muted mb-0 small">إدارة جميع مواعيد الجلسات</p>
    </div>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> حجز يدوي جديد
    </a>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="fs-2 fw-bold text-warning">{{ $stats['pending'] }}</div>
                <div class="small text-muted">قيد الانتظار</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="fs-2 fw-bold text-primary">{{ $stats['today'] }}</div>
                <div class="small text-muted">حجوزات اليوم</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="fs-2 fw-bold text-success">{{ $stats['completed'] }}</div>
                <div class="small text-muted">مكتملة اليوم</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center border-0 shadow-sm h-100 bg-primary text-white">
            <div class="card-body">
                <div class="fs-2 fw-bold">{{ $bookings->total() }}</div>
                <div class="small opacity-75">إجمالي النتائج</div>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">الفرع</label>
                <select name="branch_id" class="form-select form-select-sm">
                    <option value="">كل الفروع</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">الحالة</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">الكل</option>
                    <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>قيد الانتظار</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>مؤكد</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>ملغي</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">الموظفة</label>
                <select name="staff_id" class="form-select form-select-sm">
                    <option value="">كل الموظفات</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} — {{ $s->branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">التاريخ</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                    <i class="fas fa-search me-1"></i> فلترة
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
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
                        <td class="text-muted small">{{ $booking->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $booking->customer->name }}</div>
                            <div class="small text-muted">{{ $booking->customer->phone }}</div>
                        </td>
                        <td class="small">{{ $booking->service->title }}</td>
                        <td class="small">{{ $booking->branch->name }}</td>
                        <td>
                            @if($booking->staff)
                                <span class="badge bg-light text-dark border">{{ $booking->staff->name }}</span>
                            @else
                                <span class="text-warning small"><i class="fas fa-exclamation-triangle me-1"></i>لم تُعيَّن</span>
                            @endif
                        </td>
                        <td class="small">
                            <div>{{ $booking->appointment_at->format('Y-m-d') }}</div>
                            <div class="text-muted">{{ $booking->appointment_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $booking->source === 'website' ? 'bg-info' : 'bg-secondary' }} text-white">
                                {{ $booking->source === 'website' ? 'موقع' : 'يدوي' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                            لا توجد حجوزات تطابق الفلتر الحالي
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($bookings->hasPages())
    <div class="card-footer">
        {{ $bookings->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
