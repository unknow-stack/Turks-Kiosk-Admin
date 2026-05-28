<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Receipt {{ $order->order_number }}</title><link rel="stylesheet" href="{{ asset('css/admin.css') }}"></head>
<body style="background:#f3f4f6; padding:30px;">
    <div class="receipt">
        <h1>TURKS KIOSK</h1>
        <div style="text-align:center;">{{ $order->order_number }}<br>{{ $order->created_at->format('M d, Y h:i A') }}</div>
        <div class="receipt-line"></div>
        <div>Customer: {{ $order->customer_name ?? 'Guest' }}</div>
        <div>Status: {{ str($order->status)->headline() }}</div>
        <div>Payment: {{ str($order->payment_status)->headline() }}</div>
        <div class="receipt-line"></div>
        @foreach($order->items as $item)
            <div style="display:flex;justify-content:space-between;gap:20px;"><span>{{ $item->quantity }}x {{ $item->product_name }}</span><span>₱{{ number_format($item->subtotal, 2) }}</span></div>
        @endforeach
        <div class="receipt-line"></div>
        <div style="display:flex;justify-content:space-between;font-weight:900;font-size:18px;"><span>Total</span><span>₱{{ number_format($order->total_amount, 2) }}</span></div>
        <div class="receipt-line"></div>
        <div style="text-align:center;">Thank you!</div>
    </div>
    <script>window.print();</script>
</body></html>
