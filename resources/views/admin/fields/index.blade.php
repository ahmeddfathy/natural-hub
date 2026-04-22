@extends('admin.layout')

@section('title', 'إدارة المجالات')
@section('page-title', 'إدارة المجالات')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
@endsection

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
            <i class="fas fa-sitemap"></i>
            <div>
                <h4>إدارة المجالات</h4>
                <p>إضافة وتعديل المجالات التي يرتبط بها المحتوى عبر سابقة الأعمال والفيديو</p>
            </div>
        </div>
        <a href="{{ route('admin.fields.create') }}" class="categories-banner-btn">
            <i class="fas fa-plus"></i>
            إضافة مجال جديد
        </a>
    </div>
</div>

<div class="categories-stats-grid">
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon total"><i class="fas fa-sitemap"></i></div>
        <span class="categories-stat-card-label">إجمالي المجالات</span>
        <span class="categories-stat-card-value">{{ $fields->total() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon active"><i class="fas fa-check-circle"></i></div>
        <span class="categories-stat-card-label">مجالات نشطة</span>
        <span class="categories-stat-card-value">{{ $fields->filter(fn($field) => $field->is_active)->count() }}</span>
    </div>
    <div class="categories-stat-card">
        <div class="categories-stat-card-icon inactive"><i class="fas fa-times-circle"></i></div>
        <span class="categories-stat-card-label">مجالات غير نشطة</span>
        <span class="categories-stat-card-value">{{ $fields->filter(fn($field) => !$field->is_active)->count() }}</span>
    </div>
</div>

<div class="categories-form-card">
    <div class="categories-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>قائمة المجالات</h5>
        <span class="categories-table-count">{{ $fields->total() }} مجال</span>
    </div>
    <div class="categories-table-wrapper">
        <table class="categories-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الترتيب</th>
                    <th>الربط</th>
                    <th>عدد الارتباطات</th>
                    <th>الوصف</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fields as $field)
                    <tr>
                        <td>{{ $field->name }}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm app-sort-order-input text-center mx-auto" data-id="{{ $field->id }}" data-model="Field" value="{{ $field->sort_order }}" style="width: 70px;">
                        </td>
                        <td><span class="category-slug-cell">{{ $field->slug }}</span></td>
                        <td>{{ $field->portfolios_count + $field->portfolio_categories_count + $field->video_categories_count }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($field->description, 50) ?: '—' }}</td>
                        <td>
                            <span class="category-status-badge {{ $field->is_active ? 'category-status-active' : 'category-status-inactive' }}">
                                {{ $field->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>
                            <div class="category-actions">
                                <a href="{{ route('admin.fields.edit', $field) }}" class="category-action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.fields.destroy', $field) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المجال؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="category-action-btn delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="categories-empty">
                                <h6>لا توجد مجالات بعد</h6>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fields->hasPages())
        <div class="categories-pagination">
            {{ $fields->links() }}
        </div>
    @endif
</div>
@endsection
