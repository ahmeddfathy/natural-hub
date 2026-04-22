@extends('admin.layout')

@section('title', 'إضافة مستخدم جديد')
@section('page-title', 'إضافة مستخدم جديد')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/users.css') }}">
@endsection

@section('content')
<!-- Page Banner -->
<div class="users-page-banner admin-fade-in">
    <div class="users-page-banner-content">
        <i class="fas fa-user-plus"></i>
        <div>
            <h4>إضافة مستخدم جديد</h4>
            <p>إنشاء حساب مستخدم جديد وتحديد صلاحياته</p>
        </div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="users-banner-back-btn">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>
</div>

<!-- Form Card -->
<div class="users-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="users-form-header">
        <i class="fas fa-user-plus"></i>
        <h5>بيانات المستخدم</h5>
    </div>
    <div class="users-form-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="أدخل اسم المستخدم"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="example@domain.com"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="أدخل كلمة المرور (8 أحرف على الأقل)"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="أعد إدخال كلمة المرور"
                           required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">الدور <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" 
                            id="role" 
                            name="role" 
                            required>
                        <option value="">اختر الدور</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                    {{ old('role') == $role->name ? 'selected' : '' }}>
                                @if($role->name === 'admin')
                                    مدير (Admin)
                                @elseif($role->name === 'user')
                                    مستخدم عادي (User)
                                @else
                                    {{ $role->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="users-form-divider">

            <div class="users-form-actions">
                <a href="{{ route('admin.users.index') }}" class="users-back-btn">
                    <i class="fas fa-arrow-right"></i>
                    رجوع
                </a>
                <button type="submit" class="users-save-btn">
                    <i class="fas fa-save"></i>
                    حفظ المستخدم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
