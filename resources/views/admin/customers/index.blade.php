@extends('admin.layout')
@section('title', 'العميلات')
@section('page-title', 'إدارة العميلات (CRM)')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
            <div class="small text-muted">إجمالي العميلات</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-success">{{ $stats['regular'] }}</div>
            <div class="small text-muted">عميلات منتظمات (٣+ زيارات)</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-info">{{ $stats['new'] }}</div>
            <div class="small text-muted">جديدات اليوم</div>
        </div></div>
    </div>
</div>

{{-- Search --}}
<form method="GET" class="mb-4 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="ابحثي باسم العميلة أو رقم الموبايل..."
           value="{{ request('search') }}">
    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    @if(request('search'))
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">مسح</a>
    @endif
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>الاسم</th>
                    <th>الموبايل</th>
                    <th>الزيارات</th>
                    <th>آخر زيارة</th>
                    <th>تسجيل</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $customer->name }}</div>
                        @if($customer->notes)
                            <div class="small text-muted">{{ $customer->notes }}</div>
                        @endif
                    </td>
                    <td dir="ltr">{{ $customer->phone }}</td>
                    <td>
                        <span class="badge {{ $customer->total_visits >= 3 ? 'bg-success' : 'bg-secondary' }}">
                            {{ $customer->total_visits }}
                        </span>
                    </td>
                    <td class="small text-muted">
                        {{ $customer->last_visit_at ? $customer->last_visit_at->diffForHumans() : '—' }}
                    </td>
                    <td class="small text-muted">{{ $customer->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-2x d-block mb-2"></i>
                        لا توجد عميلات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="card-footer">{{ $customers->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
