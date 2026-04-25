@extends('admin.layout')
@section('title', 'التقارير المالية')
@section('page-title', 'التقارير والإحصائيات')

@section('content')

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas fa-chart-pie" style="width:48px;height:48px;border-radius:14px;background:#f74d6c;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;"></i>
            <div>
                <h4>التقارير والإحصائيات</h4>
                <p>تحليل شامل للأداء والإيرادات</p>
            </div>
        </div>
    </div>
</div>

{{-- Period Filter --}}
<div class="ops-filter-card">
    <div class="ops-filter-header"><i class="fas fa-filter"></i><h5>فلترة الفترة</h5></div>
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-2">
            <label class="form-label small">الفترة</label>
            <select name="period" class="form-select" onchange="this.form.submit()">
                <option value="today"  {{ $period=='today'  ? 'selected':'' }}>اليوم</option>
                <option value="week"   {{ $period=='week'   ? 'selected':'' }}>هذا الأسبوع</option>
                <option value="month"  {{ $period=='month'  ? 'selected':'' }}>هذا الشهر</option>
                <option value="year"   {{ $period=='year'   ? 'selected':'' }}>هذا العام</option>
                <option value="custom" {{ $period=='custom' ? 'selected':'' }}>مخصص</option>
            </select>
        </div>
        @if($period === 'custom')
        <div class="col-md-2">
            <label class="form-label small">من</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label small">إلى</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        @endif
        <div class="col-md-2">
            <label class="form-label small">الفرع</label>
            <select name="branch_id" class="form-select">
                <option value="">كل الفروع</option>
                @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected':'' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button class="ops-banner-btn" style="padding:.5rem 1rem;font-size:.82rem;">
                <i class="fas fa-filter"></i> تطبيق
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
@php
    $cards = [
        ['label'=>'إجمالي الحجوزات','value'=>$bookingSummary['total'],'bg'=>'rgba(247,77,108,.08)','color'=>'#f74d6c','icon'=>'calendar-alt'],
        ['label'=>'مكتملة','value'=>$bookingSummary['completed'],'bg'=>'rgba(5,150,105,.08)','color'=>'#059669','icon'=>'check-circle'],
        ['label'=>'قيد الانتظار','value'=>$bookingSummary['pending'],'bg'=>'rgba(217,119,6,.08)','color'=>'#d97706','icon'=>'clock'],
        ['label'=>'ملغية','value'=>$bookingSummary['cancelled'],'bg'=>'rgba(220,38,38,.08)','color'=>'#dc2626','icon'=>'ban'],
        ['label'=>'من الموقع','value'=>$bookingSummary['from_website'],'bg'=>'rgba(13,148,136,.08)','color'=>'#0d9488','icon'=>'globe'],
        ['label'=>'يدوية','value'=>$bookingSummary['from_manual'],'bg'=>'rgba(100,116,139,.08)','color'=>'#64748b','icon'=>'hand-paper'],
    ];
