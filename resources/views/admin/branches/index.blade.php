@extends('admin.layout')
@section('title', 'إدارة الفروع')
@section('page-title', 'إدارة الفروع')

@section('content')
@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i>الفروع</h4>
        <p class="text-muted small mb-0">{{ $stats['total'] }} فروع — {{ $stats['active'] }} نشطة</p>
    </div>
    <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إضافة فرع
    </a>
</div>

<div class="row g-4">
    @forelse($branches as $branch)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 {{ !$branch->is_active ? 'opacity-75' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">{{ $branch->name }}</h5>
                        <span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $branch->is_active ? 'نشط' : 'متوقف' }}
                        </span>
                    </div>
                    <span class="text-muted small">#{{ $branch->id }}</span>
                </div>

                <ul class="list-unstyled small text-muted mb-3">
                    <li><i class="fas fa-map-marker-alt me-2"></i>{{ $branch->address }}</li>
                    @if($branch->phone)
                    <li class="mt-1"><i class="fas fa-phone me-2"></i>{{ $branch->phone }}</li>
                    @endif
                    @if($branch->opens_at)
                    <li class="mt-1"><i class="fas fa-clock me-2"></i>{{ $branch->opens_at }} — {{ $branch->closes_at }}</li>
                    @endif
                </ul>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    <form method="POST" action="{{ route('admin.branches.toggle-status', $branch) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $branch->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                            <i class="fas fa-{{ $branch->is_active ? 'pause' : 'play' }}"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                          onsubmit="return confirm('حذف الفرع؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-map-marker-alt fa-3x mb-3 d-block"></i>
        لم يتم إضافة أي فرع بعد
        <br>
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary mt-3">إضافة أول فرع</a>
    </div>
    @endforelse
</div>
@endsection
