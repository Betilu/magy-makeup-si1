@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:20px; height:20px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-basket') }}"></use>
                    </svg>
                    Servicios
                </h4>
                <div>
                    @can('crear servicios')
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#crearServicioModal" style="border-radius:8px; font-weight:500;">Nuevo Servicio</button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($servicios->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Duración</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->categoria }}</td>
                            <td>{{ $servicio->duracion }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    @can('ver servicios')
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showServicioModal-{{ $servicio->id }}">Ver</button>
                                    @endcan
                                    @can('editar servicios')
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editServicioModal-{{ $servicio->id }}">Editar</button>
                                    @endcan
                                    @can('eliminar servicios')
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteServicioModal-{{ $servicio->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showServicioModal-{{ $servicio->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Servicio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Nombre</dt>
                                            <dd class="col-8">{{ $servicio->nombre }}</dd>

                                            <dt class="col-4">Categoría</dt>
                                            <dd class="col-8">{{ $servicio->categoria }}</dd>

                                            <dt class="col-4">Descripción</dt>
                                            <dd class="col-8">{{ $servicio->descripcion }}</dd>

                                            <dt class="col-4">Duración</dt>
                                            <dd class="col-8">{{ $servicio->duracion }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editServicioModal-{{ $servicio->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Servicio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('servicios.update', $servicio->id) }}" method="post">
                                        @method('PUT')
                                        @include('servicios._form', ['servicio' => $servicio])
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteServicioModal-{{ $servicio->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Servicio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que deseas eliminar el servicio "{{ $servicio->nombre }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="post" style="display:inline">
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
                {{ $servicios->links() }}
            </div>

            @else
                <p class="text-muted">No hay servicios registrados.</p>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="crearServicioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('servicios.store') }}" method="post">
                    @include('servicios._form')
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
