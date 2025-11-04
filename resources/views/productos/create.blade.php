@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear producto</h1>

    <form action="{{ route('productos.store') }}" method="POST">
        @include('productos._form')

        <button class="btn btn-primary">Crear</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
