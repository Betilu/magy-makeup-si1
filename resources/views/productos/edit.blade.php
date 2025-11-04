@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar producto</h1>

    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        @include('productos._form')

        <button class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
