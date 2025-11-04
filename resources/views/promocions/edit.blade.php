@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Promoción</div>
        <div class="card-body">
            <form action="{{ route('promocions.update', $promocion->id) }}" method="post">
                @method('PUT')
                @include('promocions._form')
                <div class="mt-3">
                    <a href="{{ route('promocions.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
