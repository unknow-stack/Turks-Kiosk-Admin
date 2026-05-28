@extends('layouts.app')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('section-kicker', 'Menu Board')
@section('content')
<div class="glass-card reveal">
    <div class="card-title"><div><span class="eyebrow">Edit</span><h2>{{ $product->name }}</h2></div><a class="btn btn-light" href="{{ route('products.index') }}">Back</a></div>
    @include('products.partials.form', ['action' => route('products.update', $product), 'method' => 'PUT', 'product' => $product])
</div>
@endsection
