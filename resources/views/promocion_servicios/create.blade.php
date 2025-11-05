@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Crear Asignación Promoción-Servicio</div>
        <div class="card-body">
            <form action="{{ route('promocion_servicios.store') }}" method="post">
                @include('promocion_servicios._form', ['servicios' => $servicios, 'promocions' => $promocions])
                <div class="mt-3">
                    <a href="{{ route('promocion_servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
