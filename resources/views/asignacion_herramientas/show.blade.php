@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detalle Asignación</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-3">Herramienta</dt>
                <dd class="col-9">{{ $item->herramienta->nombre ?? '-' }}</dd>

                <dt class="col-3">Estilista</dt>
                <dd class="col-9">{{ $item->estilista->nombre ?? '-' }}</dd>

                <dt class="col-3">Recepcionista</dt>
                <dd class="col-9">{{ $item->recepcionista->name ?? '-' }}</dd>

                <dt class="col-3">Estado entrega</dt>
                <dd class="col-9">{{ $item->estadoEntrega ?? '-' }}</dd>

                <dt class="col-3">Estado devolución</dt>
                <dd class="col-9">{{ $item->estadoDevolucion ?? '-' }}</dd>

                <dt class="col-3">Fecha asignación</dt>
                <dd class="col-9">{{ optional($item->fechaAsignacion)->format('Y-m-d') }}</dd>

                <dt class="col-3">Fecha devolución</dt>
                <dd class="col-9">{{ optional($item->fechaDevolucion)->format('Y-m-d') }}</dd>
            </dl>

            <div class="mt-3">
                <a href="{{ route('asignacion_herramientas.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('asignacion_herramientas.edit', $item->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
