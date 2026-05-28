@extends('layouts.app')
@section('title', 'Kitchen Screen')
@section('page-title', 'Kitchen')
@section('content')
<section class="page-banner kitchen-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Kitchen Board</div>
        <h2>Move tickets with less noise.</h2>
        <p>Pending, preparing, and ready orders are separated for fast kitchen decisions.</p>
    </div>
</section>

<section class="kitchen-board" data-reveal-group>
    @foreach(['pending' => 'Pending', 'preparing' => 'Preparing', 'ready' => 'Ready'] as $status => $label)
        <div class="kitchen-column cinematic-reveal" data-reveal>
            <div class="kitchen-column-head">
                <h3>{{ $label }}</h3>
                <span class="badge badge-{{ $status }}">{{ $orders->get($status, collect())->count() }}</span>
            </div>
            @forelse($orders->get($status, collect()) as $order)
                <article class="order-ticket tilt-card" data-tilt>
                    <div class="row-between">
                        <h4>{{ $order->order_number }}</h4>
                        <span class="badge badge-{{ $order->status }}">{{ str($order->status)->headline() }}</span>
                    </div>
                    <div class="small muted">{{ $order->customer_name ?? 'Guest' }} • {{ $order->created_at->diffForHumans() }}</div>
                    <ul class="ticket-items">
                        @foreach($order->items as $item)
                            <li>{{ $item->quantity }}x {{ $item->product_name }}</li>
                        @endforeach
                    </ul>
                    @if($order->notes)
                        <p class="ticket-note"><strong>Note:</strong> {{ $order->notes }}</p>
                    @endif
                    <div class="actions">
                        @if($status === 'pending')
                            <form method="POST" action="{{ route('kitchen.updateStatus', $order) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="preparing"><button class="btn btn-primary btn-small">Start</button></form>
                        @endif
                        @if($status === 'preparing')
                            <form method="POST" action="{{ route('kitchen.updateStatus', $order) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="ready"><button class="btn btn-primary btn-small">Ready</button></form>
                        @endif
                        @if($status === 'ready')
                            <form method="POST" action="{{ route('kitchen.updateStatus', $order) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="completed"><button class="btn btn-dark btn-small">Complete</button></form>
                        @endif
                        <form method="POST" action="{{ route('kitchen.updateStatus', $order) }}" onsubmit="return confirm('Cancel this order?')">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="btn btn-danger btn-small">Cancel</button></form>
                    </div>
                </article>
            @empty
                <div class="empty-state">No {{ strtolower($label) }} orders.</div>
            @endforelse
        </div>
    @endforeach
</section>
@endsection
