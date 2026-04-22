@extends('admin.layout')

@section('title', 'تعديل المستخدم')
@section('page-title', 'تعديل المستخدم')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/users.css') }}">
@endsection

@section('content')
<!-- Page Banner -->
<div class="users-page-banner admin-fade-in">
    <div class="users-page-banner-content">
        <i class="fas fa-user-edit"></i>
        <div>
            <h4>تعديل بيانات: {{ $user->name }}</h4>
            <p>تعديل معلومات المستخدم والصلاحيات</p>
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
        <i class="fas fa-user-edit"></i>
        <h5>تعديل البيانات</h5>
    </div>
    <div class="users-form-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
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
                           value="{{ old('email', $user->email) }}" 
                           placeholder="example@domain.com"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="اتركها فارغة إذا لم ترد تغييرها">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">اتركها فارغة إذا لم ترد تغيير كلمة المرور</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="أعد إدخال كلمة المرور الجديدة">
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
                                    {{ (old('role') ?? $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
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
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
