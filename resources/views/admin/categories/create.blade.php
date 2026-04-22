@extends('admin.layout')

@section('title', 'إضافة فئة جديدة')
@section('page-title', 'إضافة فئة جديدة')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
@endsection

@section('content')
<!-- Page Banner -->
<div class="categories-page-banner admin-fade-in">
    <div class="categories-page-banner-content">
        <i class="fas fa-plus-circle"></i>
        <div>
            <h4>إضافة فئة جديدة</h4>
            <p>إنشاء فئة جديدة لتنظيم المحتوى</p>
        </div>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="categories-banner-back-btn">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>
</div>

<!-- Form Card -->
<div class="categories-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="categories-form-header">
        <i class="fas fa-tag"></i>
        <h5>بيانات الفئة</h5>
    </div>
    <div class="categories-form-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="name" class="form-label">اسم الفئة <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="أدخل اسم الفئة"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label d-block">الحالة</label>
                    <div class="categories-switch-card">
                        <label class="form-check form-switch mb-0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }} class="form-check-input">
                            <span class="categories-switch-label">فئة نشطة</span>
                        </label>
                        <div class="categories-switch-hint">الفئات النشطة فقط ستظهر في الموقع</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">وصف الفئة</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="4"
                              placeholder="أدخل وصفاً مختصراً عن محتوى هذه الفئة">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">صورة الفئة</label>
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           id="image"
                           name="image"
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="image_alt" class="form-label">النص البديل للصورة</label>
                    <input type="text"
                           class="form-control @error('image_alt') is-invalid @enderror"
                           id="image_alt"
                           name="image_alt"
                           value="{{ old('image_alt') }}"
                           placeholder="وصف مختصر لصورة الفئة">
                    @error('image_alt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="sort_order" class="form-label">الترتيب <span class="text-danger">*</span></label>
                    <input type="number" 
                           class="form-control @error('sort_order') is-invalid @enderror" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}" 
                           placeholder="أدخل ترتيب الظهور (مثال: 1, 2, 3...)"
                           required>
                    <div class="form-text">الأرقام الأقل تظهر أولاً (مثال: 0 يظهر قبل 1).</div>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <hr class="categories-form-divider">

            <div class="categories-form-actions">
                <a href="{{ route('admin.categories.index') }}" class="categories-back-btn">
                    <i class="fas fa-arrow-right"></i>
                    رجوع
                </a>
                <button type="submit" class="categories-save-btn">
                    <i class="fas fa-save"></i>
                    حفظ الفئة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
