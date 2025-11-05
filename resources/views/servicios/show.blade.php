@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detalle de Servicio</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3">Nombre</dt>
                <dd class="col-9">{{ $servicio->nombre }}</dd>

                <dt class="col-3">Categoría</dt>
                <dd class="col-9">{{ $servicio->categoria }}</dd>

                <dt class="col-3">Descripción</dt>
                <dd class="col-9">{{ $servicio->descripcion }}</dd>

                <dt class="col-3">Duración</dt>
                <dd class="col-9">{{ $servicio->duracion }}</dd>
            </dl>

            <div class="mt-3">
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
