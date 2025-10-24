<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle de la Notificación</h1>
    <div class="bg-white p-4 rounded shadow-sm mb-3">
        <p><strong>Cliente (ID):</strong> {{ $notificacion->client_id }}</p>
        <p><strong>Cita (ID):</strong> {{ $notificacion->cita_id }}</p>
        <p><strong>Estado:</strong> {{ $notificacion->estado }}</p>
        <p><strong>Fecha:</strong> {{ $notificacion->fecha }}</p>
        <p><strong>Mensaje:</strong> {{ $notificacion->mensaje }}</p>
    </div>
    <a href="{{ route('notificacions.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection