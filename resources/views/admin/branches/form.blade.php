@extends('admin.layout')
@section('title', isset($branch) ? 'تعديل فرع' : 'إضافة فرع')
@section('page-title', isset($branch) ? 'تعديل: ' . $branch->name : 'إضافة فرع جديد')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> العودة
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ isset($branch) ? route('admin.branches.update', $branch) : route('admin.branches.store') }}">
            @csrf
            @if(isset($branch)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الفرع <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $branch->city ?? 'الإسكندرية') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">العنوان التفصيلي <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $branch->address ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">رقم التليفون</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">واتساب</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $branch->whatsapp ?? '') }}"
                           placeholder="مثل: 201001234567">
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
                    <input type="url" name="google_maps_url" class="form-control" value="{{ old('google_maps_url', $branch->google_maps_url ?? '') }}"
                           placeholder="https://maps.google.com/...">
                </div>
                <div class="col-12">
                    <label class="form-label">كود Iframe الخريطة <span class="text-muted small">(للعرض في صفحة التواصل)</span></label>
                    <textarea name="iframe_url" class="form-control font-monospace" rows="3"
                              placeholder="<iframe src=&quot;...&quot;></iframe>">{{ old('iframe_url', $branch->iframe_url ?? '') }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="sort_order" class="form-control" min="0"
                           value="{{ old('sort_order', $branch->sort_order ?? 0) }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $branch->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label">فرع نشط</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        {{ isset($branch) ? 'حفظ التعديلات' : 'إضافة الفرع' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
