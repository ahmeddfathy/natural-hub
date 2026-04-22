@extends('admin.layout')

@section('title', 'تعديل الخدمة')
@section('page-title', 'تعديل الخدمة')

@section('content')
<div class="service-page-banner admin-fade-in">
    <div>
        <h4><i class="fas fa-pen"></i> تعديل الخدمة</h4>
        <p>تحديث البيانات والصورة ومميزات الخدمة</p>
    </div>
    <a href="{{ route('admin.services.index') }}" class="btn btn-light">العودة للقائمة</a>
</div>

<div class="service-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="service-form-head">
        <h5><i class="fas fa-edit"></i> بيانات الخدمة</h5>
    </div>
    <div class="service-form-body">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.services._form')
        </form>
    </div>
</div>
@endsection
