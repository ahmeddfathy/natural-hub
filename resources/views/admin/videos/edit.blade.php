@extends('admin.layout')

@section('title', 'تعديل فيديو')
@section('page-title', 'تعديل فيديو')

@section('content')
<div class="blogs-page-banner">
    <div class="blogs-page-banner-content">
        <i class="fas fa-edit"></i>
        <div>
            <h4>تعديل الفيديو</h4>
            <p>{{ $video->title }}</p>
        </div>
    </div>
    <a href="{{ route('admin.videos.index') }}" class="blogs-banner-back-btn">رجوع</a>
</div>

@include('admin.partials.validation-alert')

<div class="blogs-form-card">
    <div class="blogs-form-body">
        <form action="{{ route('admin.videos.update', $video) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.videos.partials.form-fields', ['video' => $video])
        </form>
    </div>
</div>
@endsection
