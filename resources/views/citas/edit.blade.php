<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Cita</h1>
    <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Usuario (ID)</label>
            <input type="number" name="user_id" value="{{ $cita->user_id }}" class="form-control" required>
            @error('user_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" value="{{ $cita->estado }}" class="form-control" required>
            @error('estado')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Anticipo</label>
            <input type="number" step="0.01" name="anticipo" value="{{ $cita->anticipo }}" class="form-control" required>
            @error('anticipo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" value="{{ $cita->fecha }}" class="form-control" required>
            @error('fecha')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" name="hora" value="{{ $cita->hora }}" class="form-control" required>
            @error('hora')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" value="{{ $cita->tipo }}" class="form-control" required>
            @error('tipo')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
        <a href="{{ route('citas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection