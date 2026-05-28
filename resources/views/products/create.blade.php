@extends('layouts.app')
@section('title', 'New Product')
@section('page-title', 'New Product')
@section('section-kicker', 'Menu Board')
@section('content')
<div class="glass-card reveal">
    <div class="card-title"><div><span class="eyebrow">Create</span><h2>Add Product</h2></div><a class="btn btn-light" href="{{ route('products.index') }}">Back</a></div>
    @include('products.partials.form', ['action' => route('products.store'), 'method' => 'POST', 'product' => null])
</div>
@endsection
