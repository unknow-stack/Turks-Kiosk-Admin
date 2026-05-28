@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('content')
<section class="page-banner cinematic-reveal tilt-card" data-reveal data-tilt>
    <div>
        <div class="eyebrow">Menu Sections</div>
        <h2>Organize products into clean groups.</h2>
        <p>Keep the menu easy to browse and simple to maintain.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">New Category</a>
</section>

<section class="data-panel cinematic-reveal" data-reveal>
    <div class="table-wrap">
        <table class="modern-table">
            <thead><tr><th>Name</th><th>Description</th><th>Products</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong><br><span class="small muted">{{ $category->slug }}</span></td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->display_order }}</td>
                        <td><span class="badge {{ $category->is_active ? 'badge-available' : 'badge-unavailable' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-light btn-small" href="{{ route('categories.edit', $category) }}">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-small">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $categories->links() }}</div>
</section>
@endsection
