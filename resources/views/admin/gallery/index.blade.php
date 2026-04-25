@extends('admin.layout')
@section('title', 'معرض الصور')
@section('page-title', 'إدارة معرض الصور')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-images ic-gallery"></i>
            <div>
                <h4>معرض الصور</h4>
                <p>إدارة صور المعرض والأعمال</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-stats-grid">
    <div class="ops-stat-card" style="animation-delay:.05s">
        <div class="ops-stat-icon ic-total"><i class="fas fa-images"></i></div>
        <div class="ops-stat-value">{{ $stats['total'] }}</div>
        <div class="ops-stat-label">إجمالي الصور</div>
    </div>
    <div class="ops-stat-card" style="animation-delay:.1s">
        <div class="ops-stat-icon ic-active"><i class="fas fa-eye"></i></div>
        <div class="ops-stat-value">{{ $stats['active'] }}</div>
        <div class="ops-stat-label">صور ظاهرة</div>
    </div>
    <div class="ops-stat-card" style="animation-delay:.15s">
        <div class="ops-stat-icon ic-new"><i class="fas fa-exchange-alt"></i></div>
        <div class="ops-stat-value">{{ $stats['before_after'] }}</div>
        <div class="ops-stat-label">قبل/بعد</div>
    </div>
</div>

<div class="ops-detail-panel gallery-upload-panel">
    <div class="ops-detail-header"><i class="fas fa-upload"></i> رفع صور جديدة</div>
    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="gallery-upload-grid">
            <div class="gallery-field gallery-field--file">
                <label class="form-label">الصور <span class="text-danger">*</span></label>
                <input type="file" name="images[]" class="form-control gallery-file-input" accept="image/*" multiple required>
                <div class="form-text">يمكنك رفع أكثر من صورة</div>
            </div>
            <div class="gallery-field">
                <label class="form-label">القسم <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="gallery-field">
                <label class="form-label">تعليق (اختياري)</label>
                <input type="text" name="caption" class="form-control" placeholder="تعليق الصورة...">
            </div>
            <div class="gallery-field gallery-check-wrap">
                <div class="form-check gallery-check">
                    <input class="form-check-input" type="checkbox" name="is_before_after" id="beforeAfter" value="1">
                    <label class="form-check-label" for="beforeAfter">قبل/بعد</label>
                </div>
            </div>
            <div class="gallery-field gallery-submit-wrap">
                <button type="submit" class="gallery-upload-btn" title="رفع">
                    <i class="fas fa-upload"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="gallery-filter-tabs">
    @foreach(['' => 'الكل'] + $categories as $key => $label)
        <a href="{{ route('admin.gallery.index', $key ? ['category' => $key] : []) }}"
           class="gallery-filter-tab {{ request('category') == $key ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="gallery-grid">
    @forelse($images as $img)
    <div class="gallery-card {{ !$img->is_active ? 'is-muted' : '' }}">
        <div class="gallery-thumb">
            <img src="{{ $img->full_url }}" alt="{{ $img->alt }}">
            @if($img->is_before_after)
                <span class="gallery-badge gallery-badge--compare">قبل/بعد</span>
            @endif
            <span class="gallery-badge gallery-badge--category">{{ $img->category }}</span>
        </div>
        <div class="gallery-card-body">
            @if($img->caption)
                <p class="gallery-caption">{{ $img->caption }}</p>
            @endif
            <div class="ops-actions gallery-actions">
                <form method="POST" action="{{ route('admin.gallery.toggle-status', $img) }}">
                    @csrf
                    <button type="submit" class="ops-action-btn toggle" title="{{ $img->is_active ? 'إخفاء' : 'إظهار' }}">
                        <i class="fas fa-{{ $img->is_active ? 'eye-slash' : 'eye' }}"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}" onsubmit="return confirm('حذف الصورة نهائيا؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="ops-action-btn delete" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="gallery-empty-wrap">
        <div class="gallery-empty-state">
            <div class="gallery-empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h5>لا توجد صور في هذا القسم</h5>
            <p>ارفعي صورك من الأعلى وستظهر هنا فوراً</p>
        </div>
    </div>
    @endforelse
</div>

@if($images->hasPages())
<div class="ops-pagination gallery-pagination">{{ $images->withQueryString()->links() }}</div>
@endif
@endsection
