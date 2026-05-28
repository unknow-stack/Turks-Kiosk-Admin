<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="site-noise"></div>
    <header class="topnav cinematic-reveal" data-reveal>
        <a href="{{ route('dashboard') }}" class="topnav-brand" aria-label="Turks dashboard">
            <img src="{{ asset('assets/images/turks-logo-official.png') }}" alt="Turks" class="topnav-logo">
        </a>

        <nav class="topnav-links" aria-label="Main navigation">
            <a class="topnav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="topnav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
            <a class="topnav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
            <a class="topnav-link {{ request()->routeIs('kitchen.*') ? 'active' : '' }}" href="{{ route('kitchen.index') }}">Kitchen</a>
            <a class="topnav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
            <a class="topnav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.sales') }}">Sales</a>
            <a class="topnav-link {{ request()->routeIs('api-docs') ? 'active' : '' }}" href="{{ route('api-docs') }}">Guide</a>
        </nav>

        <div class="topnav-user">
            <div class="user-dot">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-meta">
                <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                <span>Administrator</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-pill">Logout</button>
            </form>
        </div>
    </header>

    <main class="page-shell">
        <section class="page-heading cinematic-reveal" data-reveal>
            <div>
                <div class="eyebrow">Control Center</div>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
        </section>

        @if (session('success'))
            <div class="alert alert-success cinematic-reveal" data-reveal>{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error cinematic-reveal" data-reveal>{{ session('error') }}</div>
        @endif
        @if (session('status'))
            <div class="alert alert-status cinematic-reveal" data-reveal>{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('js/admin-ui.js') }}" defer></script>
</body>
</html>
