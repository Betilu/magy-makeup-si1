@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="font-weight:600;">
                        <svg class="icon me-2" style="width:24px; height:24px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                        </svg>
                        Gestión de Clientes
                    </h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createClientModal" 
                            style="border-radius:10px; font-weight:500;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                        </svg>
                        Agregar Cliente
                    </button>
                </div>
            </div>

            <div class="card-body" style="padding:2rem;">
                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #28a745;">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Mensaje de error --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #dc3545;">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-x-circle') }}"></use>
                        </svg>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Filtros de búsqueda --}}
                <div class="card mb-4" style="border:1px solid #dee2e6; border-radius:10px;">
                    <div class="card-body">
                        <form action="{{ route('clients.index') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="search" class="form-label" style="font-weight:600; color:#662a5b;">
                                        <svg class="icon me-1">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-magnifying-glass') }}"></use>
                                        </svg>
                                        Buscar
                                    </label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Nombre, email, teléfono o dirección..."
                                           style="border-radius:10px; border:1px solid #dee2e6;">
                                </div>

                                <div class="col-md-3">
                                    <label for="frecuencia" class="form-label" style="font-weight:600; color:#662a5b;">
                                        <svg class="icon me-1">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                                        </svg>
                                        Frecuencia
                                    </label>
                                    <select class="form-select" id="frecuencia" name="frecuencia" 
                                            style="border-radius:10px; border:1px solid #dee2e6;">
                                        <option value="">Todas</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('frecuencia') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i == 1 ? 'vez' : 'veces' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn text-white" 
                                            style="background-color:#662a5b; border-radius:10px; padding:0.6rem 1.5rem;">
                                        <svg class="icon me-1">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-filter') }}"></use>
                                        </svg>
                                        Filtrar
                                    </button>
                                    <a href="{{ route('clients.index') }}" class="btn btn-secondary" 
                                       style="border-radius:10px; padding:0.6rem 1.5rem;">
                                        <svg class="icon me-1">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-x') }}"></use>
                                        </svg>
                                        Limpiar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabla de clientes --}}
                <div class="table-responsive">
                    <table class="table table-hover" style="border-radius:10px; overflow:hidden;">
                        <thead style="background-color:#f8f9fa;">
                            <tr>
                                {{-- <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">ID</th> --}}
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Nombre</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Email</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Teléfono</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Dirección</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Frecuencia</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Observación</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b; text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr style="border-bottom:1px solid #f0f0f0;">
                                    {{-- <td style="padding:1rem; vertical-align:middle;">{{ $client->id }}</td> --}}
                                    <td style="padding:1rem; vertical-align:middle;">{{ $client->user->name }}</td>
                                    <td style="padding:1rem; vertical-align:middle;">{{ $client->user->email }}</td>
                                    <td style="padding:1rem; vertical-align:middle;">{{ $client->user->telefono }}</td>
                                    <td style="padding:1rem; vertical-align:middle;">{{ $client->direccion }}</td>
                                    <td style="padding:1rem; vertical-align:middle;">
                                        <span class="badge bg-primary" style="padding:0.5rem 1rem; border-radius:8px;">
                                            {{ $client->frecuencia }}
                                        </span>
                                    </td>
                                    <td style="padding:1rem; vertical-align:middle;">{{ $client->observacion ?? '—' }}</td>
                                    <td style="padding:1rem; vertical-align:middle; text-align:center;">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info" 
                                               style="border-radius:8px 0 0 8px;" title="Ver">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use>
                                                </svg>
                                            </a>
                                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                                </svg>
                                            </a>
                                            <form action="{{ route('clients.destroy', $client) }}" method="POST" 
                                                  style="display:inline;" onsubmit="return confirm('¿Eliminar este cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        style="border-radius:0 8px 8px 0;" title="Eliminar">
                                                    <svg class="icon">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center" style="padding:3rem; color:#999;">
                                        <svg class="icon mb-3" style="width:48px; height:48px; color:#ccc;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                                        </svg>
                                        <p class="mb-0">
                                            @if(request('search') || request('frecuencia'))
                                                No se encontraron clientes con los criterios de búsqueda.
                                            @else
                                                No hay clientes registrados.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de creación de cliente --}}
    <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('clients.store') }}" method="POST" class="modal-content" style="border-radius:15px; border:none;">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                    <h5 class="modal-title" id="createClientModalLabel">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-user-plus') }}"></use>
                        </svg>
                        Agregar Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding:2rem;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_name" class="form-label" style="font-weight:600; color:#662a5b;">Nombre Completo *</label>
                            <input type="text" name="name" id="modal_name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required style="border-radius:10px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_email" class="form-label" style="font-weight:600; color:#662a5b;">Correo Electrónico *</label>
                            <input type="email" name="email" id="modal_email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required style="border-radius:10px;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_password" class="form-label" style="font-weight:600; color:#662a5b;">Contraseña *</label>
                            <input type="password" name="password" id="modal_password"
                                class="form-control @error('password') is-invalid @enderror" required style="border-radius:10px;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_password_confirmation" class="form-label" style="font-weight:600; color:#662a5b;">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" id="modal_password_confirmation"
                                class="form-control" required style="border-radius:10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_telefono" class="form-label" style="font-weight:600; color:#662a5b;">Teléfono *</label>
                            <input type="number" name="telefono" id="modal_telefono"
                                class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}"
                                required style="border-radius:10px;">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_frecuencia" class="form-label" style="font-weight:600; color:#662a5b;">Frecuencia *</label>
                            <input type="number" name="frecuencia" id="modal_frecuencia"
                                class="form-control @error('frecuencia') is-invalid @enderror" value="{{ old('frecuencia') }}"
                                required min="1" style="border-radius:10px;">
                            @error('frecuencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_direccion" class="form-label" style="font-weight:600; color:#662a5b;">Dirección *</label>
                        <input type="text" name="direccion" id="modal_direccion"
                            class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}"
                            required style="border-radius:10px;">
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="modal_observacion" class="form-label" style="font-weight:600; color:#662a5b;">Observación</label>
                        <textarea name="observacion" id="modal_observacion" class="form-control" rows="3" 
                                  style="border-radius:10px;">{{ old('observacion') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color:#662a5b; border-radius:10px;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-check') }}"></use>
                        </svg>
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
