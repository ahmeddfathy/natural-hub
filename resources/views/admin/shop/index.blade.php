@extends('admin.layout')
@section('title', 'إدارة المتجر')
@section('page-title', 'إدارة المتجر')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

<div class="ops-banner shop-hero">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-shopping-bag ic-shop"></i>
            <div>
                <h4>المتجر</h4>
                <p>{{ $stats['bundles'] }} مجموعة — {{ $stats['products'] }} منتج — <span class="shop-danger">{{ $stats['out_of_stock'] }} نفدت</span></p>
            </div>
        </div>
        <div class="shop-actions-bar">
            <a href="{{ route('admin.shop.products.create') }}" class="shop-action-btn shop-action-btn--light">
                <i class="fas fa-plus"></i>
                منتج
            </a>
            <a href="{{ route('admin.shop.bundles.create') }}" class="shop-action-btn">
                <i class="fas fa-plus"></i>
                مجموعة
            </a>
        </div>
    </div>
</div>

@if($bundles->count())
<section class="shop-section">
    <div class="shop-section-title">
        <i class="fas fa-box-open"></i>
        <h5>المجموعات</h5>
    </div>
    <div class="shop-card-grid">
        @foreach($bundles as $bundle)
        <article class="shop-card">
            <div class="shop-card-media">
                @if($bundle->image)
                    <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}">
                @else
                    <div class="shop-card-placeholder"><i class="fas fa-box-open"></i></div>
                @endif
            </div>
            <div class="shop-card-body">
                <div class="shop-card-head">
                    <div>
                        <h6>{{ $bundle->name }}</h6>
                        @if($bundle->color_variant)
                            <span class="ops-badge ops-badge-neutral">{{ $bundle->color_variant }}</span>
                        @endif
                    </div>
                    <strong>{{ number_format($bundle->price) }} ج</strong>
                </div>
                @if($bundle->description)
                    <p>{{ Str::limit($bundle->description, 90) }}</p>
                @endif
                <div class="shop-card-meta">
                    <i class="fas fa-cubes"></i>
                    {{ $bundle->products_count }} منتج
                </div>
            </div>
            <div class="shop-card-footer">
                <a href="{{ route('admin.shop.bundles.edit', $bundle) }}" class="shop-card-edit"><i class="fas fa-edit"></i> تعديل</a>
                <form method="POST" action="{{ route('admin.shop.bundles.destroy', $bundle) }}" onsubmit="return confirm('حذف المجموعة؟')">
                    @csrf @method('DELETE')
                    <button class="ops-action-btn delete"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endif

@if($products->count())
<div class="ops-table-card shop-products-table">
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
                    <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="shop-product-thumb"></td>
                    <td><strong class="shop-product-name">{{ $product->name }}</strong></td>
                    <td><strong class="shop-price">{{ number_format($product->price) }} ج</strong></td>
                    <td>{{ $product->size_label ?: '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.shop.products.toggle-stock', $product) }}">
                            @csrf
                            <button type="submit" class="ops-badge {{ $product->in_stock ? 'ops-badge-active' : 'ops-badge-inactive' }} shop-stock-btn">
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
<div class="shop-empty">
    <div class="shop-empty-icon"><i class="fas fa-shopping-bag"></i></div>
    <h6>لم يتم إضافة أي منتجات أو مجموعات بعد</h6>
    <p>ابدئي بإضافة المنتجات والمجموعات من الأزرار أعلاه</p>
    <div class="shop-actions-bar shop-actions-bar--center">
        <a href="{{ route('admin.shop.products.create') }}" class="shop-action-btn shop-action-btn--light">
            <i class="fas fa-plus"></i>
            إضافة منتج
        </a>
        <a href="{{ route('admin.shop.bundles.create') }}" class="shop-action-btn">
            <i class="fas fa-plus"></i>
            إضافة مجموعة
        </a>
    </div>
</div>
@endif
@endsection
