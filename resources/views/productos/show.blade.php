@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Producto: {{ $producto->nombre }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Categoría:</strong> {{ $producto->cateogoria }}</p>
            <p><strong>Marca:</strong> {{ $producto->marca }}</p>
            <p><strong>Precio:</strong> {{ $producto->precio }}</p>
            <p><strong>Stock actual:</strong> {{ $producto->stockActual }}</p>
            <p><strong>Stock mínimo:</strong> {{ $producto->stockMin }}</p>
            <p><strong>Fecha de vencimiento:</strong> {{ optional($producto->fechaVencimiento)->format('Y-m-d') }}</p>
        </div>
    </div>

    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
