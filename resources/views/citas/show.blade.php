<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle de la Cita</h1>
    <div class="bg-white p-4 rounded shadow-sm mb-3">
        <p><strong>Usuario (ID):</strong> {{ $cita->user_id }}</p>
        <p><strong>Estado:</strong> {{ $cita->estado }}</p>
        <p><strong>Anticipo:</strong> ${{ number_format($cita->anticipo, 2) }}</p>
        <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
        <p><strong>Hora:</strong> {{ $cita->hora }}</p>
        <p><strong>Tipo:</strong> {{ $cita->tipo }}</p>
    </div>
    <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection