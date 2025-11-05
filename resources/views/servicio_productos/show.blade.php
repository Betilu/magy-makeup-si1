@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detalle Asignación</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3">Servicio</dt>
                <dd class="col-9">{{ $item->servicio->nombre ?? '-' }}</dd>

                <dt class="col-3">Producto</dt>
                <dd class="col-9">{{ $item->producto->nombre ?? '-' }}</dd>
            </dl>

            <div class="mt-3">
                <a href="{{ route('servicio_productos.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('servicio_productos.edit', $item->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
