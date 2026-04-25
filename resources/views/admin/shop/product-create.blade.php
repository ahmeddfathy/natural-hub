@extends('admin.layout')
@section('title', 'إضافة منتج')
@section('page-title', 'إضافة منتج جديد')

@section('content')
@include('admin.partials.validation-alert')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-shopping-bag ic-gallery"></i>
            <div>
                <h4>إضافة منتج</h4>
                <p>أضيفي منتج مستقل أو اربطيه بمجموعة</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-box"></i> بيانات المنتج</div>
    <form method="POST" action="{{ route('admin.shop.products.store') }}" enctype="multipart/form-data">
        @include('admin.shop.partials.product-form')
    </form>
</div>
@endsection
