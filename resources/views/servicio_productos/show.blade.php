@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:28px; height:28px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-link') }}"></use></svg>
                Detalle Asignación
            </h4>
        </div>
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
