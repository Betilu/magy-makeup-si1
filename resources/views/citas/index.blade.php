<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Citas</h5>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCitaModal">Nueva Cita</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($citas->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Anticipo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->user_id }}</td>
                            <td>{{ $cita->estado }}</td>
                            <td>${{ number_format($cita->anticipo ?? 0, 2) }}</td>
                            <td>{{ optional($cita->fecha)->format ? $cita->fecha : $cita->fecha }}</td>
                            <td>{{ $cita->hora }}</td>
                            <td>{{ $cita->tipo }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showCitaModal-{{ $cita->id }}">Ver</button>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCitaModal-{{ $cita->id }}">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCitaModal-{{ $cita->id }}">Eliminar</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showCitaModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Usuario</dt>
                                            <dd class="col-8">{{ $cita->user_id }}</dd>

                                            <dt class="col-4">Estado</dt>
                                            <dd class="col-8">{{ $cita->estado }}</dd>

                                            <dt class="col-4">Anticipo</dt>
                                            <dd class="col-8">${{ number_format($cita->anticipo ?? 0, 2) }}</dd>

                                            <dt class="col-4">Fecha</dt>
                                            <dd class="col-8">{{ $cita->fecha }}</dd>

                                            <dt class="col-4">Hora</dt>
                                            <dd class="col-8">{{ $cita->hora }}</dd>

                                            <dt class="col-4">Tipo</dt>
                                            <dd class="col-8">{{ $cita->tipo }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editCitaModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('citas.update', $cita->id) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Usuario (ID)</label>
                                                <input type="text" name="user_id" value="{{ old('user_id', $cita->user_id) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <input type="text" name="estado" value="{{ old('estado', $cita->estado) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Anticipo</label>
                                                <input type="number" step="0.01" name="anticipo" value="{{ old('anticipo', $cita->anticipo) }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Fecha</label>
                                                    <input type="date" name="fecha" value="{{ old('fecha', $cita->fecha) }}" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Hora</label>
                                                    <input type="time" name="hora" value="{{ old('hora', $cita->hora) }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tipo</label>
                                                <input type="text" name="tipo" value="{{ old('tipo', $cita->tipo) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteCitaModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">¿Seguro que deseas eliminar esta cita?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('citas.destroy', $cita->id) }}" method="post" style="display:inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $citas->links() }}
            </div>

            @else
                <p class="text-muted">No hay citas registradas.</p>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="crearCitaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('citas.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Usuario (ID)</label>
                            <input type="text" name="user_id" value="{{ old('user_id') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <input type="text" name="estado" value="{{ old('estado') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anticipo</label>
                            <input type="number" step="0.01" name="anticipo" value="{{ old('anticipo') }}" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora</label>
                                <input type="time" name="hora" value="{{ old('hora') }}" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <input type="text" name="tipo" value="{{ old('tipo') }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection