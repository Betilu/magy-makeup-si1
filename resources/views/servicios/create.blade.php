@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Crear Servicio</div>
        <div class="card-body">
            <form action="{{ route('servicios.store') }}" method="post">
                @include('servicios._form')
                <div class="mt-3">
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
