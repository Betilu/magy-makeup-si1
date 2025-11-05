@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Crear Asignación de Herramienta</div>
        <div class="card-body">
            <form action="{{ route('asignacion_herramientas.store') }}" method="post">
                @include('asignacion_herramientas._form', ['herramientas' => $herramientas, 'estilistas' => $estilistas, 'recepcionistas' => $recepcionistas])
                <div class="mt-3">
                    <a href="{{ route('asignacion_herramientas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
