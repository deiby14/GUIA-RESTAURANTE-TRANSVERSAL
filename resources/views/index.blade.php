<!-- resources/views/restaurants/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Guía de Restaurantes</h1>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('restaurants.create') }}" class="btn btn-primary">Añadir restaurante</a>
    @endif
    
    <div class="row">
        @foreach($restaurants as $restaurant)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ $restaurant->image }}" class="card-img-top" alt="{{ $restaurant->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $restaurant->name }}</h5>
                        <p class="card-text">{{ Str::limit($restaurant->description, 100) }}</p>
                        <p>Precio medio: {{ $restaurant->average_price }} €</p>
                        <p>Tipo de cocina: {{ $restaurant->cuisine_type }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection