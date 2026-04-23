@extends('admin.layout')
@section('title', 'إدارة المتجر')
@section('page-title', 'إدارة المتجر')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-shopping-bag" style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;"></i>
            <div>
                <h4>المتجر</h4>
                <p>{{ $stats['bundles'] }} مجموعة — {{ $stats['products'] }} منتج — <span style="color:#dc2626;">{{ $stats['out_of_stock'] }} نفذت</span></p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.shop.products.create') }}" class="ops-banner-btn" style="background:var(--bg-body);color:var(--text-secondary) !important;border:1px solid var(--border);">
                <i class="fas fa-plus"></i> منتج
            </a>
            <a href="{{ route('admin.shop.bundles.create') }}" class="ops-banner-btn">
                <i class="fas fa-plus"></i> مجموعة
            </a>
        </div>
    </div>
</div>

{{-- Bundles --}}
@if($bundles->count())
<div style="margin-bottom:2rem;">
    <h5 style="font-weight:800;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
        <i class="fas fa-box-open" style="color:var(--accent);"></i> المجموعات
    </h5>
    <div class="row g-3">
        @foreach($bundles as $bundle)
        <div class="col-md-6 col-lg-4">
            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:18px;overflow:hidden;transition:transform .25s, box-shadow .25s;height:100%;box-shadow:0 1px 3px rgba(0,0,0,.04);"
                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(0,0,0,.08)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'">
                @if($bundle->image)
                    <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}" style="width:100%;height:160px;object-fit:cover;">
                @else
                    <div style="width:100%;height:100px;background:linear-gradient(135deg,rgba(124,58,237,.06),rgba(13,148,136,.06));display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-box-open" style="font-size:1.5rem;color:var(--accent);opacity:.4;"></i>
                    </div>
                @endif
                <div style="padding:1.25rem;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.5rem;">
                        <div>
                            <h6 style="font-weight:800;margin:0;color:var(--text-main);">{{ $bundle->name }}</h6>
                            @if($bundle->color_variant)
                                <span class="ops-badge ops-badge-neutral" style="margin-top:4px;">{{ $bundle->color_variant }}</span>
                            @endif
                        </div>
                        <span style="font-weight:900;color:#059669;font-size:1.1rem;">{{ number_format($bundle->price) }} ج</span>
                    </div>
                    @if($bundle->description)
                        <p style="font-size:.82rem;color:var(--text-muted);margin:.5rem 0 0;">{{ Str::limit($bundle->description, 80) }}</p>
                    @endif
                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.5rem;">
                        <i class="fas fa-cubes" style="color:var(--accent);"></i> {{ $bundle->products_count }} منتج
                    </div>
                </div>
                <div style="padding:.75rem 1.25rem;border-top:1px solid var(--border);display:flex;gap:.5rem;">
                    <a href="{{ route('admin.shop.bundles.edit', $bundle) }}" class="ops-action-btn edit" style="flex:1;text-align:center;padding:.4rem;border-radius:8px;text-decoration:none;">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    <form method="POST" action="{{ route('admin.shop.bundles.destroy', $bundle) }}" onsubmit="return confirm('حذف المجموعة؟')" style="flex:0;">
                        @csrf @method('DELETE')
                        <button class="ops-action-btn delete" style="padding:.4rem .6rem;border-radius:8px;"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Standalone Products --}}
@if($products->count())
<div class="ops-table-card">
    <div class="ops-table-header">
        <i class="fas fa-cube"></i>
        <h5>منتجات مستقلة</h5>
    </div>
    <div class="table-responsive">
        <table class="ops-table">
            <thead>
                <tr><th>الصورة</th><th>الاسم</th><th>السعر</th><th>الحجم</th><th>المخزون</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:10px;border:1px solid var(--border);">
                    </td>
                    <td style="font-weight:700;color:var(--text-main);">{{ $product->name }}</td>
                    <td style="font-weight:800;color:#059669;">{{ number_format($product->price) }} ج</td>
                    <td style="font-size:.82rem;">{{ $product->size_label ?: '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.shop.products.toggle-stock', $product) }}">
                            @csrf
                            <button type="submit" class="ops-badge {{ $product->in_stock ? 'ops-badge-active' : 'ops-badge-inactive' }}" style="border:none;cursor:pointer;">
                                {{ $product->in_stock ? 'متوفر' : 'نفذ' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="ops-actions">
                            <a href="{{ route('admin.shop.products.edit', $product) }}" class="ops-action-btn edit"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.shop.products.destroy', $product) }}" onsubmit="return confirm('حذف المنتج؟')">
                                @csrf @method('DELETE')
                                <button class="ops-action-btn delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(!$bundles->count() && !$products->count())
<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:18px;box-shadow:0 1px 3px rgba(0,0,0,.04);text-align:center;padding:4rem 2rem;">
    <div style="width:64px;height:64px;border-radius:16px;margin:0 auto 1rem;background:rgba(124,58,237,.06);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--accent);">
        <i class="fas fa-shopping-bag"></i>
    </div>
    <h6 style="font-weight:800;margin-bottom:.5rem;color:var(--text-main);">لم يتم إضافة أي منتجات أو مجموعات بعد</h6>
    <p style="color:var(--text-muted);font-size:.85rem;margin-bottom:1.25rem;">ابدئي بإضافة المنتجات والمجموعات من الأزرار أعلاه</p>
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('admin.shop.products.create') }}" class="ops-banner-btn" style="background:var(--bg-body);color:var(--text-secondary) !important;border:1px solid var(--border);font-size:.82rem;padding:.5rem 1.25rem;">
            <i class="fas fa-plus"></i> إضافة منتج
        </a>
        <a href="{{ route('admin.shop.bundles.create') }}" class="ops-banner-btn" style="font-size:.82rem;padding:.5rem 1.25rem;">
            <i class="fas fa-plus"></i> إضافة مجموعة
        </a>
    </div>
</div>
@endif
@endsection
