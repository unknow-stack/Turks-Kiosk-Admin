@extends('layouts.app')
@section('title', 'Sales Report')
@section('page-title', 'Sales')
@section('content')
<section class="page-banner report-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Sales Movement</div>
        <h2>Review performance without clutter.</h2>
        <p>Filter the date range and scan totals, daily sales, and top products.</p>
    </div>
</section>

<section class="filter-panel cinematic-reveal" data-reveal>
    <form class="form-grid report-filter-grid" method="GET" action="{{ route('reports.sales') }}">
        <div class="form-group"><label>Start Date</label><input class="input" type="date" name="start_date" value="{{ \Illuminate\Support\Carbon::parse($startDate)->toDateString() }}"></div>
        <div class="form-group"><label>End Date</label><input class="input" type="date" name="end_date" value="{{ \Illuminate\Support\Carbon::parse($endDate)->toDateString() }}"></div>
        <div class="form-group form-actions"><button class="btn btn-dark">Apply Filter</button></div>
    </form>
</section>

<section class="metrics-strip" data-reveal-group>
    <article class="metric-card cinematic-reveal" data-reveal><span>Gross Sales</span><strong>₱{{ number_format($summary['gross_sales'], 2) }}</strong></article>
    <article class="metric-card cinematic-reveal" data-reveal><span>Completed</span><strong>{{ $summary['completed_orders'] }}</strong></article>
    <article class="metric-card cinematic-reveal" data-reveal><span>Average Order</span><strong>₱{{ number_format($summary['average_order_value'], 2) }}</strong></article>
    <article class="metric-card cinematic-reveal" data-reveal><span>Cancelled</span><strong>{{ $summary['cancelled_orders'] }}</strong></article>
</section>

<section class="dashboard-flow two-col">
    <div class="data-panel cinematic-reveal" data-reveal>
        <div class="panel-title"><span class="eyebrow">Daily</span><h3>Daily sales</h3></div>
        <div class="table-wrap"><table class="modern-table"><thead><tr><th>Date</th><th>Orders</th><th>Sales</th></tr></thead><tbody>
            @forelse($dailySales as $day)
                <tr><td>{{ $day->sales_date }}</td><td>{{ $day->order_count }}</td><td>₱{{ number_format($day->sales, 2) }}</td></tr>
            @empty
                <tr><td colspan="3" class="muted">No completed sales in this date range.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
    <div class="data-panel cinematic-reveal" data-reveal>
        <div class="panel-title"><span class="eyebrow">Leaders</span><h3>Top products</h3></div>
        <div class="table-wrap"><table class="modern-table"><thead><tr><th>Product</th><th>Qty</th><th>Sales</th></tr></thead><tbody>
            @forelse($topProducts as $product)
                <tr><td><strong>{{ $product->product_name }}</strong></td><td>{{ $product->total_quantity }}</td><td>₱{{ number_format($product->total_sales, 2) }}</td></tr>
            @empty
                <tr><td colspan="3" class="muted">No product sales yet.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
</section>
@endsection
