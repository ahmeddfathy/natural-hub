@extends('layouts.app')

@section('title', 'إنشاء حساب | Natural Hub')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<section class="nh-auth-section">
    <div class="nh-auth-shell">
        <div class="nh-auth-card">

            <div class="nh-auth-card-logo">
                <div class="nh-auth-logo-mark">N</div>
                <div>
                    <strong>Natural Hub</strong>
                    <small>لوحة الإدارة</small>
                </div>
            </div>

            <h2>إنشاء حساب</h2>
            <p class="nh-auth-sub">أدخلي بياناتك لإنشاء الحساب</p>

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="nh-auth-field">
                    <label for="name"><i class="fas fa-user"></i> الاسم</label>
                    <input type="text" id="name" name="name" class="nh-auth-input"
                           value="{{ old('name') }}" placeholder="اسمك الكريم"
                           required autofocus autocomplete="name">
                </div>

                <div class="nh-auth-field">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="nh-auth-input"
                           value="{{ old('email') }}" placeholder="example@domain.com"
                           required autocomplete="email">
                </div>

                <div class="nh-auth-field">
                    <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
                    <div class="nh-auth-input-wrap">
                        <input type="password" id="password" name="password"
                               class="nh-auth-input has-toggle"
                               placeholder="••••••••" required autocomplete="new-password">
                        <button type="button" class="nh-auth-eye" onclick="nhTogglePwd('password','nhE1')">
                            <i class="fas fa-eye" id="nhE1"></i>
                        </button>
                    </div>
                </div>

                <div class="nh-auth-field" style="margin-bottom:22px;">
                    <label for="password_confirmation"><i class="fas fa-lock"></i> تأكيد كلمة المرور</label>
                    <div class="nh-auth-input-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="nh-auth-input has-toggle"
                               placeholder="••••••••" required autocomplete="new-password">
                        <button type="button" class="nh-auth-eye" onclick="nhTogglePwd('password_confirmation','nhE2')">
                            <i class="fas fa-eye" id="nhE2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-user-plus"></i> إنشاء الحساب
                </button>
            </form>

            <div class="nh-auth-footer">
                لديكِ حساب؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
            </div>

        </div>
    </div>
</section>

<script>
function nhTogglePwd(id, iconId) {
    const inp = document.getElementById(id);
    const ico = document.getElementById(iconId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    ico.classList.toggle('fa-eye', !show);
    ico.classList.toggle('fa-eye-slash', show);
}
</script>
@endsection
