@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <section class="dashboard-hero cinematic-reveal tilt-card" data-reveal data-tilt>
        <div class="hero-glow"></div>
        <div class="hero-content">
            <div class="eyebrow">Today’s Overview</div>
            <h2>Keep orders moving. Keep the menu fresh.</h2>
            <p>Monitor activity, update menu items, and move tickets through preparation with a clean workspace.</p>
            <div class="actions hero-actions">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Menu Item</a>
                <a href="{{ route('kitchen.index') }}" class="btn btn-neon">Open Kitchen</a>
            </div>
        </div>
        <img class="hero-person parallax-slow" data-parallax="-0.06" src="{{ asset('assets/images/turks-ambassador.png') }}" alt="Turks promotional image">
    </section>

    <section class="metrics-strip" data-reveal-group>
        <article class="metric-card cinematic-reveal" data-reveal>
            <span>Categories</span>
            <strong>{{ $stats['categories'] }}</strong>
            <small>Menu sections</small>
        </article>
        <article class="metric-card cinematic-reveal" data-reveal>
            <span>Products</span>
            <strong>{{ $stats['products'] }}</strong>
            <small>{{ $stats['available_products'] }} available</small>
        </article>
        <article class="metric-card cinematic-reveal" data-reveal>
            <span>Active Orders</span>
            <strong>{{ $stats['active_orders'] }}</strong>
            <small>Needs attention</small>
        </article>
        <article class="metric-card cinematic-reveal" data-reveal>
            <span>Sales</span>
            <strong>₱{{ number_format($stats['completed_sales'], 2) }}</strong>
            <small>Completed orders</small>
        </article>
    </section>

    <section class="dashboard-flow">
        <div class="shortcut-panel cinematic-reveal" data-reveal>
            <div class="panel-title">
                <span class="eyebrow">Shortcuts</span>
                <h3>Fast actions</h3>
            </div>
            <div class="shortcut-list">
                <a href="{{ route('categories.create') }}" class="shortcut-item tilt-card" data-tilt><span>📁</span><div><strong>New Category</strong><small>Organize menu sections</small></div></a>
                <a href="{{ route('products.create') }}" class="shortcut-item tilt-card" data-tilt><span>🌯</span><div><strong>Add Product</strong><small>Create a menu item</small></div></a>
                <a href="{{ route('orders.index') }}" class="shortcut-item tilt-card" data-tilt><span>🧾</span><div><strong>View Orders</strong><small>Check incoming tickets</small></div></a>
            </div>
        </div>

        <div class="data-panel cinematic-reveal" data-reveal>
            <div class="panel-title row-between">
                <div><span class="eyebrow">Recent</span><h3>Latest orders</h3></div>
                <a class="text-link" href="{{ route('orders.index') }}">View all</a>
            </div>
            <div class="ticket-stack">
                @forelse($latestOrders as $order)
                    <a href="{{ route('orders.show', $order) }}" class="mini-ticket tilt-card" data-tilt>
                        <div><strong>{{ $order->order_number }}</strong><small>{{ $order->customer_name ?? 'Guest' }}</small></div>
                        <span>₱{{ number_format($order->total_amount, 2) }}</span>
                        <em class="badge badge-{{ $order->status }}">{{ str($order->status)->headline() }}</em>
                    </a>
                @empty
                    <p class="muted">No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div class="data-panel cinematic-reveal" data-reveal>
            <div class="panel-title">
                <span class="eyebrow">Movement</span>
                <h3>Top products</h3>
            </div>
            <div class="leader-list">
                @forelse($topProducts as $product)
                    <div class="leader-row">
                        <span>{{ $loop->iteration }}</span>
                        <div><strong>{{ $product->product_name }}</strong><small>{{ $product->total_quantity }} sold</small></div>
                        <b>₱{{ number_format($product->total_sales, 2) }}</b>
                    </div>
                @empty
                    <p class="muted">No completed sales yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
