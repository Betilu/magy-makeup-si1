<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\horarios\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Horario</h1>
    <form action="{{ route('horarios.update', $horario->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Día</label>
            <input type="text" name="dia" value="{{ $horario->dia }}" class="form-control" required>
            @error('dia')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Hora Inicio</label>
            <input type="time" name="horaInicio" value="{{ $horario->horaInicio }}" class="form-control" required>
            @error('horaInicio')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Hora Fin</label>
            <input type="time" name="horaFin" value="{{ $horario->horaFin }}" class="form-control" required>
            @error('horaFin')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection