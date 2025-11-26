@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:20px; height:20px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use>
                    </svg>
                    Gestión de Incidencias
                </h4>
                @if(auth()->user()->can('crear incidencias') || auth()->user()->can('reportar incidencia'))
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createIncidenciaModal" style="border-radius:8px; font-weight:500;">
                        <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use></svg>
                        Nueva Incidencia
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body" style="padding:1.5rem;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #28a745;">
                    <svg class="icon me-2"><use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use></svg>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" style="border-radius:8px; overflow:hidden;">
                    <thead style="background-color:#f8f9fa;">
                        <tr>
                            <th style="font-weight:600;">Herramienta</th>
                            <th style="font-weight:600;">Tipo Incidente</th>
                            <th style="font-weight:600;">Descripción</th>
                            <th style="font-weight:600;">Fecha Incidente</th>
                            <th style="font-weight:600;">Fecha Remplazo</th>
                            <th style="text-align:center; font-weight:600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidencias as $incidencia)
                            <tr>
                                <td>{{ $incidencia->herramienta->nombre ?? '-' }}</td>
                                <td>
                                    @if($incidencia->tipo_incidente === 'En revisión')
                                        <span class="badge bg-warning text-dark">En revisión</span>
                                    @elseif($incidencia->tipo_incidente === 'Dañada')
                                        <span class="badge bg-danger">Dañada</span>
                                    @elseif($incidencia->tipo_incidente === 'Perdida')
                                        <span class="badge bg-dark">Perdida</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($incidencia->descripcion, 50) }}</td>
                                <td>{{ $incidencia->fechaIncidente->format('Y-m-d') }}</td>
                                <td>{{ $incidencia->fechaRemplazo ? $incidencia->fechaRemplazo->format('Y-m-d') : '-' }}</td>
                                <td style="text-align:center;">
                                    @can('ver incidencias')
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#showModal{{ $incidencia->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use></svg>
                                            Ver
                                        </button>
                                    @endcan

                                    @can('editar incidencias')
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{ $incidencia->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use></svg>
                                            Editar
                                        </button>
                                    @endcan

                                    @can('eliminar incidencias')
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $incidencia->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use></svg>
                                            Eliminar
                                        </button>
                                    @endcan
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            @can('ver incidencias')
                            <div class="modal fade" id="showModal{{ $incidencia->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background:#f8f9fa;">
                                            <h5 class="modal-title">Detalle Incidencia</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <dl class="row">
                                                <dt class="col-4">Herramienta:</dt>
                                                <dd class="col-8">{{ $incidencia->herramienta->nombre ?? 'No asignada' }}</dd>

                                                <dt class="col-4">Tipo Incidente:</dt>
                                                <dd class="col-8">
                                                    @if($incidencia->tipo_incidente === 'En revisión')
                                                        <span class="badge bg-warning text-dark">En revisión</span>
                                                    @elseif($incidencia->tipo_incidente === 'Dañada')
                                                        <span class="badge bg-danger">Dañada</span>
                                                    @elseif($incidencia->tipo_incidente === 'Perdida')
                                                        <span class="badge bg-dark">Perdida</span>
                                                    @endif
                                                </dd>

                                                <dt class="col-4">Descripción:</dt>
                                                <dd class="col-8">{{ $incidencia->descripcion }}</dd>

                                                <dt class="col-4">Fecha Incidente:</dt>
                                                <dd class="col-8">{{ $incidencia->fechaIncidente->format('Y-m-d') }}</dd>

                                                <dt class="col-4">Fecha Remplazo:</dt>
                                                <dd class="col-8">{{ $incidencia->fechaRemplazo ? $incidencia->fechaRemplazo->format('Y-m-d') : 'No registrada' }}</dd>
                                            </dl>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Editar -->
                            @can('editar incidencias')
                            <div class="modal fade" id="editModal{{ $incidencia->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('incidencias.update', $incidencia) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header" style="background:#f8f9fa;">
                                                <h5 class="modal-title">Editar Incidencia</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('incidencias._form', ['incidencia' => $incidencia])
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Eliminar -->
                            @can('eliminar incidencias')
                            <div class="modal fade" id="deleteModal{{ $incidencia->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Deseas eliminar esta incidencia?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay incidencias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $incidencias->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Incidencia -->
@if(auth()->user()->can('crear incidencias') || auth()->user()->can('reportar incidencia'))
<div class="modal fade" id="createIncidenciaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('incidencias.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background:#f8f9fa;">
                    <h5 class="modal-title">Nueva Incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('incidencias._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var createModal = new bootstrap.Modal(document.getElementById('createIncidenciaModal'));
        createModal.show();
    });
</script>
@endif

@endsection
