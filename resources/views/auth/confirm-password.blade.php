@extends('layouts.app')

@section('title', 'تأكيد كلمة المرور | Natural Hub')

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

            <h2>تأكيد كلمة المرور</h2>
            <p class="nh-auth-sub">منطقة محمية — أدخلي كلمة مرورك للمتابعة</p>

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="nh-auth-field" style="margin-bottom:22px;">
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
                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-shield-alt"></i> تأكيد
                </button>
            </form>

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
