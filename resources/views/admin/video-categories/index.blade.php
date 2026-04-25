@extends('admin.layout')

@section('title', 'تصنيفات الفيديوهات')
@section('page-title', 'تصنيفات الفيديوهات')

@section('content')
@if(session('success'))
    <div class="categories-alert categories-alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="categories-alert categories-alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<div class="categories-banner">
    <div class="categories-banner-top">
        <div class="categories-banner-title">
            <i class="fas fa-layer-group"></i>
            <div>
                <h4>تصنيفات الفيديوهات</h4>
                <p>إدارة تصنيفات الفيديو مثل: ريلز أو فيديو طويل</p>
            </div>
        </div>
        <a href="{{ route('admin.video-categories.create') }}" class="categories-banner-btn">
            <i class="fas fa-plus"></i>
            إضافة تصنيف جديد
        </a>
    </div>
</div>

<div class="categories-stats-grid">
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon total"><i class="fas fa-layer-group"></i></div>
        <span class="categories-stat-card-label">إجمالي التصنيفات</span>
        <span class="categories-stat-card-value">{{ $categories->total() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon active"><i class="fas fa-check-circle"></i></div>
        <span class="categories-stat-card-label">تصنيفات نشطة</span>
        <span class="categories-stat-card-value">{{ $categories->filter(fn($c) => $c->is_active)->count() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon inactive"><i class="fas fa-times-circle"></i></div>
        <span class="categories-stat-card-label">تصنيفات غير نشطة</span>
        <span class="categories-stat-card-value">{{ $categories->filter(fn($c) => !$c->is_active)->count() }}</span>
    </div>
</div>

<div class="categories-form-card">
    <div class="categories-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>قائمة التصنيفات</h5>
        <span class="categories-table-count">{{ $categories->total() }} تصنيف</span>
    </div>
    <div class="categories-table-wrapper">
        <table class="categories-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الترتيب</th>
                    <th>الربط</th>
                    <th>عدد الفيديوهات</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm app-sort-order-input text-center mx-auto" data-id="{{ $category->id }}" data-model="VideoCategory" value="{{ $category->sort_order }}" style="width: 70px;">
                        </td>
                        <td><span class="category-slug-cell">{{ $category->slug }}</span></td>
                        <td>{{ $category->videos_count }}</td>
                        <td>
                            <span class="category-status-badge {{ $category->is_active ? 'category-status-active' : 'category-status-inactive' }}">
                                {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>
                            <div class="category-actions">
                                <a href="{{ route('admin.video-categories.edit', $category) }}" class="category-action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.video-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="category-action-btn delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="categories-empty">
                                <h6>لا توجد تصنيفات فيديوهات بعد</h6>
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
