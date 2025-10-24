<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\estilistas\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Estilista</h1>
    <form action="{{ route('estilistas.update', $estilista->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $estilista->user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $estilista->user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Seleccionar Horario</label>
            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                @forelse($horarios as $horario)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="horario_id" id="horario_{{ $horario->id }}" value="{{ $horario->id }}" {{ old('horario_id', $estilista->horario_id) == $horario->id ? 'checked' : '' }} required>
                        <label class="form-check-label" for="horario_{{ $horario->id }}">
                            {{ $horario->dia }}: {{ $horario->horaInicio }} - {{ $horario->horaFin }}
                        </label>
                    </div>
                @empty
                    <p class="text-muted">No hay horarios disponibles. <a href="{{ route('horarios.create') }}">Crear horario</a></p>
                @endforelse
            </div>
            @error('horario_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="calificacion" class="form-label">Calificación (0-5)</label>
                <input type="number" name="calificacion" id="calificacion" class="form-control @error('calificacion') is-invalid @enderror" value="{{ old('calificacion', $estilista->calificacion) }}" min="0" max="5" required>
                @error('calificacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="comision" class="form-label">Comisión</label>
                <input type="number" step="0.01" name="comision" id="comision" class="form-control @error('comision') is-invalid @enderror" value="{{ old('comision', $estilista->comision) }}" required>
                @error('comision')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="disponibilidad" class="form-label">Disponibilidad</label>
                <input type="text" name="disponibilidad" id="disponibilidad" class="form-control @error('disponibilidad') is-invalid @enderror" value="{{ old('disponibilidad', $estilista->disponibilidad) }}" required>
                @error('disponibilidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <input type="text" name="especialidad" id="especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad', $estilista->especialidad) }}" required>
                @error('especialidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-warning text-white">Actualizar</button>
        <a href="{{ route('estilistas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection