@extends('admin.layout')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/users.css') }}">
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="users-alert users-alert-success admin-fade-in">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="users-alert users-alert-danger admin-fade-in">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Users Banner -->
<div class="users-banner admin-fade-in">
    <div class="users-banner-top">
        <div class="users-banner-title">
            <i class="fas fa-users"></i>
            <div>
                <h4>إدارة المستخدمين</h4>
                <p>عرض وإدارة جميع المستخدمين المسجلين</p>
            </div>
        </div>
        <a href="{{ route('admin.users.create') }}" class="users-banner-btn">
            <i class="fas fa-plus"></i>
            إضافة مستخدم جديد
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="users-stats-grid admin-fade-in" style="animation-delay: 0.05s;">
    <div class="users-stat-card">
        <div class="users-stat-card-icon total">
            <i class="fas fa-users"></i>
        </div>
        <span class="users-stat-card-label">إجمالي المستخدمين</span>
        <span class="users-stat-card-value">{{ $users->total() }}</span>
    </div>
    <div class="users-stat-card">
        <div class="users-stat-card-icon admins">
            <i class="fas fa-user-shield"></i>
        </div>
        <span class="users-stat-card-label">المديرين</span>
        <span class="users-stat-card-value">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</span>
    </div>
    <div class="users-stat-card">
        <div class="users-stat-card-icon regular">
            <i class="fas fa-user"></i>
        </div>
        <span class="users-stat-card-label">مستخدمين عاديين</span>
        <span class="users-stat-card-value">{{ $users->filter(fn($u) => !$u->hasRole('admin'))->count() }}</span>
    </div>
</div>

<!-- Users Table -->
<div class="users-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="users-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>جدول المستخدمين</h5>
        <span class="users-table-count">{{ $users->total() }} مستخدم</span>
    </div>
    <div class="users-table-wrapper">
        <table class="users-table">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> المستخدم</th>
                    <th><i class="fas fa-envelope"></i> البريد الإلكتروني</th>
                    <th><i class="fas fa-shield-alt"></i> الدور</th>
                    <th><i class="fas fa-calendar-alt"></i> تاريخ التسجيل</th>
                    <th><i class="fas fa-cog"></i> الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-info-cell">
                            <div class="user-info-avatar">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            </div>
                            <div class="user-info-details">
                                <span class="user-info-name">{{ $user->name }}</span>
                                <span class="user-info-id">#{{ $user->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="user-email-cell">
                            <i class="fas fa-envelope"></i>
                            {{ $user->email }}
                        </div>
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="role-badge {{ $role->name === 'admin' ? 'role-badge-admin' : 'role-badge-user' }}">
                                <i class="fas {{ $role->name === 'admin' ? 'fa-crown' : 'fa-user' }}"></i>
                                {{ $role->name === 'admin' ? 'مدير' : 'مستخدم' }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <div class="user-date-cell">
                            <i class="fas fa-calendar-day"></i>
                            <span>{{ $user->created_at->format('Y-m-d') }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="user-actions">
                            <a href="{{ route('admin.users.edit', $user) }}" class="user-action-btn edit" title="تعديل">
                                <i class="fas fa-edit"></i>
                                <span class="action-tooltip">تعديل</span>
                            </a>
                            @if($user->id !== auth()->id() && !$user->hasRole('admin'))
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="user-action-btn delete" title="حذف">
                                    <i class="fas fa-trash"></i>
                                    <span class="action-tooltip">حذف</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="users-empty">
                            <div class="users-empty-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h6>لا يوجد مستخدمين حالياً</h6>
                            <p>يمكنك إضافة مستخدم جديد من خلال الزر أعلاه</p>
                            <a href="{{ route('admin.users.create') }}" class="users-empty-btn">
                                <i class="fas fa-plus"></i>
                                إضافة مستخدم جديد
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="users-pagination">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
