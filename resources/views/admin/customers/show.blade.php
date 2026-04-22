@extends('admin.layout')
@section('title', 'ملف: ' . $customer->name)
@section('page-title', 'ملف العميلة')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> العودة
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        {{-- Customer Profile Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:80px;height:80px;">
                    <span class="text-white fs-2 fw-bold">{{ mb_substr($customer->name, 0, 1) }}</span>
                </div>
                <h5 class="mb-1">{{ $customer->name }}</h5>
                <p class="text-muted mb-3" dir="ltr">{{ $customer->phone }}</p>
                <div class="row text-center g-0 border-top pt-3">
                    <div class="col">
                        <div class="fw-bold fs-4">{{ $customer->total_visits }}</div>
                        <div class="small text-muted">زيارة</div>
                    </div>
                    <div class="col border-start">
                        <div class="fw-bold fs-4">{{ $bookings->count() }}</div>
                        <div class="small text-muted">حجز</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Notes --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white small fw-bold">ملاحظات</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="name" value="{{ $customer->name }}">
                    <textarea name="notes" class="form-control form-control-sm mb-2" rows="3"
                              placeholder="ملاحظات خاصة بهذه العميلة...">{{ $customer->notes }}</textarea>
                    <button class="btn btn-primary btn-sm w-100">حفظ</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-history text-primary me-2"></i>سجل الزيارات
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
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
                            <td class="text-muted small">{{ $booking->id }}</td>
                            <td class="small">{{ $booking->service->title }}</td>
                            <td class="small">{{ $booking->branch->name }}</td>
                            <td class="small">{{ $booking->staff?->name ?? '—' }}</td>
                            <td class="small">{{ $booking->appointment_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">لا توجد حجوزات مسجلة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
