@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Clientes</h1>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Mensaje de error --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Botón para abrir el modal --}}
        <button
            style="background-color: #e83e8c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;"
            data-bs-toggle="modal" data-bs-target="#createClientModal">
            Agregar Cliente
        </button>

        <br>
        <br>
        
        {{-- Tabla de clientes --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Frecuencia</th>
                    <th>Observación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->user->name }}</td>
                        <td>{{ $client->user->email }}</td>
                        <td>{{ $client->direccion }}</td>
                        <td>{{ $client->frecuencia }}</td>
                        <td>{{ $client->observacion ?? '—' }}</td>
                        <td>
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline-block"
                                onsubmit="return confirm('¿Eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        {{ $clients->links() }}
    </div>

    {{-- Modal de creación de cliente --}}
    <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('clients.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createClientModalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_name" class="form-label">Nombre Completo</label>
                            <input type="text" name="name" id="modal_name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="modal_email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="modal_password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="modal_password_confirmation"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="modal_direccion"
                            class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}"
                            required>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="modal_frecuencia" class="form-label">Frecuencia</label>
                        <input type="number" name="frecuencia" id="modal_frecuencia"
                            class="form-control @error('frecuencia') is-invalid @enderror" value="{{ old('frecuencia') }}"
                            required>
                        @error('frecuencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="modal_observacion" class="form-label">Observación</label>
                        <textarea name="observacion" id="modal_observacion" class="form-control">{{ old('observacion') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit"
                        style="background-color: #e83e8c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                        Guardar
                    </button>

                </div>
            </form>
        </div>
    </div>

    {{-- Script para reabrir el modal si hay errores --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('createClientModal'));
                modal.show();
            });
        </script>
    @endif
@endsection
