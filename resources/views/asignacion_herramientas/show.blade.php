@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use></svg>
                Detalle Asignación
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
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
                <a href="{{ route('asignacion_herramientas.edit', $item->id) }}" class="btn text-white" style="background-color:#662a5b;">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
