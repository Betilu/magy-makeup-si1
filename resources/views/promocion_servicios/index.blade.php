@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:28px; height:28px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-link') }}"></use></svg>
                    Asignaciones Promoción - Servicio
                </h4>
                <div>
                    @can('crear asignaciones')
                    <button class="btn btn-light" style="font-weight:500;" data-bs-toggle="modal" data-bs-target="#crearPromocionServicioModal">
                        <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use></svg>
                        Nuevo
                    </button>
                    @endcan
                </div>
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
                            <th>Servicio</th>
                            <th>Promoción</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->servicio->nombre ?? '-' }}</td>
                            <td>{{ $item->promocion->nombre ?? '-' }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    @can('ver asignaciones')
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showPromocionServicioModal-{{ $item->id }}">Ver</button>
                                    @endcan
                                    @can('editar asignaciones')
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPromocionServicioModal-{{ $item->id }}">Editar</button>
                                    @endcan
                                    @can('eliminar asignaciones')
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePromocionServicioModal-{{ $item->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        <div class="modal fade" id="showPromocionServicioModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Servicio:</strong> {{ $item->servicio->nombre ?? '-' }}</p>
                                        <p><strong>Promoción:</strong> {{ $item->promocion->nombre ?? '-' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPromocionServicioModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('promocion_servicios.update', $item->id) }}" method="post">
                                        @method('PUT')
                                        @include('promocion_servicios._form', ['item' => $item, 'servicios' => App\Models\Servicio::orderBy("nombre")->get(), 'promocions' => App\Models\Promocion::orderBy("nombre")->get()])
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deletePromocionServicioModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Asignación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que deseas eliminar la asignación entre "{{ $item->servicio->nombre ?? '-' }}" y "{{ $item->promocion->nombre ?? '-' }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('promocion_servicios.destroy', $item->id) }}" method="post" style="display:inline">
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
    <div class="modal fade" id="crearPromocionServicioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Asignación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('promocion_servicios.store') }}" method="post">
                    @include('promocion_servicios._form', ['servicios' => App\Models\Servicio::orderBy("nombre")->get(), 'promocions' => App\Models\Promocion::orderBy("nombre")->get()])
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
