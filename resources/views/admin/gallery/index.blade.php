@extends('admin.layout')
@section('title', 'معرض الصور')
@section('page-title', 'إدارة معرض الصور')

@section('content')
@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif

<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center"><div class="card-body">
        <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
        <div class="small text-muted">إجمالي الصور</div>
    </div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center"><div class="card-body">
        <div class="fs-2 fw-bold text-success">{{ $stats['active'] }}</div>
        <div class="small text-muted">صور ظاهرة</div>
    </div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center"><div class="card-body">
        <div class="fs-2 fw-bold text-info">{{ $stats['before_after'] }}</div>
        <div class="small text-muted">قبل/بعد</div>
    </div></div></div>
</div>

{{-- Upload Form --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-upload text-primary me-2"></i> رفع صور جديدة
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">الصور <span class="text-danger">*</span></label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <div class="form-text">يمكنك رفع أكثر من صورة في نفس الوقت</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">القسم <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تعليق (اختياري)</label>
                    <input type="text" name="caption" class="form-control" placeholder="تعليق الصورة...">
                </div>
                <div class="col-md-1 d-flex align-items-center gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_before_after" id="beforeAfter" value="1">
                        <label class="form-check-label small" for="beforeAfter">قبل/بعد</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-upload"></i> رفع
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="mb-3 d-flex gap-2 flex-wrap">
    @foreach(['' => 'الكل'] + $categories as $key => $label)
        <a href="{{ route('admin.gallery.index', $key ? ['category' => $key] : []) }}"
           class="btn btn-sm {{ request('category') == $key ? 'btn-primary' : 'btn-outline-secondary' }}">
            {{ $label }}
        </a>
    @endforeach
</form>

{{-- Images Grid --}}
<div class="row g-3">
    @forelse($images as $img)
    <div class="col-6 col-md-3 col-lg-2">
        <div class="card border-0 shadow-sm h-100 {{ !$img->is_active ? 'opacity-50' : '' }}">
            <div class="position-relative">
                <img src="{{ $img->full_url }}" alt="{{ $img->alt }}"
                     class="card-img-top" style="height:130px;object-fit:cover;">
                @if($img->is_before_after)
                    <span class="position-absolute top-0 start-0 badge bg-warning m-1 small">قبل/بعد</span>
                @endif
                <span class="position-absolute top-0 end-0 badge bg-dark m-1 small">{{ $img->category }}</span>
            </div>
            <div class="card-body p-2">
                @if($img->caption)
                    <p class="small text-muted mb-2 text-truncate">{{ $img->caption }}</p>
                @endif
                <div class="d-flex gap-1 justify-content-center">
                    <form method="POST" action="{{ route('admin.gallery.toggle-status', $img) }}">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-{{ $img->is_active ? 'outline-warning' : 'outline-success' }} p-1"
                                style="font-size:0.7rem" title="{{ $img->is_active ? 'إخفاء' : 'إظهار' }}">
                            <i class="fas fa-{{ $img->is_active ? 'eye-slash' : 'eye' }}"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}"
                          onsubmit="return confirm('حذف الصورة نهائياً؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger p-1" style="font-size:0.7rem" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-images fa-3x mb-3 d-block"></i>
        لا توجد صور في هذا القسم
    </div>
    @endforelse
</div>

@if($images->hasPages())
<div class="mt-4">{{ $images->withQueryString()->links() }}</div>
@endif
@endsection
