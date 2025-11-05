@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use></svg>
                Producto: {{ $producto->nombre }}
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">

            <div class="card mb-3" style="border-radius:10px;">
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
            <a href="{{ route('productos.index') }}" class="btn btn-secondary ms-2">Volver</a>

        </div>
    </div>
</div>
@endsection
