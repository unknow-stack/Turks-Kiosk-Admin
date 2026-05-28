@extends('layouts.app')
@section('title', 'Products')
@section('page-title', 'Products / Menu')
@section('content')
<section class="page-banner product-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Menu Board</div>
        <h2>Give every product room to look delicious.</h2>
        <p>Search, filter, edit availability, and keep the menu presentation clean.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('products.create') }}">New Product</a>
</section>

<section class="filter-panel cinematic-reveal" data-reveal>
    <form class="form-grid product-filter-grid" method="GET" action="{{ route('products.index') }}">
        <div class="form-group"><label>Search</label><input class="input" name="search" value="{{ request('search') }}" placeholder="Search product or SKU"></div>
        <div class="form-group"><label>Category</label><select name="category_id"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
        <div class="form-group"><label>Availability</label><select name="availability"><option value="">All</option><option value="available" @selected(request('availability')==='available')>Available</option><option value="unavailable" @selected(request('availability')==='unavailable')>Unavailable</option></select></div>
        <div class="form-group form-actions"><button class="btn btn-dark">Filter</button><a class="btn btn-light" href="{{ route('products.index') }}">Reset</a></div>
    </form>
</section>

<section class="product-showcase-grid" data-reveal-group>
    @forelse($products as $product)
        @php
            $categoryName = strtolower($product->category->name ?? '');
            $keepFullImage = str_contains($categoryName, 'drink') || str_contains($categoryName, 'add');
        @endphp
        <article class="product-showcase-card cinematic-reveal tilt-card {{ $keepFullImage ? 'product-no-zoom' : 'product-focus-zoom' }}" data-reveal data-tilt>
            <div class="product-image-stage">
                <img src="{{ $product->display_image }}" alt="{{ $product->name }}">
            </div>
            <div class="product-info">
                <div class="product-headline">
                    <div>
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->category->name ?? 'No category' }} • {{ $product->sku }}</p>
                    </div>
                    <span class="badge {{ $product->is_available ? 'badge-available' : 'badge-unavailable' }}">{{ $product->is_available ? 'Available' : 'Off' }}</span>
                </div>
                <p class="product-description">{{ str($product->description)->limit(100) }}</p>
                <div class="product-footer">
                    <strong class="price">₱{{ number_format($product->price, 2) }}</strong>
                    <div class="actions">
                        <a class="btn btn-light btn-small" href="{{ route('products.edit', $product) }}">Edit</a>
                        <form method="POST" action="{{ route('products.toggle', $product) }}">@csrf @method('PATCH')<button class="btn btn-outline btn-small">{{ $product->is_available ? 'Disable' : 'Enable' }}</button></form>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="btn btn-danger btn-small">Delete</button></form>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="data-panel cinematic-reveal" data-reveal><p class="muted">No products found.</p></div>
    @endforelse
</section>

<div class="pagination cinematic-reveal" data-reveal>{{ $products->links() }}</div>
@endsection
