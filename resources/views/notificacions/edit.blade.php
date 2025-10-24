<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Notificación</h1>
    <form action="{{ route('notificacions.update', $notificacion->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Cliente (ID)</label>
            <input type="number" name="client_id" value="{{ $notificacion->client_id }}" class="form-control" required>
            @error('client_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Cita (ID)</label>
            <input type="number" name="cita_id" value="{{ $notificacion->cita_id }}" class="form-control" required>
            @error('cita_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" value="{{ $notificacion->estado }}" class="form-control" required>
            @error('estado')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" value="{{ $notificacion->fecha }}" class="form-control" required>
            @error('fecha')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <input type="text" name="mensaje" value="{{ $notificacion->mensaje }}" class="form-control" required>
            @error('mensaje')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
        <a href="{{ route('notificacions.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection