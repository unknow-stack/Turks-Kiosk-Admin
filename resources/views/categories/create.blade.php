@extends('layouts.app')
@section('title', 'New Category')
@section('page-title', 'New Category')
@section('section-kicker', 'Menu Sections')
@section('content')
<div class="glass-card reveal">
    <div class="card-title"><div><span class="eyebrow">Create</span><h2>Add Category</h2></div><a class="btn btn-light" href="{{ route('categories.index') }}">Back</a></div>
    @include('categories.partials.form', ['action' => route('categories.store'), 'method' => 'POST', 'category' => null])
</div>
@endsection
