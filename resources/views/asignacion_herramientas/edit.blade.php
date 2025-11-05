@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Asignación</div>
        <div class="card-body">
            <form action="{{ route('asignacion_herramientas.update', $item->id) }}" method="post">
                @method('PUT')
                @include('asignacion_herramientas._form', ['item' => $item, 'herramientas' => $herramientas, 'estilistas' => $estilistas, 'recepcionistas' => $recepcionistas])
                <div class="mt-3">
                    <a href="{{ route('asignacion_herramientas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
