@extends('admin.layout')

@section('title', 'إضافة تصنيف فيديو')
@section('page-title', 'إضافة تصنيف فيديو')

@section('content')
<div class="categories-page-banner">
    <div class="categories-page-banner-content">
        <i class="fas fa-plus-circle"></i>
        <div>
            <h4>إضافة تصنيف فيديو جديد</h4>
            <p>أنشئ تصنيفًا مثل: ريلز أو فيديو طويل، ثم اربطه بالمجالات المناسبة.</p>
        </div>
    </div>
    <a href="{{ route('admin.video-categories.index') }}" class="categories-banner-back-btn">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>
</div>

<div class="categories-form-card">
    <div class="categories-form-header">
        <i class="fas fa-layer-group"></i>
        <h5>بيانات التصنيف</h5>
    </div>
    <div class="categories-form-body">
        <form action="{{ route('admin.video-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">اسم التصنيف *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">الربط المخصص</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">الوصف</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label">نشط</label>
            </div>

            @include('admin.partials.fields-picker', [
                'fields' => $fields,
                'selectedFieldIds' => old('field_ids', []),
            ])

            <div class="mb-3">
                <label class="form-label">صورة التصنيف</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">النص البديل للصورة</label>
                <input type="text" class="form-control @error('image_alt') is-invalid @enderror" name="image_alt" value="{{ old('image_alt') }}">
                @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="categories-form-actions">
                <a href="{{ route('admin.video-categories.index') }}" class="categories-back-btn">رجوع</a>
                <button type="submit" class="categories-save-btn">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
