@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Asignaciones de Herramientas</h5>
            <div>
                @can('crear asignaciones')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearAsignacionModal">Nuevo</button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($items->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Herramienta</th>
                            <th>Estilista</th>
                            <th>Recepcionista</th>
                            <th>Fecha asignación</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->herramienta->nombre ?? '-' }}</td>
                            <td>{{ $item->estilista->nombre ?? '-' }}</td>
                            <td>{{ $item->recepcionista->name ?? '-' }}</td>
                            <td>{{ optional($item->fechaAsignacion)->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    @can('ver asignaciones')
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showAsignacionModal-{{ $item->id }}">Ver</button>
                                    @endcan
                                    @can('editar asignaciones')
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAsignacionModal-{{ $item->id }}">Editar</button>
                                    @endcan
                                    @can('eliminar asignaciones')
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAsignacionModal-{{ $item->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showAsignacionModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Herramienta</dt>
                                            <dd class="col-8">{{ $item->herramienta->nombre ?? '-' }}</dd>

                                            <dt class="col-4">Estilista</dt>
                                            <dd class="col-8">{{ $item->estilista->nombre ?? '-' }}</dd>

                                            <dt class="col-4">Recepcionista</dt>
                                            <dd class="col-8">{{ $item->recepcionista->name ?? '-' }}</dd>

                                            <dt class="col-4">Estado entrega</dt>
                                            <dd class="col-8">{{ $item->estadoEntrega ?? '-' }}</dd>

                                            <dt class="col-4">Estado devolución</dt>
                                            <dd class="col-8">{{ $item->estadoDevolucion ?? '-' }}</dd>

                                            <dt class="col-4">Fecha asignación</dt>
                                            <dd class="col-8">{{ optional($item->fechaAsignacion)->format('Y-m-d') }}</dd>

                                            <dt class="col-4">Fecha devolución</dt>
                                            <dd class="col-8">{{ optional($item->fechaDevolucion)->format('Y-m-d') }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editAsignacionModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('asignacion_herramientas.update', $item->id) }}" method="post">
                                        @method('PUT')
                                        @include('asignacion_herramientas._form', ['item' => $item, 'herramientas' => App\Models\Herramienta::orderBy("nombre")->get(), 'estilistas' => App\Models\Estilista::orderBy("nombre")->get(), 'recepcionistas' => App\Models\User::orderBy("name")->get()])
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteAsignacionModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que deseas eliminar la asignación de "{{ $item->herramienta->nombre ?? '-' }}" a "{{ $item->estilista->nombre ?? '-' }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('asignacion_herramientas.destroy', $item->id) }}" method="post" style="display:inline">
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
                {{ $items->links() }}
            </div>

            @else
                <p class="text-muted">No hay asignaciones registradas.</p>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="crearAsignacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Asignación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('asignacion_herramientas.store') }}" method="post">
                    @include('asignacion_herramientas._form', ['herramientas' => App\Models\Herramienta::orderBy("nombre")->get(), 'estilistas' => App\Models\Estilista::orderBy("nombre")->get(), 'recepcionistas' => App\Models\User::orderBy("name")->get()])
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
