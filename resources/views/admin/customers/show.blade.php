@extends('admin.layout')
@section('title', 'ملف: ' . $customer->name)
@section('page-title', 'ملف العميلة')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.customers.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.5rem 1.25rem;border-radius:10px;font-weight:700;font-size:.82rem;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;transition:.2s;">
        <i class="fas fa-arrow-right"></i> العودة
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        {{-- Profile Card --}}
        <div class="ops-detail-panel" style="text-align:center;">
            <div style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,#f43f5e,#fb7185);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                <span style="color:#fff;font-size:2rem;font-weight:900;">{{ mb_substr($customer->name, 0, 1) }}</span>
            </div>
            <h5 style="font-weight:800;margin-bottom:.25rem;">{{ $customer->name }}</h5>
            <p style="color:var(--text-muted);direction:ltr;display:inline-block;margin-bottom:1rem;">{{ $customer->phone }}</p>
            <div class="row g-0" style="border-top:1px solid var(--border);padding-top:1rem;">
                <div class="col-6">
                    <div style="font-size:1.5rem;font-weight:900;">{{ $customer->total_visits }}</div>
                    <div style="font-size:.78rem;color:var(--text-muted);">زيارة</div>
                </div>
                <div class="col-6" style="border-right:1px solid var(--border);">
                    <div style="font-size:1.5rem;font-weight:900;">{{ $bookings->count() }}</div>
                    <div style="font-size:.78rem;color:var(--text-muted);">حجز</div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="ops-detail-panel">
            <div class="ops-detail-header"><i class="fas fa-sticky-note"></i> ملاحظات</div>
            <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="name" value="{{ $customer->name }}">
                <textarea name="notes" class="form-control mb-3" rows="3" placeholder="ملاحظات خاصة بهذه العميلة...">{{ $customer->notes }}</textarea>
                <button class="ops-banner-btn" style="width:100%;justify-content:center;">حفظ</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="ops-table-card">
            <div class="ops-table-header">
                <i class="fas fa-history"></i>
                <h5>سجل الزيارات</h5>
            </div>
            <div class="table-responsive">
                <table class="ops-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الخدمة</th>
                            <th>الفرع</th>
                            <th>الموظفة</th>
                            <th>الموعد</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td style="font-size:.78rem;">{{ $booking->id }}</td>
                            <td>{{ $booking->service->title }}</td>
                            <td>{{ $booking->branch->name }}</td>
                            <td>{{ $booking->staff?->name ?? '—' }}</td>
                            <td>{{ $booking->appointment_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="ops-badge ops-badge-{{ $booking->status === 'completed' ? 'active' : ($booking->status === 'cancelled' ? 'inactive' : 'leave') }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center" style="padding:2rem;color:var(--text-muted);">لا توجد حجوزات مسجلة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
