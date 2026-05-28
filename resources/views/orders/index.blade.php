@extends('layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')
@section('content')
<section class="page-banner orders-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Order Flow</div>
        <h2>See every ticket at a glance.</h2>
        <p>Filter by date or status, then open each ticket for details and updates.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('kitchen.index') }}">Kitchen Screen</a>
</section>

<section class="filter-panel cinematic-reveal" data-reveal>
    <form class="form-grid order-filter-grid" method="GET" action="{{ route('orders.index') }}">
        <div class="form-group"><label>Status</label><select name="status"><option value="">All statuses</option>@foreach($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ str($status)->headline() }}</option>@endforeach</select></div>
        <div class="form-group"><label>Date</label><input class="input" type="date" name="date" value="{{ request('date') }}"></div>
        <div class="form-group form-actions"><button class="btn btn-dark">Filter</button><a class="btn btn-light" href="{{ route('orders.index') }}">Reset</a></div>
    </form>
</section>

<section class="data-panel cinematic-reveal" data-reveal>
    <div class="panel-title"><span class="eyebrow">Tickets</span><h3>All orders</h3></div>
    <div class="table-wrap">
        <table class="modern-table">
            <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->customer_name ?? 'Guest' }}</td>
                        <td>{{ $order->items_count }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge badge-{{ $order->payment_status }}">{{ str($order->payment_status)->headline() }}</span></td>
                        <td><span class="badge badge-{{ $order->status }}">{{ str($order->status)->headline() }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td><a class="btn btn-light btn-small" href="{{ route('orders.show', $order) }}">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="muted">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $orders->links() }}</div>
</section>
@endsection
