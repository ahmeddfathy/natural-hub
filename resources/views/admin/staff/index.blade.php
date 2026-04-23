@extends('admin.layout')
@section('title', 'إدارة الموظفات')
@section('page-title', 'الموظفات')

@section('content')
@if(session('success'))<div class="ops-alert ops-alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-user-tie ic-staff"></i>
            <div>
                <h4>إدارة الموظفات</h4>
                <p>{{ $stats['total'] }} موظفة — {{ $stats['active'] }} نشطة</p>
            </div>
        </div>
        <a href="{{ route('admin.staff.create') }}" class="ops-banner-btn">
            <i class="fas fa-plus"></i> إضافة موظفة
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="ops-filter-card">
    <div class="ops-filter-header">
        <i class="fas fa-filter"></i>
        <h5>تصفية</h5>
    </div>
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <select name="branch_id" class="form-select">
                <option value="">كل الفروع</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected':'' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>نشطة</option>
                <option value="on_leave" {{ request('status')=='on_leave' ? 'selected':'' }}>إجازة</option>
                <option value="inactive" {{ request('status')=='inactive' ? 'selected':'' }}>غير نشطة</option>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button class="ops-banner-btn" style="padding:.5rem 1rem;font-size:.82rem;"><i class="fas fa-filter"></i> فلترة</button>
            <a href="{{ route('admin.staff.index') }}" class="ops-action-btn edit" style="width:auto;padding:0 12px;height:38px;border-radius:10px;display:inline-flex;align-items:center;font-size:.82rem;text-decoration:none;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);">مسح</a>
        </div>
    </form>
</div>

<div class="ops-table-card">
    <div class="ops-table-header">
        <i class="fas fa-list-ul"></i>
        <h5>جدول الموظفات</h5>
    </div>
    <div class="table-responsive">
        <table class="ops-table">
            <thead>
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
                        <div class="ops-avatar">
                            <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}">
                        </div>
                    </td>
                    <td>
                        <div class="ops-name-cell">
                            <div>
                                <span class="ops-name">{{ $member->name }}</span>
                                @if($member->phone)<span class="ops-sub">{{ $member->phone }}</span>@endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $member->branch->name }}</td>
                    <td>{{ $member->specialty ?: '—' }}</td>
                    <td>
                        @php
                            $colors = ['active'=>'ops-badge-active','on_leave'=>'ops-badge-leave','inactive'=>'ops-badge-inactive'];
                            $labels = ['active'=>'نشطة','on_leave'=>'إجازة','inactive'=>'متوقفة'];
                        @endphp
                        <span class="ops-badge {{ $colors[$member->status] }}">{{ $labels[$member->status] }}</span>
                    </td>
                    <td>
                        <div class="ops-actions">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="ops-action-btn edit" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" onsubmit="return confirm('حذف الموظفة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ops-action-btn delete" title="حذف"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="ops-empty">
                            <div class="ops-empty-icon"><i class="fas fa-user-slash"></i></div>
                            <h6>لا توجد موظفات</h6>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($staff->hasPages())
    <div class="ops-pagination">{{ $staff->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
