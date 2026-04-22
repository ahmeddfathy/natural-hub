@extends('admin.layout')
@section('title', 'تفاصيل الحجز #' . $booking->id)
@section('page-title', 'تفاصيل الحجز')

@section('content')

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> العودة
    </a>
    <span class="badge fs-6 bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
</div>

<div class="row g-4">
    {{-- Booking Details --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-info-circle text-primary me-2"></i> تفاصيل الحجز
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted w-40">رقم الحجز</td><td class="fw-bold">#{{ $booking->id }}</td></tr>
                    <tr><td class="text-muted">الخدمة</td><td>{{ $booking->service->title }}</td></tr>
                    <tr><td class="text-muted">الفرع</td><td>{{ $booking->branch->name }}</td></tr>
                    <tr><td class="text-muted">الموعد</td><td>{{ $booking->appointment_at->format('Y-m-d H:i') }}</td></tr>
                    <tr><td class="text-muted">المدة</td><td>{{ $booking->duration_minutes ? $booking->duration_minutes . ' دقيقة' : '—' }}</td></tr>
                    <tr><td class="text-muted">المصدر</td><td>{{ $booking->source === 'website' ? 'حجز من الموقع' : 'حجز يدوي' }}</td></tr>
                    @if($booking->notes)
                    <tr><td class="text-muted">ملاحظات</td><td>{{ $booking->notes }}</td></tr>
                    @endif
                    @if($booking->cancellation_reason)
                    <tr><td class="text-muted">سبب الإلغاء</td><td class="text-danger">{{ $booking->cancellation_reason }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Customer --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-user text-primary me-2"></i> بيانات العميلة
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted">الاسم</td><td>{{ $booking->customer->name }}</td></tr>
                    <tr><td class="text-muted">الموبايل</td><td dir="ltr">{{ $booking->customer->phone }}</td></tr>
                    <tr><td class="text-muted">إجمالي الزيارات</td><td>{{ $booking->customer->total_visits }}</td></tr>
                </table>
                <a href="{{ route('admin.customers.show', $booking->customer) }}" class="btn btn-outline-primary btn-sm mt-2">
                    عرض ملف العميلة <i class="fas fa-external-link-alt ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-md-5">
        {{-- Assign Staff --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-user-check text-primary me-2"></i> تعيين الموظفة
            </div>
            <div class="card-body">
                @if($booking->staff)
                    <div class="alert alert-success mb-3">
                        <i class="fas fa-check me-2"></i> معيّنة: <strong>{{ $booking->staff->name }}</strong>
                    </div>
                @endif
                <form id="assignForm">
                    @csrf
                    <select name="staff_id" class="form-select mb-3" id="staffSelect">
                        <option value="">اختري موظفة...</option>
                        @foreach($staff as $s)
                            <option value="{{ $s->id }}" {{ $booking->staff_id == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary w-100" onclick="assignStaff()">
                        <i class="fas fa-check me-1"></i> تعيين
                    </button>
                </form>
                <div id="assignMsg" class="mt-2"></div>
            </div>
        </div>

        {{-- Status Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-cog text-primary me-2"></i> تغيير الحالة
            </div>
            <div class="card-body d-grid gap-2">
                @if($booking->isPending())
                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                    @csrf
                    <button class="btn btn-info w-100 text-white">
                        <i class="fas fa-check-double me-1"></i> تأكيد الحجز
                    </button>
                </form>
                @endif

                @if(!$booking->isCompleted() && !$booking->isCancelled())
                <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                    @csrf
                    <button class="btn btn-success w-100">
                        <i class="fas fa-flag-checkered me-1"></i> تسجيل كمكتملة
                    </button>
                </form>
                @endif

                @if(!$booking->isCancelled() && !$booking->isCompleted())
                <button class="btn btn-outline-danger w-100" data-bs-toggle="collapse" data-bs-target="#cancelForm">
                    <i class="fas fa-ban me-1"></i> إلغاء الحجز
                </button>
                <div class="collapse" id="cancelForm">
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mt-2">
                        @csrf
                        <textarea name="reason" class="form-control mb-2" rows="2" placeholder="سبب الإلغاء (اختياري)"></textarea>
                        <button type="submit" class="btn btn-danger w-100 btn-sm">تأكيد الإلغاء</button>
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
            `<div class="alert alert-success">${data.message}</div>`;
    });
}
</script>
@endsection
