@extends('admin.layout')
@section('title', 'مكتبة الفيديوهات')
@section('page-title', 'مكتبة الفيديوهات')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fab fa-youtube" style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;"></i>
            <div>
                <h4>مكتبة الفيديوهات</h4>
                <p>{{ $stats['total'] }} فيديو — {{ $stats['published'] }} منشور</p>
            </div>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="ops-banner-btn">
            <i class="fas fa-plus"></i> إضافة فيديو
        </a>
    </div>
</div>

<div class="ops-stats-grid">
    <div class="ops-stat-card" style="animation-delay:.05s"><div class="ops-stat-icon ic-total"><i class="fab fa-youtube"></i></div><div class="ops-stat-value">{{ $stats['total'] }}</div><div class="ops-stat-label">الإجمالي</div></div>
    <div class="ops-stat-card" style="animation-delay:.1s"><div class="ops-stat-icon ic-active"><i class="fas fa-check-circle"></i></div><div class="ops-stat-value">{{ $stats['published'] }}</div><div class="ops-stat-label">منشور</div></div>
    <div class="ops-stat-card" style="animation-delay:.15s"><div class="ops-stat-icon ic-leave"><i class="fas fa-edit"></i></div><div class="ops-stat-value">{{ $stats['drafts'] }}</div><div class="ops-stat-label">مسودة</div></div>
    <div class="ops-stat-card" style="animation-delay:.2s"><div class="ops-stat-icon" style="background:rgba(245,158,11,.12);color:#d97706;"><i class="fas fa-star"></i></div><div class="ops-stat-value">{{ $stats['featured'] }}</div><div class="ops-stat-label">مميز</div></div>
</div>

{{-- Filters --}}
<div class="ops-filter-card">
    <div class="ops-filter-header"><i class="fas fa-filter"></i><h5>تصفية</h5></div>
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small">القسم</label>
            <select name="category" class="form-select">
                <option value="">كل الأقسام</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">الخدمة</label>
            <select name="service_id" class="form-select">
                <option value="">كل الخدمات</option>
                @foreach($services as $s)
                    <option value="{{ $s->id }}" {{ request('service_id') == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="published" {{ request('status')=='published' ? 'selected':'' }}>منشور</option>
                <option value="draft" {{ request('status')=='draft' ? 'selected':'' }}>مسودة</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">بحث</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="عنوان الفيديو...">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="ops-banner-btn flex-fill" style="padding:.5rem;font-size:.82rem;">فلترة</button>
            <a href="{{ route('admin.videos.index') }}" style="padding:.5rem .75rem;border-radius:10px;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;display:inline-flex;align-items:center;"><i class="fas fa-times"></i></a>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="ops-table-card">
    <div class="ops-table-header"><i class="fas fa-list-ul"></i><h5>جدول الفيديوهات</h5></div>
    <div class="table-responsive">
        <table class="ops-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>القسم</th>
                    <th>الخدمة</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videos as $video)
                <tr>
                    <td>
                        @if($video->youtube_video_id)
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_video_id }}/default.jpg" alt="{{ $video->title }}" style="width:80px;height:45px;object-fit:cover;border-radius:8px;">
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:700;color:var(--text-main);display:block;">{{ $video->title }}</span>
                        @if($video->is_featured)<span class="ops-badge" style="background:rgba(245,158,11,.1);color:#d97706;">مميز</span>@endif
                        @if($video->is_portrait)<span class="ops-badge" style="background:rgba(56,189,248,.1);color:#38bdf8;">رأسي</span>@endif
                    </td>
                    <td><span class="ops-badge ops-badge-neutral">{{ $video->category_type }}</span></td>
                    <td style="font-size:.82rem;">{{ $video->service?->title ?? '—' }}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm app-sort-order-input text-center" data-id="{{ $video->id }}" data-model="Video" value="{{ $video->sort_order }}" style="width:70px;">
                    </td>
                    <td>
                        <span class="ops-badge {{ $video->is_published ? 'ops-badge-active' : 'ops-badge-inactive' }}">
                            <i class="fas {{ $video->is_published ? 'fa-check' : 'fa-clock' }}"></i>
                            {{ $video->is_published ? 'منشور' : 'مسودة' }}
                        </span>
                    </td>
                    <td>
                        <div class="ops-actions">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="ops-action-btn edit" title="تعديل"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.videos.toggle-status', $video) }}">@csrf
                                <button class="ops-action-btn toggle" title="{{ $video->is_published ? 'إيقاف' : 'نشر' }}"><i class="fas fa-toggle-{{ $video->is_published ? 'on' : 'off' }}"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" onsubmit="return confirm('حذف الفيديو؟')">@csrf @method('DELETE')
                                <button class="ops-action-btn delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="ops-empty">
                            <div class="ops-empty-icon"><i class="fab fa-youtube"></i></div>
                            <h6>لا توجد فيديوهات</h6>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($videos->hasPages())
    <div class="ops-pagination">{{ $videos->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
