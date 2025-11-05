@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Asignación</div>
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
