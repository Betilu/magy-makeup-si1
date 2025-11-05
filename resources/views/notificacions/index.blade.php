<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Notificaciones</h5>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearNotificacionModal">Nueva Notificación</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($notificacions->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Cita</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Mensaje</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notificacions as $notificacion)
                        <tr>
                            <td>{{ $notificacion->client_id }}</td>
                            <td>{{ $notificacion->cita_id }}</td>
                            <td>{{ $notificacion->estado }}</td>
                            <td>{{ $notificacion->fecha }}</td>
                            <td>{{ Str::limit($notificacion->mensaje, 60) }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showNotificacionModal-{{ $notificacion->id }}">Ver</button>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNotificacionModal-{{ $notificacion->id }}">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNotificacionModal-{{ $notificacion->id }}">Eliminar</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showNotificacionModal-{{ $notificacion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Notificación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Cliente</dt>
                                            <dd class="col-8">{{ $notificacion->client_id }}</dd>

                                            <dt class="col-4">Cita</dt>
                                            <dd class="col-8">{{ $notificacion->cita_id }}</dd>

                                            <dt class="col-4">Estado</dt>
                                            <dd class="col-8">{{ $notificacion->estado }}</dd>

                                            <dt class="col-4">Fecha</dt>
                                            <dd class="col-8">{{ $notificacion->fecha }}</dd>

                                            <dt class="col-4">Mensaje</dt>
                                            <dd class="col-8">{{ $notificacion->mensaje }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editNotificacionModal-{{ $notificacion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Notificación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('notificacions.update', $notificacion->id) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Cliente (ID)</label>
                                                <input type="text" name="client_id" value="{{ old('client_id', $notificacion->client_id) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Cita (ID)</label>
                                                <input type="text" name="cita_id" value="{{ old('cita_id', $notificacion->cita_id) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <input type="text" name="estado" value="{{ old('estado', $notificacion->estado) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" name="fecha" value="{{ old('fecha', $notificacion->fecha) }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mensaje</label>
                                                <textarea name="mensaje" class="form-control">{{ old('mensaje', $notificacion->mensaje) }}</textarea>
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
                        <div class="modal fade" id="deleteNotificacionModal-{{ $notificacion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Notificación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">¿Eliminar esta notificación?</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('notificacions.destroy', $notificacion->id) }}" method="post" style="display:inline">
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
                {{ $notificacions->links() }}
            </div>

            @else
                <p class="text-muted">No hay notificaciones registradas.</p>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="crearNotificacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Notificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('notificacions.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Cliente (ID)</label>
                            <input type="text" name="client_id" value="{{ old('client_id') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cita (ID)</label>
                            <input type="text" name="cita_id" value="{{ old('cita_id') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <input type="text" name="estado" value="{{ old('estado') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mensaje</label>
                            <textarea name="mensaje" class="form-control">{{ old('mensaje') }}</textarea>
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