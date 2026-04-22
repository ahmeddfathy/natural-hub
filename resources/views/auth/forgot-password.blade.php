@extends('layouts.app')

@section('title', 'نسيت كلمة المرور | Natural Hub')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<section class="nh-auth-section">
    <div class="nh-auth-shell">
        <div class="nh-auth-card">

            <div class="nh-auth-card-logo">
                <div class="nh-auth-logo-mark">N</div>
                <div><strong>Natural Hub</strong></div>
            </div>

            <h2>استعادة كلمة المرور</h2>
            <p class="nh-auth-sub">سنرسل رابط التغيير لبريدك</p>

            @if(session('status'))
            <div class="nh-auth-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="nh-auth-field" style="margin-bottom:22px;">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="nh-auth-input"
                           value="{{ old('email') }}" placeholder="example@domain.com" required autofocus>
                </div>
                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-paper-plane"></i> إرسال الرابط
                </button>
            </form>

            <div class="nh-auth-footer">
                <a href="{{ route('login') }}" class="nh-auth-link">
                    <i class="fas fa-arrow-right"></i> العودة لتسجيل الدخول
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
