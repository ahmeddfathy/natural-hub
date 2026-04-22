@extends('admin.layout')

@section('title', 'تعديل تصنيف فيديو')
@section('page-title', 'تعديل تصنيف فيديو')

@section('content')
<div class="categories-page-banner">
    <div class="categories-page-banner-content">
        <i class="fas fa-edit"></i>
        <div>
            <h4>تعديل التصنيف: {{ $videoCategory->name }}</h4>
            <p>تحديث بيانات التصنيف وربطه بالمجالات المناسبة</p>
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
        <form action="{{ route('admin.video-categories.update', $videoCategory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">اسم التصنيف *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $videoCategory->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">الربط المخصص</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $videoCategory->slug) }}">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">الوصف</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $videoCategory->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $videoCategory->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">نشط</label>
            </div>

            @include('admin.partials.fields-picker', [
                'fields' => $fields,
                'selectedFieldIds' => old('field_ids', $videoCategory->fields->pluck('id')->all()),
            ])

            <div class="mb-3">
                <label class="form-label">صورة التصنيف</label>
                @if($videoCategory->image)
                    <div class="category-form-image-preview mb-3">
                        <img src="{{ asset('storage/' . $videoCategory->image) }}" alt="{{ $videoCategory->image_alt ?: $videoCategory->name }}">
                    </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">النص البديل للصورة</label>
                <input type="text" class="form-control @error('image_alt') is-invalid @enderror" name="image_alt" value="{{ old('image_alt', $videoCategory->image_alt) }}">
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
