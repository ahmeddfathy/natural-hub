@extends('admin.layout')
@section('title', 'تعديل مجموعة')
@section('page-title', 'تعديل مجموعة')

@section('content')
@include('admin.partials.validation-alert')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-layer-group ic-gallery"></i>
            <div>
                <h4>{{ $bundle->name }}</h4>
                <p>تعديل بيانات المجموعة والصورة والسعر</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-edit"></i> بيانات المجموعة</div>
    <form method="POST" action="{{ route('admin.shop.bundles.update', $bundle) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.shop.partials.bundle-form', ['bundle' => $bundle])
    </form>
</div>
@endsection
