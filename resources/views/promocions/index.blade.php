@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:28px; height:28px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-gift') }}"></use></svg>
                    Promociones
                </h4>
                <div>
                    @can('crear promociones')
                    <button class="btn btn-light" style="font-weight:500;" data-bs-toggle="modal" data-bs-target="#crearPromocionModal">
                        <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use></svg>
                        Nuevo Promoción
                    </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($promocions->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Descuento</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promocions as $promocion)
                        <tr>
                            <td>{{ $promocion->nombre }}</td>
                            <td>{{ optional($promocion->fechaInicio)->format('Y-m-d') }}</td>
                            <td>{{ optional($promocion->fechaFin)->format('Y-m-d') }}</td>
                            <td>{{ $promocion->descuento }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    @can('ver promociones')
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showPromocionModal-{{ $promocion->id }}">Ver</button>
                                    @endcan
                                    @can('editar promociones')
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPromocionModal-{{ $promocion->id }}">Editar</button>
                                    @endcan
                                    @can('eliminar promociones')
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePromocionModal-{{ $promocion->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showPromocionModal-{{ $promocion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Promoción</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Nombre</dt>
                                            <dd class="col-8">{{ $promocion->nombre }}</dd>

                                            <dt class="col-4">Descripción</dt>
                                            <dd class="col-8">{{ $promocion->descripcion }}</dd>

                                            <dt class="col-4">Fecha inicio</dt>
                                            <dd class="col-8">{{ optional($promocion->fechaInicio)->format('Y-m-d') }}</dd>

                                            <dt class="col-4">Fecha fin</dt>
                                            <dd class="col-8">{{ optional($promocion->fechaFin)->format('Y-m-d') }}</dd>

                                            <dt class="col-4">Descuento</dt>
                                            <dd class="col-8">{{ $promocion->descuento }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPromocionModal-{{ $promocion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Promoción</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('promocions.update', $promocion->id) }}" method="post">
                                        @method('PUT')
                                        @include('promocions._form', ['promocion' => $promocion])
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deletePromocionModal-{{ $promocion->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Promoción</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que deseas eliminar la promoción "{{ $promocion->nombre }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('promocions.destroy', $promocion->id) }}" method="post" style="display:inline">
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
                {{ $promocions->links() }}
            </div>

            @else
                <p class="text-muted">No hay promociones registradas.</p>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="crearPromocionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Promoción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('promocions.store') }}" method="post">
                    @include('promocions._form')
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
