@extends('admin.layout')
@section('title', 'التقارير المالية')
@section('page-title', 'التقارير والإحصائيات')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endsection

@section('content')

{{-- Period Filter --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small">الفترة</label>
                <select name="period" class="form-select form-select-sm" onchange="this.form.submit()">
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
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">إلى</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
            </div>
            @endif
            <div class="col-md-2">
                <label class="form-label small">الفرع</label>
                <select name="branch_id" class="form-select form-select-sm">
                    <option value="">كل الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected':'' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-filter me-1"></i> تطبيق
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Booking Summary Cards --}}
<div class="row g-3 mb-4">
    @php
        $cards = [
            ['label'=>'إجمالي الحجوزات','value'=>$bookingSummary['total'],'color'=>'primary','icon'=>'calendar'],
            ['label'=>'مكتملة','value'=>$bookingSummary['completed'],'color'=>'success','icon'=>'check-circle'],
            ['label'=>'قيد الانتظار','value'=>$bookingSummary['pending'],'color'=>'warning','icon'=>'clock'],
            ['label'=>'ملغية','value'=>$bookingSummary['cancelled'],'color'=>'danger','icon'=>'ban'],
            ['label'=>'من الموقع','value'=>$bookingSummary['from_website'],'color'=>'info','icon'=>'globe'],
            ['label'=>'يدوية','value'=>$bookingSummary['from_manual'],'color'=>'secondary','icon'=>'hand-paper'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body p-3">
                <i class="fas fa-{{ $card['icon'] }} text-{{ $card['color'] }} fs-4 mb-1"></i>
                <div class="fs-3 fw-bold">{{ $card['value'] }}</div>
                <div class="small text-muted">{{ $card['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    {{-- Daily Chart --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-chart-line text-primary me-2"></i> الحجوزات اليومية
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- CRM Stats --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-heart text-primary me-2"></i> إحصائيات العميلات
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                    <span class="text-muted">إجمالي العميلات</span>
                    <strong>{{ $crmStats['total_customers'] }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                    <span class="text-muted">جديدات في الفترة</span>
                    <strong class="text-success">{{ $crmStats['new_this_period'] }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">عميلات منتظمات</span>
                    <strong class="text-primary">{{ $crmStats['repeat_customers'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Revenue by Branch --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-store text-primary me-2"></i> الإيرادات حسب الفرع
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>الفرع</th><th>الجلسات</th><th>الإيراد التقديري</th></tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByBranch as $row)
                        <tr>
                            <td>{{ $row->branch_name }}</td>
                            <td><span class="badge bg-primary">{{ $row->completed_bookings }}</span></td>
                            <td class="fw-bold text-success">{{ number_format($row->total_revenue) }} ج</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Services --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-star text-primary me-2"></i> أكثر الخدمات طلباً
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>الخدمة</th><th>القسم</th><th>الحجوزات</th><th>المكتملة</th></tr>
                    </thead>
                    <tbody>
                        @foreach($topServices as $service)
                        <tr>
                            <td class="small">{{ $service->title }}</td>
                            <td><span class="badge bg-secondary">{{ $service->category_type }}</span></td>
                            <td>{{ $service->bookings_count }}</td>
                            <td class="text-success fw-semibold">{{ $service->completed_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Staff Performance --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-user-tie text-primary me-2"></i> أداء الموظفات
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>الموظفة</th><th>الفرع</th><th>الحجوزات المعيّنة</th><th>المكتملة</th><th>الإيراد التقديري</th></tr>
                    </thead>
                    <tbody>
                        @forelse($staffPerformance as $s)
                        <tr>
                            <td class="fw-semibold">{{ $s->name }}</td>
                            <td class="small">{{ $s->branch_name }}</td>
                            <td>{{ $s->total_assigned }}</td>
                            <td><span class="badge bg-success">{{ $s->completed }}</span></td>
                            <td class="fw-bold text-success">{{ number_format($s->revenue) }} ج</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">لا توجد بيانات للفترة المحددة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
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
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                borderColor: 'rgba(13, 110, 253, 0.8)',
                borderWidth: 2,
                borderRadius: 6,
            },
            {
                label: 'مكتملة',
                data: chartData.completed,
                backgroundColor: 'rgba(25, 135, 84, 0.8)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 2,
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endsection
