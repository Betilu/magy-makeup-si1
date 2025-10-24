<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\horarios\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle del Horario</h1>
    <div class="bg-white p-4 rounded shadow-sm mb-3">
        <p><strong>Día:</strong> {{ $horario->dia }}</p>
        <p><strong>Hora Inicio:</strong> {{ $horario->horaInicio }}</p>
        <p><strong>Hora Fin:</strong> {{ $horario->horaFin }}</p>
    </div>
    <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection