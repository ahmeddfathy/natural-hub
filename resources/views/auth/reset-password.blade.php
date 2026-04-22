@extends('layouts.app')

@section('title', 'إعادة تعيين كلمة المرور | Natural Hub')

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

            <h2>كلمة مرور جديدة</h2>
            <p class="nh-auth-sub">اختاري كلمة مرور قوية وآمنة</p>

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="nh-auth-field">
                    <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="nh-auth-input"
                           value="{{ old('email', $request->email) }}" required>
                </div>

                <div class="nh-auth-field">
                    <label for="password"><i class="fas fa-lock"></i> كلمة المرور الجديدة</label>
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
                    <i class="fas fa-check"></i> تعيين كلمة المرور
                </button>
            </form>

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
