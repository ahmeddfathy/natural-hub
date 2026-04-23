@extends('admin.layout')
@section('title', 'حجز يدوي جديد')
@section('page-title', 'إضافة حجز يدوي')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/bookings.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="bk-back-btn">
        <i class="fas fa-arrow-right"></i> العودة
    </a>
</div>

<div class="bk-detail-panel">
    <div class="bk-detail-header"><i class="fas fa-calendar-plus"></i> بيانات الحجز الجديد</div>

    @if($errors->any())
        <div style="background:rgba(220,38,38,.06);color:#dc2626;border:1px solid rgba(220,38,38,.12);padding:1rem;border-radius:12px;margin-bottom:1.5rem;font-size:.88rem;">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div style="background:rgba(56,189,248,.06);border:1px solid rgba(56,189,248,.12);padding:.85rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.85rem;color:#38bdf8;display:flex;align-items:center;gap:.5rem;">
        <i class="fas fa-info-circle"></i>
        أدخلي رقم الموبايل وسيظهر اسم العميلة تلقائياً إن كانت مسجلة مسبقاً.
    </div>

    <form method="POST" action="{{ route('admin.bookings.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">رقم الموبايل <span style="color:#dc2626;">*</span></label>
                <input type="text" name="phone" id="phoneInput" class="form-control"
                       value="{{ old('phone') }}" placeholder="01xxxxxxxxx"
                       oninput="lookupCustomer(this.value)">
            </div>
            <div class="col-md-4">
                <label class="form-label">اسم العميلة <span style="color:#dc2626;">*</span></label>
                <input type="text" name="customer_name" id="customerName" class="form-control"
                       value="{{ old('customer_name') }}" placeholder="سيظهر تلقائياً أو اكتبيه">
                <div id="customerHint" class="form-text" style="color:#059669;font-size:.78rem;margin-top:4px;"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label">الفرع <span style="color:#dc2626;">*</span></label>
                <select name="branch_id" class="form-select" onchange="filterStaff(this.value)" required>
                    <option value="">اختاري الفرع...</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">الخدمة <span style="color:#dc2626;">*</span></label>
                <select name="service_id" class="form-select" required>
                    <option value="">اختاري الخدمة...</option>
                    @foreach($services->groupBy('category_type') as $cat => $items)
                        <optgroup label="{{ $cat }}">
                            @foreach($items as $s)
                                <option value="{{ $s->id }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->title }} {{ $s->price_label ? '('.$s->price_label.')' : '' }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الموظفة (اختياري)</label>
                <select name="staff_id" class="form-select" id="staffSelect">
                    <option value="">ستُعيَّن لاحقاً</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}" data-branch="{{ $s->branch_id }}"
                                {{ old('staff_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->branch->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">تاريخ ووقت الموعد <span style="color:#dc2626;">*</span></label>
                <input type="datetime-local" name="appointment_at" class="form-control"
                       value="{{ old('appointment_at') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"
                          placeholder="أي ملاحظات خاصة بالجلسة...">{{ old('notes') }}</textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="bk-banner-btn" style="margin-top:.5rem;">
                    <i class="fas fa-calendar-plus"></i> إضافة الحجز
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
let lookupTimer;
function lookupCustomer(phone) {
    clearTimeout(lookupTimer);
    if (phone.length < 10) return;
    lookupTimer = setTimeout(() => {
        fetch('{{ route("admin.bookings.lookup-customer") }}?phone=' + encodeURIComponent(phone), {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.found) {
                document.getElementById('customerName').value = data.name;
                document.getElementById('customerHint').textContent =
                    `عميلة مسجلة — ${data.total_visits} زيارة سابقة`;
            } else {
                document.getElementById('customerHint').textContent = 'عميلة جديدة';
            }
        });
    }, 500);
}

function filterStaff(branchId) {
    document.querySelectorAll('#staffSelect option[data-branch]').forEach(opt => {
        opt.hidden = branchId && opt.dataset.branch !== branchId;
    });
}
</script>
@endsection
