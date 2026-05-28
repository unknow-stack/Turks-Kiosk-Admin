@extends('layouts.app')
@section('title', 'System Guide')
@section('page-title', 'Guide')
@section('content')
<section class="page-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Reference</div>
        <h2>Connection guide for the kiosk team.</h2>
        <p>Use this page only as an internal reference for app connection and order creation.</p>
    </div>
</section>

<section class="data-panel cinematic-reveal" data-reveal>
    <div class="panel-title"><span class="eyebrow">Endpoints</span><h3>Available actions</h3></div>
    <div class="table-wrap">
        <table class="modern-table">
            <thead><tr><th>Method</th><th>Endpoint</th><th>Purpose</th></tr></thead>
            <tbody>
                <tr><td><strong>GET</strong></td><td><code>{{ url('/api/categories') }}</code></td><td>List active menu categories.</td></tr>
                <tr><td><strong>GET</strong></td><td><code>{{ url('/api/products') }}</code></td><td>List available products.</td></tr>
                <tr><td><strong>GET</strong></td><td><code>{{ url('/api/products/{id}') }}</code></td><td>Get one product detail.</td></tr>
                <tr><td><strong>POST</strong></td><td><code>{{ url('/api/orders') }}</code></td><td>Create an order.</td></tr>
                <tr><td><strong>GET</strong></td><td><code>{{ url('/api/orders/{order_number}') }}</code></td><td>Track order status.</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="data-panel cinematic-reveal" data-reveal>
    <div class="panel-title"><span class="eyebrow">Sample</span><h3>Order body</h3></div>
<pre class="code-block"><code>{
  "customer_name": "Guest 001",
  "order_type": "kiosk",
  "payment_method": "mock",
  "payment_status": "unpaid",
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 3, "quantity": 1 }
  ]
}</code></pre>
</section>
@endsection
