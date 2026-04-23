@php $isEdit = isset($branch); @endphp

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas {{ $isEdit ? 'fa-edit' : 'fa-plus-circle' }} ic-branch"></i>
            <div>
                <h4>{{ $isEdit ? 'تعديل الفرع: ' . $branch->name : 'إضافة فرع جديد' }}</h4>
                <p>{{ $isEdit ? 'تحديث بيانات الفرع' : 'أضف فرع جديد للمركز' }}</p>
            </div>
        </div>
        <a href="{{ route('admin.branches.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.5rem 1.25rem;border-radius:10px;font-weight:700;font-size:.82rem;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;transition:.2s;">
            <i class="fas fa-arrow-right"></i> العودة
        </a>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-map-marker-alt"></i> بيانات الفرع</div>

    @if($errors->any())
        <div style="background:rgba(220,38,38,.06);color:#dc2626;border:1px solid rgba(220,38,38,.12);padding:1rem;border-radius:12px;margin-bottom:1.5rem;font-size:.88rem;">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('admin.branches.update', $branch) : route('admin.branches.store') }}">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم الفرع <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المدينة</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $branch->city ?? 'الإسكندرية') }}">
            </div>
            <div class="col-12">
                <label class="form-label">العنوان التفصيلي <span style="color:#dc2626;">*</span></label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $branch->address ?? '') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">رقم التليفون</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">واتساب</label>
                <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $branch->whatsapp ?? '') }}" placeholder="مثل: 201001234567">
            </div>
            <div class="col-md-2">
                <label class="form-label">يفتح</label>
                <input type="time" name="opens_at" class="form-control" value="{{ old('opens_at', $branch->opens_at ?? '10:00') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">يغلق</label>
                <input type="time" name="closes_at" class="form-control" value="{{ old('closes_at', $branch->closes_at ?? '22:00') }}">
            </div>
            <div class="col-12">
                <label class="form-label">رابط Google Maps</label>
                <input type="url" name="google_maps_url" class="form-control" value="{{ old('google_maps_url', $branch->google_maps_url ?? '') }}" placeholder="https://maps.google.com/...">
            </div>
            <div class="col-12">
                <label class="form-label">كود Iframe الخريطة <span style="font-size:.78rem;color:var(--text-muted);">(للعرض في صفحة التواصل)</span></label>
                <textarea name="iframe_url" class="form-control" rows="3" style="font-family:monospace;" placeholder="<iframe src=&quot;...&quot;></iframe>">{{ old('iframe_url', $branch->iframe_url ?? '') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">الترتيب</label>
                <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $branch->sort_order ?? 0) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $branch->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">فرع نشط</label>
                </div>
            </div>
            <div class="col-12" style="border-top:1px solid var(--border);padding-top:1rem;margin-top:.5rem;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('admin.branches.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.5rem 1.25rem;border-radius:10px;font-weight:700;font-size:.82rem;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;">
                    <i class="fas fa-arrow-right"></i> رجوع
                </a>
                <button type="submit" class="ops-banner-btn">
                    <i class="fas fa-save"></i>
                    {{ $isEdit ? 'حفظ التعديلات' : 'إضافة الفرع' }}
                </button>
            </div>
        </div>
    </form>
</div>
