@extends('admin.layout')

@section('title', 'إدارة الخدمات')
@section('page-title', 'إدارة الخدمات')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/services.css') }}">
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="service-alert service-alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="service-alert service-alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Services Banner -->
<div class="service-banner">
    <div class="service-banner-top">
        <div class="service-banner-title">
            <i class="fas fa-concierge-bell"></i>
            <div>
                <h4>إدارة الخدمات</h4>
                <p>عرض وإدارة جميع الخدمات المقدمة</p>
            </div>
        </div>
        <a href="{{ route('admin.services.create') }}" class="service-banner-btn">
            <i class="fas fa-plus"></i>
            إضافة خدمة جديدة
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="service-stats-grid">
    <div class="service-stat-card">
        <div class="service-stat-card-icon total">
            <i class="fas fa-concierge-bell"></i>
        </div>
        <span class="service-stat-card-label">إجمالي الخدمات</span>
        <span class="service-stat-card-value">{{ $stats['total'] }}</span>
    </div>
    <div class="service-stat-card">
        <div class="service-stat-card-icon active">
            <i class="fas fa-check-circle"></i>
        </div>
        <span class="service-stat-card-label">خدمات مفعلة</span>
        <span class="service-stat-card-value">{{ $stats['active'] }}</span>
    </div>
    <div class="service-stat-card">
        <div class="service-stat-card-icon inactive">
            <i class="fas fa-eye-slash"></i>
        </div>
        <span class="service-stat-card-label">خدمات مخفية</span>
        <span class="service-stat-card-value">{{ $stats['inactive'] }}</span>
    </div>
</div>

<div class="service-form-card">
    <div class="service-form-header">
        <i class="fas fa-list-ul"></i>
        <h5>جدول الخدمات</h5>
        <span class="service-table-count">{{ $services->total() }} خدمة</span>
    </div>
    <div class="service-table-wrapper">
        <table class="service-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            @if($service->image)
                                <div class="service-thumbnail">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->image_alt ?: $service->title }}">
                                </div>
                            @else
                                <div class="service-placeholder-thumbnail">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="service-info-cell">
                                <span class="service-info-title">{{ $service->title }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="service-order-badge">{{ $service->sort_order }}</span>
                        </td>
                        <td>
                            @if($service->is_active)
                                <span class="service-status-badge service-status-active">
                                    <i class="fas fa-check-circle"></i>
                                    مفعلة
                                </span>
                            @else
                                <span class="service-status-badge service-status-inactive">
                                    <i class="fas fa-eye-slash"></i>
                                    مخفية
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="service-actions">
                                <a href="{{ route('admin.services.edit', $service) }}" class="service-action-btn edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                    <span class="action-tooltip">تعديل</span>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="service-action-btn delete" title="حذف">
                                        <i class="fas fa-trash"></i>
                                        <span class="action-tooltip">حذف</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="service-empty">
                                <div class="service-empty-icon">
                                    <i class="fas fa-concierge-bell"></i>
                                </div>
                                <h6>لا توجد خدمات حالياً</h6>
                                <p>يمكنك إضافة خدمة جديدة من خلال الزر أعلاه</p>
                                <a href="{{ route('admin.services.create') }}" class="service-empty-btn">
                                    <i class="fas fa-plus"></i>
                                    إضافة خدمة جديدة
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($services->hasPages())
    <div class="service-pagination">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection
