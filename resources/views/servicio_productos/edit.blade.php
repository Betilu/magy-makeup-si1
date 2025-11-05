@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Asignación</div>
        <div class="card-body">
            <form action="{{ route('servicio_productos.update', $item->id) }}" method="post">
                @method('PUT')
                @include('servicio_productos._form', ['item' => $item, 'servicios' => $servicios, 'productos' => $productos])
                <div class="mt-3">
                    <a href="{{ route('servicio_productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
