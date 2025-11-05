<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle de la Notificación</h1>
    <div class="bg-white p-4 rounded shadow-sm mb-3">
        <p><strong>Cliente:</strong> {{ $notificacion->client->user->name ?? 'Sin nombre' }}</p>
        <p><strong>Cita:</strong> Cita #{{ $notificacion->cita->id ?? $notificacion->cita_id }} - {{ $notificacion->cita->user->name ?? 'Usuario' }} - {{ $notificacion->cita->fecha ?? '' }} {{ $notificacion->cita->hora ?? '' }}</p>
        <p><strong>Estado:</strong> {{ $notificacion->estado }}</p>
        <p><strong>Fecha:</strong> {{ $notificacion->fecha }}</p>
        <p><strong>Mensaje:</strong> {{ $notificacion->mensaje }}</p>
    </div>
    <a href="{{ route('notificacions.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection