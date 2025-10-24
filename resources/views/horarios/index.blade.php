@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="card-header"
                style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="font-weight:600;">
                        <svg class="icon me-2" style="width:24px; height:24px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-clock') }}"></use>
                        </svg>
                        Gestión de Horarios
                    </h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal"
                        style="border-radius:10px; font-weight:500;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                        </svg>
                        Nuevo Horario
                    </button>
                </div>
            </div>

            <div class="card-body" style="padding:2rem;">
                {{-- Mensajes de éxito y error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                        style="border-radius:10px; border-left:4px solid #28a745;">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                        style="border-radius:10px; border-left:4px solid #dc3545;">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-x-circle') }}"></use>
                        </svg>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Filtros de búsqueda --}}
                {{-- <div class="card mb-4" style="border:1px solid #dee2e6; border-radius:10px;">
                <div class="card-body">
                    <form action="{{ route('horarios.index') }}" method="GET">
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
                                       placeholder="Buscar por día u hora..."
                                       style="border-radius:10px; border:1px solid #dee2e6;">
                            </div>

                            <div class="col-md-3">
                                <label for="dia" class="form-label" style="font-weight:600; color:#662a5b;">
                                    <svg class="icon me-1">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                                    </svg>
                                    Día de la semana
                                </label>
                                <select class="form-select" id="dia" name="dia" 
                                        style="border-radius:10px; border:1px solid #dee2e6;">
                                    <option value="">Todos los días</option>
                                    <option value="Lunes" {{ request('dia') == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                                    <option value="Martes" {{ request('dia') == 'Martes' ? 'selected' : '' }}>Martes</option>
                                    <option value="Miércoles" {{ request('dia') == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                                    <option value="Jueves" {{ request('dia') == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                                    <option value="Viernes" {{ request('dia') == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                                    <option value="Sábado" {{ request('dia') == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                                    <option value="Domingo" {{ request('dia') == 'Domingo' ? 'selected' : '' }}>Domingo</option>
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
                                <a href="{{ route('horarios.index') }}" class="btn btn-secondary" 
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
            </div> --}}

                {{-- Tabla de horarios --}}
                <div class="table-responsive">
                    <table class="table table-hover" style="border-radius:10px; overflow:hidden;">
                        <thead style="background-color:#f8f9fa;">
                            <tr>
                                {{-- <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">ID</th> --}}
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Día</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Hora Inicio</th>
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Hora Fin</th>
                                {{-- <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Duración</th> --}}
                                <th style="border:none; padding:1rem; font-weight:600; color:#662a5b; text-align:center;">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($horarios as $horario)
                                <tr style="border-bottom:1px solid #f0f0f0;">
                                    {{-- <td style="padding:1rem; vertical-align:middle;">{{ $horario->id }}</td> --}}
                                    <td style="padding:1rem; vertical-align:middle;">
                                        <span class="badge bg-primary"
                                            style="padding:0.5rem 1rem; border-radius:8px; font-weight:500;">
                                            {{ $horario->dia }}
                                        </span>
                                    </td>
                                    <td style="padding:1rem; vertical-align:middle;">
                                        <svg class="icon me-1" style="width:16px; height:16px; color:#662a5b;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-alarm') }}"></use>
                                        </svg>
                                        {{ $horario->horaInicio }}
                                    </td>
                                    <td style="padding:1rem; vertical-align:middle;">
                                        <svg class="icon me-1" style="width:16px; height:16px; color:#662a5b;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-alarm') }}"></use>
                                        </svg>
                                        {{ $horario->horaFin }}
                                    </td>
                                    {{-- <td style="padding:1rem; vertical-align:middle;">
                                        @php
                                            $inicio = \Carbon\Carbon::parse($horario->horaInicio);
                                            $fin = \Carbon\Carbon::parse($horario->horaFin);
                                            $duracion = $inicio->diffInHours($fin);
                                        @endphp
                                        <span class="badge bg-info" style="padding:0.5rem 1rem; border-radius:8px;">
                                            {{ $duracion }} {{ $duracion == 1 ? 'hora' : 'horas' }}
                                        </span>
                                    </td> --}}
                                    <td style="padding:1rem; vertical-align:middle; text-align:center;">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info"
                                                style="border-radius:8px 0 0 8px;" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $horario->id }}" title="Ver">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $horario->id }}" title="Editar">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                style="border-radius:0 8px 8px 0;" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $horario->id }}" title="Eliminar">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Ver --}}
                                <div class="modal fade" id="showModal{{ $horario->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius:15px; border:none;">
                                            <div class="modal-header"
                                                style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                                <h5 class="modal-title">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
                                                    </svg>
                                                    Detalles del Horario
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="padding:2rem;">
                                                <div class="mb-3">
                                                    <div class="p-3"
                                                        style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label
                                                            style="font-weight:600; color:#662a5b; font-size:0.875rem;">DÍA</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">
                                                            {{ $horario->dia }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <div class="p-3"
                                                            style="background-color:#f8f9fa; border-radius:10px;">
                                                            <label
                                                                style="font-weight:600; color:#662a5b; font-size:0.875rem;">HORA
                                                                INICIO</label>
                                                            <p class="mb-0 mt-2" style="font-size:1.1rem;">
                                                                {{ $horario->horaInicio }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <div class="p-3"
                                                            style="background-color:#f8f9fa; border-radius:10px;">
                                                            <label
                                                                style="font-weight:600; color:#662a5b; font-size:0.875rem;">HORA
                                                                FIN</label>
                                                            <p class="mb-0 mt-2" style="font-size:1.1rem;">
                                                                {{ $horario->horaFin }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <div class="p-3"
                                                        style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label
                                                            style="font-weight:600; color:#662a5b; font-size:0.875rem;">DURACIÓN</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">
                                                            {{ $duracion }} {{ $duracion == 1 ? 'hora' : 'horas' }}
                                                        </p>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    style="border-radius:10px;">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Editar --}}
                                <div class="modal fade" id="editModal{{ $horario->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius:15px; border:none;">
                                            <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header"
                                                    style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                                    <h5 class="modal-title">
                                                        <svg class="icon me-2">
                                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}">
                                                            </use>
                                                        </svg>
                                                        Editar Horario
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body" style="padding:2rem;">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            style="font-weight:600; color:#662a5b;">Día *</label>
                                                        <select name="dia" class="form-select" required
                                                            style="border-radius:10px;">
                                                            <option value="Lunes"
                                                                {{ $horario->dia == 'Lunes' ? 'selected' : '' }}>Lunes
                                                            </option>
                                                            <option value="Martes"
                                                                {{ $horario->dia == 'Martes' ? 'selected' : '' }}>Martes
                                                            </option>
                                                            <option value="Miércoles"
                                                                {{ $horario->dia == 'Miércoles' ? 'selected' : '' }}>
                                                                Miércoles</option>
                                                            <option value="Jueves"
                                                                {{ $horario->dia == 'Jueves' ? 'selected' : '' }}>Jueves
                                                            </option>
                                                            <option value="Viernes"
                                                                {{ $horario->dia == 'Viernes' ? 'selected' : '' }}>Viernes
                                                            </option>
                                                            <option value="Sábado"
                                                                {{ $horario->dia == 'Sábado' ? 'selected' : '' }}>Sábado
                                                            </option>
                                                            <option value="Domingo"
                                                                {{ $horario->dia == 'Domingo' ? 'selected' : '' }}>Domingo
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            style="font-weight:600; color:#662a5b;">Hora Inicio *</label>
                                                        <input type="time" name="horaInicio" class="form-control"
                                                            value="{{ $horario->horaInicio }}" required
                                                            style="border-radius:10px;">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            style="font-weight:600; color:#662a5b;">Hora Fin *</label>
                                                        <input type="time" name="horaFin" class="form-control"
                                                            value="{{ $horario->horaFin }}" required
                                                            style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                        style="border-radius:10px;">Cancelar</button>
                                                    <button type="submit" class="btn text-white"
                                                        style="background-color:#662a5b; border-radius:10px;">
                                                        <svg class="icon me-1">
                                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-check') }}">
                                                            </use>
                                                        </svg>
                                                        Actualizar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Eliminar --}}
                                <div class="modal fade" id="deleteModal{{ $horario->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius:15px; border:none;">
                                            <div class="modal-header"
                                                style="background-color:#dc3545; color:white; border-radius:15px 15px 0 0;">
                                                <h5 class="modal-title">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                    </svg>
                                                    Confirmar Eliminación
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="padding:2rem;">
                                                <p>¿Está seguro de eliminar el horario
                                                    <strong>{{ $horario->dia }}</strong>?</p>
                                                <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    style="border-radius:10px;">Cancelar</button>
                                                <form action="{{ route('horarios.destroy', $horario->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        style="border-radius:10px;">
                                                        <svg class="icon me-1">
                                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}">
                                                            </use>
                                                        </svg>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center" style="padding:3rem; color:#999;">
                                        <svg class="icon mb-3" style="width:48px; height:48px; color:#ccc;">
                                            <use xlink:href="{{ asset('icons/coreui.svg#cil-clock') }}"></use>
                                        </svg>
                                        <p class="mb-0">
                                            @if (request('search') || request('dia'))
                                                No se encontraron horarios con los criterios de búsqueda.
                                            @else
                                                No hay horarios registrados.
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
                    {{ $horarios->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Crear --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:15px; border:none;">
                <form action="{{ route('horarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                        <h5 class="modal-title">
                            <svg class="icon me-2">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                            </svg>
                            Nuevo Horario
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="padding:2rem;">
                        {{-- <div class="mb-3">
                        <label for="dia" class="form-label" style="font-weight:600; color:#662a5b;">Día de la semana *</label>
                        <select name="dia" id="dia" class="form-select @error('dia') is-invalid @enderror" required style="border-radius:10px;">
                            <option value="">Seleccione un día</option>
                            <option value="Lunes" {{ old('dia') == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                            <option value="Martes" {{ old('dia') == 'Martes' ? 'selected' : '' }}>Martes</option>
                            <option value="Miércoles" {{ old('dia') == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                            <option value="Jueves" {{ old('dia') == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                            <option value="Viernes" {{ old('dia') == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                            <option value="Sábado" {{ old('dia') == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                            <option value="Domingo" {{ old('dia') == 'Domingo' ? 'selected' : '' }}>Domingo</option>
                        </select>
                        @error('dia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Día</label>
                            <input type="text" name="dia" class="form-control" required>
                            @error('dia')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="horaInicio" class="form-label" style="font-weight:600; color:#662a5b;">Hora de
                                Inicio *</label>
                            <input type="time" name="horaInicio" id="horaInicio"
                                class="form-control @error('horaInicio') is-invalid @enderror"
                                value="{{ old('horaInicio') }}" required style="border-radius:10px;">
                            @error('horaInicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="horaFin" class="form-label" style="font-weight:600; color:#662a5b;">Hora de Fin
                                *</label>
                            <input type="time" name="horaFin" id="horaFin"
                                class="form-control @error('horaFin') is-invalid @enderror" value="{{ old('horaFin') }}"
                                required style="border-radius:10px;">
                            @error('horaFin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius:10px;">Cancelar</button>
                        <button type="submit" class="btn text-white"
                            style="background-color:#662a5b; border-radius:10px;">
                            <svg class="icon me-1">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-check') }}"></use>
                            </svg>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para reabrir el modal si hay errores --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('createModal'));
                modal.show();
            });
        </script>
    @endif
@endsection
