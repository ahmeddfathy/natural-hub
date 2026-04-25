@extends('admin.layout')
@section('title', 'إضافة مجموعة')
@section('page-title', 'إضافة مجموعة جديدة')

@section('content')
@include('admin.partials.validation-alert')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-layer-group ic-gallery"></i>
            <div>
                <h4>إضافة مجموعة</h4>
                <p>أنشئي مجموعة منتجات جديدة للمتجر</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-box-open"></i> بيانات المجموعة</div>
    <form method="POST" action="{{ route('admin.shop.bundles.store') }}" enctype="multipart/form-data">
        @include('admin.shop.partials.bundle-form')
    </form>
</div>
@endsection
