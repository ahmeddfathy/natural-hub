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

{{-- Upload Form --}}
<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-upload"></i> رفع صور جديدة</div>
    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">الصور <span style="color:#dc2626;">*</span></label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                <div class="form-text" style="font-size:.75rem;color:var(--text-muted);">يمكنك رفع أكثر من صورة</div>
            </div>
            <div class="col-md-3">
                <label class="form-label">القسم <span style="color:#dc2626;">*</span></label>
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
            <div class="col-md-1 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_before_after" id="beforeAfter" value="1">
                    <label class="form-check-label small" for="beforeAfter">قبل/بعد</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="ops-banner-btn" style="width:100%;justify-content:center;padding:.5rem;">
                    <i class="fas fa-upload"></i>
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Category Filter --}}
<div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    @foreach(['' => 'الكل'] + $categories as $key => $label)
        <a href="{{ route('admin.gallery.index', $key ? ['category' => $key] : []) }}"
           style="padding:6px 16px;border-radius:10px;font-size:.82rem;font-weight:700;text-decoration:none;transition:.2s;
                  {{ request('category') == $key ? 'background:linear-gradient(135deg,var(--accent),var(--accent-light));color:#000;' : 'background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Images Grid --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;">
    @forelse($images as $img)
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:transform .25s;{{ !$img->is_active ? 'opacity:.5;' : '' }}"
         onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
        <div style="position:relative;height:140px;overflow:hidden;">
            <img src="{{ $img->full_url }}" alt="{{ $img->alt }}" style="width:100%;height:100%;object-fit:cover;">
            @if($img->is_before_after)
                <span style="position:absolute;top:8px;left:8px;padding:3px 8px;border-radius:6px;font-size:.65rem;font-weight:700;background:rgba(245,158,11,.9);color:#000;">قبل/بعد</span>
            @endif
            <span style="position:absolute;top:8px;right:8px;padding:3px 8px;border-radius:6px;font-size:.65rem;font-weight:700;background:rgba(0,0,0,.6);color:#fff;backdrop-filter:blur(4px);">{{ $img->category }}</span>
        </div>
        <div style="padding:.75rem;">
            @if($img->caption)
                <p style="font-size:.78rem;color:var(--text-muted);margin:0 0 .5rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $img->caption }}</p>
            @endif
            <div class="ops-actions" style="justify-content:center;">
                <form method="POST" action="{{ route('admin.gallery.toggle-status', $img) }}">
                    @csrf
                    <button type="submit" class="ops-action-btn toggle" title="{{ $img->is_active ? 'إخفاء' : 'إظهار' }}" style="width:28px;height:28px;font-size:.72rem;">
                        <i class="fas fa-{{ $img->is_active ? 'eye-slash' : 'eye' }}"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}" onsubmit="return confirm('حذف الصورة نهائياً؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="ops-action-btn delete" title="حذف" style="width:28px;height:28px;font-size:.72rem;">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;">
        <div class="ops-empty">
            <div class="ops-empty-icon"><i class="fas fa-images"></i></div>
            <h6>لا توجد صور في هذا القسم</h6>
        </div>
    </div>
    @endforelse
</div>

@if($images->hasPages())
<div class="ops-pagination" style="margin-top:1.5rem;">{{ $images->withQueryString()->links() }}</div>
@endif
@endsection
