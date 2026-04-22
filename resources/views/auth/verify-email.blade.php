@extends('layouts.app')

@section('title', 'تأكيد البريد | Natural Hub')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<section class="nh-auth-section">
    <div class="nh-auth-shell">
        <div class="nh-auth-card" style="text-align:center;">

            <div class="nh-auth-card-logo" style="justify-content:center;">
                <div class="nh-auth-logo-mark">N</div>
                <div><strong>Natural Hub</strong></div>
            </div>

            <div style="font-size:2.2rem;margin-bottom:14px;">📧</div>
            <h2>تحقق من بريدك</h2>
            <p class="nh-auth-sub">أرسلنا رابط التأكيد — تفقدي صندوق الوارد</p>

            @if(session('status') == 'verification-link-sent')
            <div class="nh-auth-status">تم إرسال رابط جديد بنجاح</div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:14px;">
                @csrf
                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-redo"></i> إعادة الإرسال
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;font-family:inherit;color:rgba(255,255,255,.3);font-size:.85rem;">
                    تسجيل الخروج
                </button>
            </form>

        </div>
    </div>
</section>
@endsection
