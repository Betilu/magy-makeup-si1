<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\estilistas\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Estilistas</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Botón para abrir el modal --}}
    <button
        style="background-color: #e83e8c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;"
        data-bs-toggle="modal" data-bs-target="#createEstilistaModal">
        Agregar Estilista
    </button>

    <br><br>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Horario</th>
                <th>Calificación</th>
                <th>Comisión</th>
                <th>Disponibilidad</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($estilistas as $estilista)
            <tr>
                <td>{{ $estilista->id }}</td>
                <td>{{ $estilista->user->name }}</td>
                <td>{{ $estilista->user->email }}</td>
                <td>
                    @if($estilista->horario)
                        {{ $estilista->horario->dia }}: {{ $estilista->horario->horaInicio }} - {{ $estilista->horario->horaFin }}
                    @else
                        Sin horario
                    @endif
                </td>
                <td>{{ $estilista->calificacion }}</td>
                <td>${{ number_format($estilista->comision, 2) }}</td>
                <td>{{ $estilista->disponibilidad }}</td>
                <td>{{ $estilista->especialidad }}</td>
                <td>
                    <a href="{{ route('estilistas.show', $estilista->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('estilistas.edit', $estilista->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('estilistas.destroy', $estilista->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este estilista?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No hay estilistas registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    {{ $estilistas->links() }}
</div>

{{-- Modal de creación de estilista --}}
<div class="modal fade" id="createEstilistaModal" tabindex="-1" aria-labelledby="createEstilistaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('estilistas.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createEstilistaModalLabel">Agregar Estilista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="modal_name" class="form-label">Nombre Completo</label>
                        <input type="text" name="name" id="modal_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modal_email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="modal_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="modal_password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="modal_password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modal_password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="modal_password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Seleccionar Horario</label>
                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        @php
                            $horarios = \App\Models\Horario::all();
                        @endphp
                        @forelse($horarios as $horario)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="horario_id" id="modal_horario_{{ $horario->id }}" value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'checked' : '' }} required>
                                <label class="form-check-label" for="modal_horario_{{ $horario->id }}">
                                    {{ $horario->dia }}: {{ $horario->horaInicio }} - {{ $horario->horaFin }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">No hay horarios disponibles. <a href="{{ route('horarios.create') }}" target="_blank">Crear horario</a></p>
                        @endforelse
                    </div>
                    @error('horario_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="modal_calificacion" class="form-label">Calificación (0-5)</label>
                        <input type="number" name="calificacion" id="modal_calificacion" class="form-control @error('calificacion') is-invalid @enderror" value="{{ old('calificacion') }}" min="0" max="5" required>
                        @error('calificacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modal_comision" class="form-label">Comisión</label>
                        <input type="number" step="0.01" name="comision" id="modal_comision" class="form-control @error('comision') is-invalid @enderror" value="{{ old('comision') }}" required>
                        @error('comision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="modal_disponibilidad" class="form-label">Disponibilidad</label>
                        <input type="text" name="disponibilidad" id="modal_disponibilidad" class="form-control @error('disponibilidad') is-invalid @enderror" value="{{ old('disponibilidad') }}" required>
                        @error('disponibilidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modal_especialidad" class="form-label">Especialidad</label>
                        <input type="text" name="especialidad" id="modal_especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad') }}" required>
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" style="background-color: #e83e8c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- Script para reabrir el modal si hay errores --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('createEstilistaModal'));
        modal.show();
    });
</script>
@endif
@endsection