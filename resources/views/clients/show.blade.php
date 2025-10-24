@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Cliente</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $client->id }}</p>
            <p><strong>Dirección:</strong> {{ $client->direccion }}</p>
            <p><strong>Frecuencia:</strong> {{ $client->frecuencia }}</p>
            <p><strong>Observación:</strong> {{ $client->observacion ?? '—' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
