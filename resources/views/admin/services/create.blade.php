@extends('admin.layout')

@section('title', 'إضافة خدمة جديدة')
@section('page-title', 'إضافة خدمة جديدة')

@section('content')
<div class="service-page-banner admin-fade-in">
    <div>
        <h4><i class="fas fa-plus-circle"></i> إضافة خدمة جديدة</h4>
        <p>أضيفي خدمة جديدة وصورتها لتظهر مباشرة في صفحة الخدمات</p>
    </div>
    <a href="{{ route('admin.services.index') }}" class="btn btn-light">العودة للقائمة</a>
</div>

<div class="service-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="service-form-head">
        <h5><i class="fas fa-edit"></i> بيانات الخدمة</h5>
    </div>
    <div class="service-form-body">
        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.services._form')
        </form>
    </div>
</div>
@endsection
