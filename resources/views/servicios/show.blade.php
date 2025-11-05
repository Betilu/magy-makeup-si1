@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use></svg>
                Detalle de Servicio
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
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
                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn text-white" style="background-color:#662a5b;">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
