@extends('admin.layout')

@section('title', 'إضافة فيديو')
@section('page-title', 'إضافة فيديو')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
<div class="blogs-page-banner">
    <div class="blogs-page-banner-content">
        <i class="fas fa-plus-circle"></i>
        <div>
            <h4>إضافة فيديو جديد</h4>
            <p>أدخلي رابط YouTube أو Google Drive لفيديو مشارك ليتم عرضه في الموقع.</p>
        </div>
    </div>
    <a href="{{ route('admin.videos.index') }}" class="blogs-banner-back-btn">رجوع</a>
</div>

@include('admin.partials.validation-alert')

<div class="blogs-form-card">
    <div class="blogs-form-body">
        <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf
            @include('admin.videos.partials.form-fields', ['video' => null])
        </form>
    </div>
</div>
@endsection
