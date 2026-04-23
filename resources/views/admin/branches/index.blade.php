@extends('admin.layout')
@section('title', 'إدارة الفروع')
@section('page-title', 'إدارة الفروع')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="ops-alert ops-alert-danger"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>@endif

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-map-marker-alt ic-branch"></i>
            <div>
                <h4>إدارة الفروع</h4>
                <p>{{ $stats['total'] }} فروع — {{ $stats['active'] }} نشطة</p>
            </div>
        </div>
        <a href="{{ route('admin.branches.create') }}" class="ops-banner-btn">
            <i class="fas fa-plus"></i> إضافة فرع
        </a>
    </div>
</div>

<div class="ops-branch-grid">
    @forelse($branches as $index => $branch)
    <div class="ops-branch-card {{ !$branch->is_active ? 'inactive' : '' }}" style="animation-delay:{{ $index * 0.05 }}s">
        <div class="ops-branch-top">
            <div>
                <h5 class="ops-branch-name">{{ $branch->name }}</h5>
                <span class="ops-badge {{ $branch->is_active ? 'ops-badge-active' : 'ops-badge-inactive' }}">
                    <i class="fas {{ $branch->is_active ? 'fa-check-circle' : 'fa-pause-circle' }}"></i>
                    {{ $branch->is_active ? 'نشط' : 'متوقف' }}
                </span>
            </div>
            <span class="ops-branch-id">#{{ $branch->id }}</span>
        </div>

        <div class="ops-branch-detail"><i class="fas fa-map-marker-alt"></i> {{ $branch->address }}</div>
        @if($branch->phone)
        <div class="ops-branch-detail"><i class="fas fa-phone"></i> {{ $branch->phone }}</div>
        @endif
        @if($branch->opens_at)
        <div class="ops-branch-detail"><i class="fas fa-clock"></i> {{ $branch->opens_at }} — {{ $branch->closes_at }}</div>
        @endif

        <div class="ops-actions" style="margin-top:1rem;">
            <a href="{{ route('admin.branches.edit', $branch) }}" class="ops-action-btn edit" title="تعديل">
                <i class="fas fa-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.branches.toggle-status', $branch) }}">
                @csrf
                <button type="submit" class="ops-action-btn toggle" title="{{ $branch->is_active ? 'إيقاف' : 'تفعيل' }}">
                    <i class="fas fa-{{ $branch->is_active ? 'pause' : 'play' }}"></i>
                </button>
            </form>
            <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}" onsubmit="return confirm('حذف الفرع؟')">
                @csrf @method('DELETE')
                <button type="submit" class="ops-action-btn delete" title="حذف">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="ops-empty">
            <div class="ops-empty-icon"><i class="fas fa-map-marker-alt"></i></div>
            <h6>لم يتم إضافة أي فرع بعد</h6>
            <p>ابدأ بإضافة أول فرع</p>
            <a href="{{ route('admin.branches.create') }}" class="ops-banner-btn"><i class="fas fa-plus"></i> إضافة أول فرع</a>
        </div>
    </div>
    @endforelse
</div>
@endsection
