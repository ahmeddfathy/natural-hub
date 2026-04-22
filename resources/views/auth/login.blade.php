@extends('layouts.app')

@section('title', 'تسجيل الدخول | Natural Hub')

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

            <h2>مرحباً بعودتك</h2>
            <p class="nh-auth-sub">أدخلي بياناتك للدخول</p>

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="nh-auth-field">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="nh-auth-input"
                           value="{{ old('email') }}" placeholder="example@domain.com"
                           required autofocus autocomplete="email">
                </div>

                <div class="nh-auth-field">
                    <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
                    <div class="nh-auth-input-wrap">
                        <input type="password" id="password" name="password"
                               class="nh-auth-input has-toggle"
                               placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="nh-auth-eye" onclick="nhTogglePwd()">
                            <i class="fas fa-eye" id="nhEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="nh-auth-meta">
                    <label class="nh-auth-remember">
                        <input type="checkbox" name="remember"> تذكريني
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="nh-auth-link">نسيتِ كلمة المرور؟</a>
                    @endif
                </div>

                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-sign-in-alt"></i> دخول
                </button>
            </form>

            @if(Route::has('register'))
            <div class="nh-auth-footer">
                ليس لديكِ حساب؟ <a href="{{ route('register') }}">إنشاء حساب</a>
            </div>
            @endif
        </div>

    </div>
</section>

<script>
function nhTogglePwd() {
    const inp = document.getElementById('password');
    const ico = document.getElementById('nhEyeIcon');
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    ico.classList.toggle('fa-eye', !show);
    ico.classList.toggle('fa-eye-slash', show);
}
</script>
@endsection
