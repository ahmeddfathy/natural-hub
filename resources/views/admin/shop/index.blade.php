@extends('admin.layout')
@section('title', 'إدارة المتجر')
@section('page-title', 'إدارة المتجر')

@section('content')
@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif

{{-- Stats + Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0"><i class="fas fa-shopping-bag text-primary me-2"></i>المتجر</h4>
        <p class="text-muted small mb-0">
            {{ $stats['bundles'] }} مجموعة —
            {{ $stats['products'] }} منتج —
            <span class="text-danger">{{ $stats['out_of_stock'] }} نفذت</span>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.shop.products.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-plus me-1"></i> منتج
        </a>
        <a href="{{ route('admin.shop.bundles.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> مجموعة
        </a>
    </div>
</div>

{{-- Bundles --}}
@if($bundles->count())
<h5 class="mb-3"><i class="fas fa-box-open me-2 text-muted"></i>المجموعات</h5>
<div class="row g-3 mb-5">
    @foreach($bundles as $bundle)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            @if($bundle->image)
                <img src="{{ $bundle->image_url }}" class="card-img-top" style="height:160px;object-fit:cover;" alt="{{ $bundle->name }}">
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $bundle->name }}</h6>
                        @if($bundle->color_variant)
                            <span class="badge bg-secondary small">{{ $bundle->color_variant }}</span>
                        @endif
                    </div>
                    <span class="fw-bold text-success">{{ number_format($bundle->price) }} ج</span>
                </div>
                @if($bundle->description)
                    <p class="small text-muted mt-2 mb-0">{{ Str::limit($bundle->description, 80) }}</p>
                @endif
                <div class="small text-muted mt-2">
                    <i class="fas fa-cubes me-1"></i> {{ $bundle->products_count }} منتج
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex gap-2">
                <a href="{{ route('admin.shop.bundles.edit', $bundle) }}" class="btn btn-outline-primary btn-sm flex-fill">
                    <i class="fas fa-edit me-1"></i> تعديل
                </a>
                <form method="POST" action="{{ route('admin.shop.bundles.destroy', $bundle) }}"
                      onsubmit="return confirm('حذف المجموعة؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Standalone Products --}}
@if($products->count())
<h5 class="mb-3"><i class="fas fa-cube me-2 text-muted"></i>منتجات مستقلة</h5>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>الصورة</th><th>الاسم</th><th>السعر</th><th>الحجم</th><th>المخزون</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             width="50" height="50" style="object-fit:cover;" class="rounded">
                    </td>
                    <td class="fw-semibold">{{ $product->name }}</td>
                    <td class="text-success fw-bold">{{ number_format($product->price) }} ج</td>
                    <td class="small text-muted">{{ $product->size_label ?: '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.shop.products.toggle-stock', $product) }}">
                            @csrf
                            <button type="submit" class="badge border-0 bg-{{ $product->in_stock ? 'success' : 'danger' }} text-white">
                                {{ $product->in_stock ? 'متوفر' : 'نفذ' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.shop.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.shop.products.destroy', $product) }}"
                                  onsubmit="return confirm('حذف المنتج؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
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
<div class="text-center py-5 text-muted">
    <i class="fas fa-shopping-bag fa-3x mb-3 d-block"></i>
    لم يتم إضافة أي منتجات أو مجموعات بعد
</div>
@endif
@endsection
