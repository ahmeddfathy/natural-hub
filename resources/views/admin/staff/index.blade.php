@extends('admin.layout')
@section('title', 'إدارة الموظفات')
@section('page-title', 'الموظفات')

@section('content')
@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0"><i class="fas fa-user-tie text-primary me-2"></i>الموظفات</h4>
        <p class="text-muted small mb-0">{{ $stats['total'] }} موظفة — {{ $stats['active'] }} نشطة</p>
    </div>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إضافة موظفة
    </a>
</div>

{{-- Filter --}}
<form method="GET" class="row g-2 mb-4 align-items-end">
    <div class="col-md-3">
        <select name="branch_id" class="form-select form-select-sm">
            <option value="">كل الفروع</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected':'' }}>{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select form-select-sm">
            <option value="">كل الحالات</option>
            <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>نشطة</option>
            <option value="on_leave" {{ request('status')=='on_leave' ? 'selected':'' }}>إجازة</option>
            <option value="inactive" {{ request('status')=='inactive' ? 'selected':'' }}>غير نشطة</option>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i> فلترة</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm">مسح</a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>الصورة</th>
                    <th>الاسم</th>
                    <th>الفرع</th>
                    <th>التخصص</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr>
                    <td>
                        <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}"
                             class="rounded-circle" width="40" height="40" style="object-fit:cover">
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $member->name }}</div>
                        @if($member->phone)<div class="small text-muted">{{ $member->phone }}</div>@endif
                    </td>
                    <td class="small">{{ $member->branch->name }}</td>
                    <td class="small">{{ $member->specialty ?: '—' }}</td>
                    <td>
                        @php $colors = ['active'=>'success','on_leave'=>'warning','inactive'=>'secondary'] @endphp
                        @php $labels = ['active'=>'نشطة','on_leave'=>'إجازة','inactive'=>'متوقفة'] @endphp
                        <span class="badge bg-{{ $colors[$member->status] }}">{{ $labels[$member->status] }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member) }}"
                                  onsubmit="return confirm('حذف الموظفة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                        لا توجد موظفات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($staff->hasPages())
    <div class="card-footer">{{ $staff->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
