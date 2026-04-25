@extends('admin.layout')
@section('title', 'تعديل منتج')
@section('page-title', 'تعديل منتج')

@section('content')
@include('admin.partials.validation-alert')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-shopping-bag ic-gallery"></i>
            <div>
                <h4>{{ $product->name }}</h4>
                <p>تعديل بيانات المنتج والمخزون</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-edit"></i> بيانات المنتج</div>
    <form method="POST" action="{{ route('admin.shop.products.update', $product) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.shop.partials.product-form', ['product' => $product, 'bundles' => $bundles])
    </form>
</div>
@endsection
