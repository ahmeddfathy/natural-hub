@extends('admin.layout')
@section('title', 'تفاصيل الحجز #' . $booking->id)
@section('page-title', 'تفاصيل الحجز')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/bookings.css') }}">
@endsection

@section('content')

@if(session('success'))
    <div style="background:rgba(16,185,129,.08);color:#059669;border:1px solid rgba(16,185,129,.15);display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;font-weight:600;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="bk-back-btn">
        <i class="fas fa-arrow-right"></i> العودة
    </a>
    <span class="bk-big-status bk-status-{{ $booking->status }}">{{ $booking->status_label }}</span>
</div>

<div class="row g-4">
    {{-- Booking Details --}}
    <div class="col-md-7">
        <div class="bk-detail-panel">
            <div class="bk-detail-header"><i class="fas fa-info-circle"></i> تفاصيل الحجز</div>
            <div class="bk-detail-row"><span class="bk-detail-label">رقم الحجز</span><span class="bk-detail-value">#{{ $booking->id }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">الخدمة</span><span class="bk-detail-value">{{ $booking->service->title }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">الفرع</span><span class="bk-detail-value">{{ $booking->branch->name }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">الموعد</span><span class="bk-detail-value">{{ $booking->appointment_at->format('Y-m-d H:i') }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">المدة</span><span class="bk-detail-value">{{ $booking->duration_minutes ? $booking->duration_minutes . ' دقيقة' : '—' }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">المصدر</span><span class="bk-detail-value">{{ $booking->source === 'website' ? 'حجز من الموقع' : 'حجز يدوي' }}</span></div>
            @if($booking->notes)
            <div class="bk-detail-row"><span class="bk-detail-label">ملاحظات</span><span class="bk-detail-value">{{ $booking->notes }}</span></div>
            @endif
            @if($booking->cancellation_reason)
            <div class="bk-detail-row"><span class="bk-detail-label">سبب الإلغاء</span><span class="bk-detail-value" style="color:#dc2626;">{{ $booking->cancellation_reason }}</span></div>
            @endif
        </div>

        {{-- Customer --}}
        <div class="bk-detail-panel" style="animation-delay:.1s">
            <div class="bk-detail-header"><i class="fas fa-user"></i> بيانات العميلة</div>
            <div class="bk-detail-row"><span class="bk-detail-label">الاسم</span><span class="bk-detail-value">{{ $booking->customer->name }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">الموبايل</span><span class="bk-detail-value" dir="ltr">{{ $booking->customer->phone }}</span></div>
            <div class="bk-detail-row"><span class="bk-detail-label">إجمالي الزيارات</span><span class="bk-detail-value">{{ $booking->customer->total_visits }}</span></div>
            <a href="{{ route('admin.customers.show', $booking->customer) }}" class="bk-back-btn mt-3" style="display:inline-flex;">
                عرض ملف العميلة <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-md-5">
        {{-- Assign Staff --}}
        <div class="bk-detail-panel" style="animation-delay:.15s">
            <div class="bk-detail-header"><i class="fas fa-user-check"></i> تعيين الموظفة</div>
            @if($booking->staff)
                <div style="background:rgba(16,185,129,.08);color:#059669;padding:.75rem 1rem;border-radius:12px;margin-bottom:1rem;font-weight:600;font-size:.88rem;">
                    <i class="fas fa-check me-2"></i> معيّنة: <strong>{{ $booking->staff->name }}</strong>
                </div>
            @endif
            <form id="assignForm">
                @csrf
                <select name="staff_id" class="form-select mb-3" id="staffSelect">
                    <option value="">اختري موظفة...</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ $booking->staff_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="bk-action-btn bk-action-confirm" onclick="assignStaff()">
                    <i class="fas fa-check"></i> تعيين
                </button>
            </form>
            <div id="assignMsg" class="mt-2"></div>
        </div>

        {{-- Status Actions --}}
        <div class="bk-detail-panel" style="animation-delay:.2s">
            <div class="bk-detail-header"><i class="fas fa-cog"></i> تغيير الحالة</div>
            <div class="d-grid gap-2">
                @if($booking->isPending())
                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                    @csrf
                    <button class="bk-action-btn bk-action-confirm w-100">
                        <i class="fas fa-check-double"></i> تأكيد الحجز
                    </button>
                </form>
                @endif

                @if(!$booking->isCompleted() && !$booking->isCancelled())
                <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                    @csrf
                    <button class="bk-action-btn bk-action-complete w-100">
                        <i class="fas fa-flag-checkered"></i> تسجيل كمكتملة
                    </button>
                </form>
                @endif

                @if(!$booking->isCancelled() && !$booking->isCompleted())
                <button class="bk-action-btn bk-action-cancel" data-bs-toggle="collapse" data-bs-target="#cancelForm">
                    <i class="fas fa-ban"></i> إلغاء الحجز
                </button>
                <div class="collapse" id="cancelForm">
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mt-2">
                        @csrf
                        <textarea name="reason" class="form-control mb-2" rows="2" placeholder="سبب الإلغاء (اختياري)"></textarea>
                        <button type="submit" class="bk-action-btn bk-action-cancel w-100" style="font-size:.82rem;">تأكيد الإلغاء</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function assignStaff() {
    const staffId = document.getElementById('staffSelect').value;
    if (!staffId) return alert('اختاري موظفة أولاً');

    fetch('{{ route("admin.bookings.assign-staff", $booking) }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ staff_id: staffId })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('assignMsg').innerHTML =
            `<div style="background:rgba(16,185,129,.08);color:#059669;padding:.75rem;border-radius:10px;font-size:.85rem;font-weight:600;">${data.message}</div>`;
    });
}
</script>
@endsection
