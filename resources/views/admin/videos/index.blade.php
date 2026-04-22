@extends('admin.layout')
@section('title', 'مكتبة الفيديوهات')
@section('page-title', 'مكتبة الفيديوهات')

@section('content')
@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0"><i class="fab fa-youtube text-danger me-2"></i>مكتبة الفيديوهات</h4>
        <p class="text-muted small mb-0">{{ $stats['total'] }} فيديو — {{ $stats['published'] }} منشور</p>
    </div>
    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إضافة فيديو
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold">{{ $stats['total'] }}</div><div class="small text-muted">الإجمالي</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-success">{{ $stats['published'] }}</div><div class="small text-muted">منشور</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-warning">{{ $stats['drafts'] }}</div><div class="small text-muted">مسودة</div>
        </div></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-primary">{{ $stats['featured'] }}</div><div class="small text-muted">مميز</div>
        </div></div>
    </div>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">القسم</label>
                <select name="category" class="form-select form-select-sm">
                    <option value="">كل الأقسام</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">الخدمة</label>
                <select name="service_id" class="form-select form-select-sm">
                    <option value="">كل الخدمات</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" {{ request('service_id') == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">الحالة</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">الكل</option>
                    <option value="published" {{ request('status')=='published' ? 'selected':'' }}>منشور</option>
                    <option value="draft" {{ request('status')=='draft' ? 'selected':'' }}>مسودة</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">بحث</label>
                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="عنوان الفيديو...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary btn-sm flex-fill">فلترة</button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>الصورة المصغرة</th>
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
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_video_id }}/default.jpg"
                                 alt="{{ $video->title }}" class="rounded" width="80" height="45" style="object-fit:cover;">
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $video->title }}</div>
                        @if($video->is_featured)
                            <span class="badge bg-warning text-dark small">مميز</span>
                        @endif
                        @if($video->is_portrait)
                            <span class="badge bg-info text-white small">رأسي</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $video->category_type }}</span>
                    </td>
                    <td class="small text-muted">{{ $video->service?->title ?? '—' }}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm app-sort-order-input text-center"
                               data-id="{{ $video->id }}" data-model="Video"
                               value="{{ $video->sort_order }}" style="width:70px">
                    </td>
                    <td>
                        <span class="badge {{ $video->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $video->is_published ? 'منشور' : 'مسودة' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.videos.toggle-status', $video) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-{{ $video->is_published ? 'warning' : 'success' }}">
                                    <i class="fas fa-toggle-{{ $video->is_published ? 'on' : 'off' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.videos.destroy', $video) }}"
                                  onsubmit="return confirm('حذف الفيديو؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fab fa-youtube fa-2x mb-2 d-block"></i>
                        لا توجد فيديوهات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($videos->hasPages())
    <div class="card-footer">{{ $videos->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
