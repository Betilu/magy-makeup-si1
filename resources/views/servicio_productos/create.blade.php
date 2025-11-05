@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Crear Asignación Servicio-Producto</div>
        <div class="card-body">
            <form action="{{ route('servicio_productos.store') }}" method="post">
                @include('servicio_productos._form', ['servicios' => $servicios, 'productos' => $productos])
                <div class="mt-3">
                    <a href="{{ route('servicio_productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
