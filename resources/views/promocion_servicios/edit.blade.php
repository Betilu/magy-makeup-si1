@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:28px; height:28px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-link') }}"></use></svg>
                Editar Asignación
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('promocion_servicios.update', $item->id) }}" method="post">
                @method('PUT')
                @include('promocion_servicios._form', ['item' => $item, 'servicios' => $servicios, 'promocions' => $promocions])
                <div class="mt-3">
                    <a href="{{ route('promocion_servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
