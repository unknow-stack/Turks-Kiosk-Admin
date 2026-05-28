@extends('layouts.app')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('section-kicker', 'Menu Sections')
@section('content')
<div class="glass-card reveal">
    <div class="card-title"><div><span class="eyebrow">Edit</span><h2>{{ $category->name }}</h2></div><a class="btn btn-light" href="{{ route('categories.index') }}">Back</a></div>
    @include('categories.partials.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
</div>
@endsection