@endphp
<div class="ops-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
    @foreach($cards as $i => $card)
    <div class="ops-stat-card" style="animation-delay:{{ $i * 0.05 }}s">
        <div class="ops-stat-icon" style="background:{{ $card['bg'] }};color:{{ $card['color'] }};"><i class="fas fa-{{ $card['icon'] }}"></i></div>
        <div class="ops-stat-value" style="color:{{ $card['color'] }};">{{ $card['value'] }}</div>
        <div class="ops-stat-label">{{ $card['label'] }}</div>
    </div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    {{-- Daily Chart --}}
    <div class="col-lg-8">
        <div class="ops-table-card" style="height:100%;">
            <div class="ops-table-header"><i class="fas fa-chart-line"></i><h5>الحجوزات اليومية</h5></div>
            <div style="padding:0 1rem 1rem;">
                <canvas id="dailyChart" height="130"></canvas>
            </div>
        </div>
    </div>

    {{-- CRM Stats --}}
    <div class="col-lg-4">
        <div class="ops-table-card" style="height:100%;">
            <div class="ops-table-header"><i class="fas fa-heart"></i><h5>إحصائيات العميلات</h5></div>
            <div style="padding:0 1.5rem 1.5rem;">
                <div style="display:flex;justify-content:space-between;padding:.85rem 0;border-bottom:1px solid var(--border);">
                    <span style="font-size:.88rem;color:var(--text-muted);font-weight:600;">إجمالي العميلات</span>
                    <span style="font-size:.88rem;font-weight:800;color:var(--text-main);">{{ $crmStats['total_customers'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:.85rem 0;border-bottom:1px solid var(--border);">
                    <span style="font-size:.88rem;color:var(--text-muted);font-weight:600;">جديدات في الفترة</span>
                    <span style="font-size:.88rem;font-weight:800;color:#059669;">{{ $crmStats['new_this_period'] }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:.85rem 0;">
                    <span style="font-size:.88rem;color:var(--text-muted);font-weight:600;">عميلات منتظمات</span>
                    <span style="font-size:.88rem;font-weight:800;color:#f74d6c;">{{ $crmStats['repeat_customers'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Revenue by Branch --}}
    <div class="col-lg-5">
        <div class="ops-table-card" style="height:100%;">
            <div class="ops-table-header"><i class="fas fa-store"></i><h5>الإيرادات حسب الفرع</h5></div>
            <div class="table-responsive">
                <table class="ops-table">
                    <thead><tr><th>الفرع</th><th>الجلسات</th><th>الإيراد التقديري</th></tr></thead>
                    <tbody>
                        @forelse($revenueByBranch as $row)
                        <tr>
                            <td style="font-weight:700;color:var(--text-main);">{{ $row->branch_name }}</td>
                            <td><span class="ops-badge ops-badge-active">{{ $row->completed_bookings }}</span></td>
                            <td style="font-weight:800;color:#059669;">{{ number_format($row->total_revenue) }} ج</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center" style="padding:2rem;color:var(--text-muted);">لا توجد بيانات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Services --}}
    <div class="col-lg-7">
        <div class="ops-table-card" style="height:100%;">
            <div class="ops-table-header"><i class="fas fa-star"></i><h5>أكثر الخدمات طلباً</h5></div>
            <div class="table-responsive">
                <table class="ops-table">
                    <thead><tr><th>الخدمة</th><th>القسم</th><th>الحجوزات</th><th>المكتملة</th></tr></thead>
                    <tbody>
                        @forelse($topServices as $service)
                        <tr>
                            <td style="font-weight:700;color:var(--text-main);">{{ $service->title }}</td>
                            <td><span class="ops-badge ops-badge-neutral">{{ $service->category_type }}</span></td>
                            <td>{{ $service->bookings_count }}</td>
                            <td style="font-weight:700;color:#059669;">{{ $service->completed_count }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center" style="padding:2rem;color:var(--text-muted);">لا توجد بيانات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Staff Performance --}}
    <div class="col-12">
        <div class="ops-table-card">
            <div class="ops-table-header"><i class="fas fa-user-tie"></i><h5>أداء الموظفات</h5></div>
            <div class="table-responsive">
                <table class="ops-table">
                    <thead><tr><th>الموظفة</th><th>الفرع</th><th>الحجوزات المعيّنة</th><th>المكتملة</th><th>الإيراد التقديري</th></tr></thead>
                    <tbody>
                        @forelse($staffPerformance as $s)
                        <tr>
                            <td style="font-weight:700;color:var(--text-main);">{{ $s->name }}</td>
                            <td>{{ $s->branch_name }}</td>
                            <td>{{ $s->total_assigned }}</td>
                            <td><span class="ops-badge ops-badge-active">{{ $s->completed }}</span></td>
                            <td style="font-weight:800;color:#059669;">{{ number_format($s->revenue) }} ج</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center" style="padding:2rem;color:var(--text-muted);">لا توجد بيانات للفترة المحددة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const chartData = @json($dailyChart);
new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'إجمالي الحجوزات',
                data: chartData.totals,
                backgroundColor: 'rgba(124, 58, 237, 0.15)',
                borderColor: 'rgba(124, 58, 237, 0.7)',
                borderWidth: 2,
                borderRadius: 8,
            },
            {
                label: 'مكتملة',
                data: chartData.completed,
                backgroundColor: 'rgba(5, 150, 105, 0.5)',
                borderColor: 'rgba(5, 150, 105, 1)',
                borderWidth: 2,
                borderRadius: 8,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: '#64748b', font: { family: 'Cairo', weight: 700, size: 12 }, padding: 16 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, color: '#64748b', font: { family: 'Cairo' } },
                grid: { color: '#f1f5f9' }
            },
            x: {
                ticks: { color: '#64748b', font: { family: 'Cairo' } },
                grid: { color: '#f1f5f9' }
            }
        }
    }
});
</script>
@endsection
