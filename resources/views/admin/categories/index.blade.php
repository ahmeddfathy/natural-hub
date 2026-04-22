@extends('admin.layout')

@section('title', 'إدارة الفئات')
@section('page-title', 'إدارة الفئات')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="categories-alert categories-alert-success admin-fade-in">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="categories-alert categories-alert-danger admin-fade-in">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Categories Banner -->
<div class="categories-banner admin-fade-in">
    <div class="categories-banner-top">
        <div class="categories-banner-title">
            <i class="fas fa-tags"></i>
            <div>
                <h4>إدارة الفئات</h4>
                <p>عرض وإدارة جميع فئات المحتوى</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="categories-banner-btn">
            <i class="fas fa-plus"></i>
            إضافة فئة جديدة
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="categories-stats-grid admin-fade-in" style="animation-delay: 0.05s;">
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon total">
            <i class="fas fa-tags"></i>
        </div>
        <span class="categories-stat-card-label">إجمالي الفئات</span>
        <span class="categories-stat-card-value">{{ $categories->total() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon active">
            <i class="fas fa-check-circle"></i>
        </div>
        <span class="categories-stat-card-label">فئات نشطة</span>
        <span class="categories-stat-card-value">{{ $categories->filter(fn($c) => $c->is_active)->count() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon inactive">
            <i class="fas fa-times-circle"></i>
        </div>
        <span class="categories-stat-card-label">فئات غير نشطة</span>
        <span class="categories-stat-card-value">{{ $categories->filter(fn($c) => !$c->is_active)->count() }}</span>
    </div>
</div>

<!-- Categories Table -->
<div class="categories-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="categories-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>جدول الفئات</h5>
        <span class="categories-table-count">{{ $categories->total() }} فئة</span>
    </div>
    <div class="categories-table-wrapper">
        <table class="categories-table">
            <thead>
                <tr>
                    <th><i class="fas fa-image"></i> الصورة</th>
                    <th><i class="fas fa-tag"></i> الاسم</th>
                    <th><i class="fas fa-sort"></i> الترتيب</th>
                    <th><i class="fas fa-link"></i> الرابط</th>
                    <th><i class="fas fa-align-left"></i> الوصف</th>
                    <th><i class="fas fa-toggle-on"></i> الحالة</th>
                    <th><i class="fas fa-cog"></i> الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="category-image-cell">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->image_alt ?: $category->name }}">
                            @else
                                <span class="category-image-placeholder"><i class="fas fa-image"></i></span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="category-name-cell">
                            <div class="category-name-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <span class="category-name-text">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm app-sort-order-input text-center mx-auto" data-id="{{ $category->id }}" data-model="Category" value="{{ $category->sort_order }}" style="width: 70px;">
                    </td>
                    <td>
                        <span class="category-slug-cell">
                            <i class="fas fa-link"></i>
                            {{ $category->slug }}
                        </span>
                    </td>
                    <td>
                        <span class="category-desc-cell">{{ Str::limit($category->description, 50) ?: '—' }}</span>
                    </td>
                    <td>
                        <span class="category-status-badge {{ $category->is_active ? 'category-status-active' : 'category-status-inactive' }}">
                            <i class="fas {{ $category->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td>
                        <div class="category-actions">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="category-action-btn edit" title="تعديل">
                                <i class="fas fa-edit"></i>
                                <span class="action-tooltip">تعديل</span>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفئة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="category-action-btn delete" title="حذف">
                                    <i class="fas fa-trash"></i>
                                    <span class="action-tooltip">حذف</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="categories-empty">
                            <div class="categories-empty-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h6>لا توجد فئات حالياً</h6>
                            <p>يمكنك إضافة فئة جديدة من خلال الزر أعلاه</p>
                            <a href="{{ route('admin.categories.create') }}" class="categories-empty-btn">
                                <i class="fas fa-plus"></i>
                                إضافة فئة جديدة
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="categories-pagination">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
