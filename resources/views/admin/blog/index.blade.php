@extends('admin.layout')

@section('title', 'إدارة المقالات')
@section('page-title', 'إدارة المقالات')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="blogs-alert blogs-alert-success admin-fade-in">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="blogs-alert blogs-alert-danger admin-fade-in">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Blogs Banner -->
<div class="blogs-banner admin-fade-in">
    <div class="blogs-banner-top">
        <div class="blogs-banner-title">
            <i class="fas fa-newspaper"></i>
            <div>
                <h4>إدارة المقالات</h4>
                <p>عرض وإدارة جميع المقالات والمدونات</p>
            </div>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="blogs-banner-btn">
            <i class="fas fa-plus"></i>
            إنشاء مقال جديد
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="blogs-stats-grid admin-fade-in" style="animation-delay: 0.05s;">
    <div class="blogs-stat-card">
        <div class="blogs-stat-card-icon total">
            <i class="fas fa-newspaper"></i>
        </div>
        <span class="blogs-stat-card-label">إجمالي المقالات</span>
        <span class="blogs-stat-card-value">{{ $blogs->total() }}</span>
    </div>
    <div class="blogs-stat-card">
        <div class="blogs-stat-card-icon published">
            <i class="fas fa-check-circle"></i>
        </div>
        <span class="blogs-stat-card-label">منشورة</span>
        <span class="blogs-stat-card-value">{{ $blogs->where('is_published', true)->count() }}</span>
    </div>
    <div class="blogs-stat-card">
        <div class="blogs-stat-card-icon drafts">
            <i class="fas fa-edit"></i>
        </div>
        <span class="blogs-stat-card-label">مسودات</span>
        <span class="blogs-stat-card-value">{{ $blogs->where('is_published', false)->count() }}</span>
    </div>
</div>

<!-- Filter Card -->
<div class="blogs-filter-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="blogs-filter-header">
        <i class="fas fa-filter"></i>
        <h5>تصفية المقالات</h5>
    </div>
    <div class="blogs-filter-body">
        <form action="{{ route('admin.blogs.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="category_id" class="form-label">التصنيف</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">جميع التصنيفات</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منشورة</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="date_from" class="form-label">من تاريخ</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div class="col-md-3">
                <label for="date_to" class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="col-12 mt-3 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.blogs.index') }}" class="blogs-filter-btn blogs-filter-btn-reset">
                    <i class="fas fa-redo"></i>
                    إعادة ضبط
                </a>
                <button type="submit" class="blogs-filter-btn blogs-filter-btn-apply">
                    <i class="fas fa-filter"></i>
                    تطبيق الفلتر
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Blogs Table -->
<div class="blogs-form-card admin-fade-in" style="animation-delay: 0.2s;">
    <div class="blogs-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>قائمة المقالات</h5>
        <span class="blogs-table-count">{{ $blogs->total() }} مقال</span>
        <div class="blogs-search-box" style="margin-left: 0; margin-right: auto;">
            <i class="fas fa-search"></i>
            <input type="text" id="postSearchInput" placeholder="بحث في المقالات...">
        </div>
    </div>
    <div class="blogs-table-wrapper">
        <table class="blogs-table" id="postsTable">
            <thead>
                <tr>
                    <th><i class="fas fa-heading"></i> العنوان</th>
                    <th><i class="fas fa-tags"></i> التصنيف</th>
                    <th><i class="fas fa-toggle-on"></i> الحالة</th>
                    <th><i class="fas fa-calendar-alt"></i> تاريخ النشر</th>
                    <th><i class="fas fa-cog"></i> الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr>
                    <td>
                        <div class="blog-info-cell">
                            <div class="blog-info-thumbnail">
                                @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                                @else
                                <div class="blog-info-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                @endif
                            </div>
                            <div class="blog-info-details">
                                <span class="blog-info-title">{{ $blog->title }}</span>
                                @if($blog->is_external)
                                    <span class="blog-external-badge">
                                        <i class="fas fa-external-link-alt"></i> خارجي
                                    </span>
                                @endif
                                <span class="blog-info-excerpt">{{ Str::limit($blog->excerpt, 50) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($blog->category)
                        <span class="blog-category-badge">
                            <i class="fas fa-tag"></i>
                            {{ $blog->category->name }}
                        </span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="blog-status-badge {{ $blog->is_published ? 'blog-status-published' : 'blog-status-draft' }}">
                            <i class="fas {{ $blog->is_published ? 'fa-check-circle' : 'fa-clock' }}"></i>
                            {{ $blog->is_published ? 'منشور' : 'مسودة' }}
                        </span>
                    </td>
                    <td>
                        @if($blog->published_at)
                        <div class="blog-date-cell">
                            <i class="fas fa-calendar-day"></i>
                            <span>{{ $blog->published_at->format('M j, Y') }}</span>
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="blog-actions">
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="blog-action-btn edit" title="تعديل">
                                <i class="fas fa-edit"></i>
                                <span class="action-tooltip">تعديل</span>
                            </a>
                            <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="blog-action-btn {{ $blog->is_published ? 'unpublish' : 'publish' }}"
                                    title="{{ $blog->is_published ? 'تحويل لمسودة' : 'نشر' }}">
                                    <i class="fas {{ $blog->is_published ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                    <span class="action-tooltip">{{ $blog->is_published ? 'تحويل لمسودة' : 'نشر' }}</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="blog-action-btn delete" onclick="return confirm('هل أنت متأكد من حذف هذا المقال؟')" title="حذف">
                                    <i class="fas fa-trash"></i>
                                    <span class="action-tooltip">حذف</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="blogs-empty">
                            <div class="blogs-empty-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h6>لا يوجد مقالات حالياً</h6>
                            <p>يمكنك إنشاء مقال جديد من خلال الزر أعلاه</p>
                            <a href="{{ route('admin.blogs.create') }}" class="blogs-empty-btn">
                                <i class="fas fa-plus"></i>
                                إنشاء مقال جديد
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
    <div class="blogs-pagination">
        {{ $blogs->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
@endsection
