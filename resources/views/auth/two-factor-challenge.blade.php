@extends('layouts.app')

@section('title', 'التحقق بخطوتين | Natural Hub')

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

            <h2>التحقق بخطوتين</h2>
            <p class="nh-auth-sub">أدخلي الكود من تطبيق المصادقة</p>

            @if($errors->any())
            <div class="nh-auth-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('two-factor.login') }}" id="codeForm">
                @csrf
                <div class="nh-auth-field">
                    <label><i class="fas fa-shield-alt"></i> كود المصادقة (6 أرقام)</label>
                    <div class="nh-auth-otp">
                        @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" inputmode="numeric"
                               class="otp-digit" data-idx="{{ $i }}">
                        @endfor
                    </div>
                    <input type="hidden" name="code" id="otpHidden">
                </div>
                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-unlock"></i> تحقق
                </button>
            </form>

            <div class="nh-auth-footer" style="margin-top:16px;">
                <a href="#" onclick="toggleRecovery(event)" class="nh-auth-link">استخدام كود الاسترداد</a>
            </div>

            <form method="POST" action="{{ route('two-factor.login') }}" id="recoveryForm" style="display:none;margin-top:18px;">
                @csrf
                <div class="nh-auth-field" style="margin-bottom:18px;">
                    <label><i class="fas fa-key"></i> كود الاسترداد</label>
                    <input type="text" name="recovery_code" class="nh-auth-input"
                           placeholder="xxxx-xxxx-xxxx">
                </div>
                <button type="submit" class="nh-auth-btn">
                    <i class="fas fa-unlock"></i> دخول بالاسترداد
                </button>
            </form>

        </div>
    </div>
</section>

<script>
const digits = document.querySelectorAll('.otp-digit');
digits.forEach((el, i) => {
    el.addEventListener('input', () => {
        if (el.value && i < digits.length - 1) digits[i+1].focus();
        document.getElementById('otpHidden').value = [...digits].map(d => d.value).join('');
    });
    el.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !el.value && i > 0) digits[i-1].focus();
    });
});
function toggleRecovery(e) {
    e.preventDefault();
    const rf = document.getElementById('recoveryForm');
    rf.style.display = rf.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection
