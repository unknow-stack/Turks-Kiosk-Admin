@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order ' . $order->order_number)
@section('content')
<section class="detail-grid">
    <div class="data-panel cinematic-reveal" data-reveal>
        <div class="panel-title row-between">
            <div><span class="eyebrow">Ticket Detail</span><h3>Order items</h3><p class="muted small">{{ $order->created_at->format('M d, Y h:i A') }}</p></div>
            <a class="btn btn-light" href="{{ route('orders.receipt', $order) }}" target="_blank">Receipt View</a>
        </div>
        <div class="table-wrap">
            <table class="modern-table">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><td colspan="3"><strong>Total</strong></td><td><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td></tr>
                </tfoot>
            </table>
        </div>
    </div>

    <aside class="data-panel status-panel cinematic-reveal" data-reveal>
        <span class="eyebrow">Status</span>
        <h3>Update order</h3>
        <p class="muted small">Current: <span class="badge badge-{{ $order->status }}">{{ str($order->status)->headline() }}</span></p>
        <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
            @csrf @method('PATCH')
            <div class="form-group mb-18"><label>Status</label><select name="status">@foreach($statuses as $status)<option value="{{ $status }}" @selected($order->status === $status)>{{ str($status)->headline() }}</option>@endforeach</select></div>
            <div class="form-group mb-18"><label>Payment</label><select name="payment_status"><option value="unpaid" @selected($order->payment_status === 'unpaid')>Unpaid</option><option value="paid" @selected($order->payment_status === 'paid')>Paid</option></select></div>
            <button class="btn btn-primary btn-wide">Update Order</button>
        </form>
        <div class="divider"></div>
        <div class="small muted">Customer</div>
        <strong>{{ $order->customer_name ?? 'Guest' }}</strong><br>
        <span class="small muted">{{ $order->customer_contact ?? 'No contact' }}</span>
        <div class="mt-20 small muted">Notes</div>
        <p>{{ $order->notes ?: 'No notes.' }}</p>
    </aside>
</section>
@endsection
