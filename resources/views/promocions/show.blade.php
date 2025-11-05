@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detalle de Promoción</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3">Nombre</dt>
                <dd class="col-9">{{ $promocion->nombre }}</dd>

                <dt class="col-3">Descripción</dt>
                <dd class="col-9">{{ $promocion->descripcion }}</dd>

                <dt class="col-3">Fecha inicio</dt>
                <dd class="col-9">{{ optional($promocion->fechaInicio)->format('Y-m-d') }}</dd>

                <dt class="col-3">Fecha fin</dt>
                <dd class="col-9">{{ optional($promocion->fechaFin)->format('Y-m-d') }}</dd>

                <dt class="col-3">Descuento</dt>
                <dd class="col-9">{{ $promocion->descuento }}</dd>
            </dl>

            <div class="mt-3">
                <a href="{{ route('promocions.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('promocions.edit', $promocion->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
