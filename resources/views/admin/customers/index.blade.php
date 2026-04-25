@extends('admin.layout')
@section('title', 'العميلات')
@section('page-title', 'إدارة العميلات (CRM)')

@section('content')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-heart ic-customer"></i>
            <div>
                <h4>إدارة العميلات</h4>
                <p>تتبع العميلات وسجل الزيارات</p>
            </div>
        </div>
    </div>
</div>

<div class="ops-stats-grid">
    <div class="ops-stat-card" style="animation-delay:.05s">
        <div class="ops-stat-icon ic-total"><i class="fas fa-users"></i></div>
        <div class="ops-stat-value">{{ $stats['total'] }}</div>
        <div class="ops-stat-label">إجمالي العميلات</div>
    </div>
    <div class="ops-stat-card" style="animation-delay:.1s">
        <div class="ops-stat-icon ic-regular"><i class="fas fa-star"></i></div>
        <div class="ops-stat-value">{{ $stats['regular'] }}</div>
        <div class="ops-stat-label">عميلات منتظمات (٣+ زيارات)</div>
    </div>
    <div class="ops-stat-card" style="animation-delay:.15s">
        <div class="ops-stat-icon ic-new"><i class="fas fa-user-plus"></i></div>
        <div class="ops-stat-value">{{ $stats['new'] }}</div>
        <div class="ops-stat-label">جديدات اليوم</div>
    </div>
</div>

{{-- Search --}}
<form method="GET" class="ops-search-form">
    <div class="ops-search-box">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="ابحثي باسم العميلة أو رقم الموبايل..." value="{{ request('search') }}">
    </div>
    <button class="ops-search-submit" title="بحث"><i class="fas fa-search"></i></button>
    @if(request('search'))
        <a href="{{ route('admin.customers.index') }}" class="ops-search-reset">مسح</a>
    @endif
</form>

<div class="ops-table-card">
    <div class="ops-table-header">
        <i class="fas fa-list-ul"></i>
        <h5>سجل العميلات</h5>
    </div>
    <div class="table-responsive">
        <table class="ops-table">
            <thead>
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
                        <div class="ops-name-cell">
                            <div>
                                <span class="ops-name">{{ $customer->name }}</span>
                                @if($customer->notes)<span class="ops-sub">{{ $customer->notes }}</span>@endif
                            </div>
                        </div>
                    </td>
                    <td><span style="direction:ltr;display:inline-block;">{{ $customer->phone }}</span></td>
                    <td>
                        <span class="ops-badge {{ $customer->total_visits >= 3 ? 'ops-badge-success' : 'ops-badge-neutral' }}">
                            {{ $customer->total_visits }}
                        </span>
                    </td>
                    <td style="font-size:.82rem;">{{ $customer->last_visit_at ? $customer->last_visit_at->diffForHumans() : '—' }}</td>
                    <td style="font-size:.82rem;">{{ $customer->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="ops-action-btn view" title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="ops-empty">
                            <div class="ops-empty-icon"><i class="fas fa-users"></i></div>
                            <h6>لا توجد عميلات</h6>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="ops-pagination">{{ $customers->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
