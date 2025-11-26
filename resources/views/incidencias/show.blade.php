@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use></svg>
                Detalle Incidencia
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <dl class="row">
                <dt class="col-3">Herramienta</dt>
                <dd class="col-9">{{ $incidencia->herramienta->nombre ?? 'No asignada' }}</dd>

                <dt class="col-3">Tipo Incidente</dt>
                <dd class="col-9">
                    @if($incidencia->tipo_incidente === 'En revisión')
                        <span class="badge bg-warning text-dark">En revisión</span>
                    @elseif($incidencia->tipo_incidente === 'Dañada')
                        <span class="badge bg-danger">Dañada</span>
                    @elseif($incidencia->tipo_incidente === 'Perdida')
                        <span class="badge bg-dark">Perdida</span>
                    @endif
                </dd>

                <dt class="col-3">Descripción</dt>
                <dd class="col-9">{{ $incidencia->descripcion }}</dd>

                <dt class="col-3">Fecha Incidente</dt>
                <dd class="col-9">{{ $incidencia->fechaIncidente->format('Y-m-d') }}</dd>

                <dt class="col-3">Fecha Remplazo</dt>
                <dd class="col-9">{{ $incidencia->fechaRemplazo ? $incidencia->fechaRemplazo->format('Y-m-d') : 'No registrada' }}</dd>

                <dt class="col-3">Fecha Registro</dt>
                <dd class="col-9">{{ $incidencia->created_at->format('Y-m-d H:i:s') }}</dd>

                <dt class="col-3">Última Actualización</dt>
                <dd class="col-9">{{ $incidencia->updated_at->format('Y-m-d H:i:s') }}</dd>
            </dl>

            <div class="mt-3">
                <a href="{{ route('incidencias.index') }}" class="btn btn-secondary">Volver</a>
                @can('editar incidencias')
                    <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="btn text-white" style="background-color:#662a5b;">Editar</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
