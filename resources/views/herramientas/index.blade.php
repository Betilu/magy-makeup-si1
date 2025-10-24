@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:24px; height:24px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-wrench') }}"></use>
                    </svg>
                    Gestión de Herramientas
                </h4>
                @can('crear herramientas')
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal" style="border-radius:10px; font-weight:500;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                        </svg>
                        Nueva Herramienta
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body" style="padding:2rem;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #28a745;">
                    <svg class="icon me-2">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                    </svg>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #dc3545;">
                    <svg class="icon me-2">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-x-circle') }}"></use>
                    </svg>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" style="border-radius:10px; overflow:hidden;">
                    <thead style="background-color:#f8f9fa;">
                        <tr>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Nombre</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Tipo</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Marca</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Modelo</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Estado</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Fecha Adquisición</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b; text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($herramientas as $herramienta)
                            <tr style="border-bottom:1px solid #f0f0f0;">
                                <td style="padding:1rem; vertical-align:middle;">{{ $herramienta->nombre }}</td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $herramienta->tipo }}</td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $herramienta->marca }}</td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $herramienta->modelo }}</td>
                                <td style="padding:1rem; vertical-align:middle;">
                                    @php
                                        $badgeClass = match($herramienta->estadoHerramienta) {
                                            'Disponible' => 'success',
                                            'En uso' => 'primary',
                                            'En mantenimiento' => 'warning',
                                            'Fuera de servicio' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}" style="padding:0.5rem 1rem; border-radius:8px; font-weight:500;">
                                        {{ $herramienta->estadoHerramienta }}
                                    </span>
                                </td>
                                <td style="padding:1rem; vertical-align:middle;">
                                    {{ \Carbon\Carbon::parse($herramienta->fechaAdquisicion)->format('d/m/Y') }}
                                </td>
                                <td style="padding:1rem; vertical-align:middle; text-align:center;">
                                    <div class="btn-group" role="group">
                                        @can('ver herramientas')
                                            <button type="button" class="btn btn-sm btn-secondary" style="color: black; border-radius:8px 0 0 8px;" 
                                                    data-bs-toggle="modal" data-bs-target="#showModal{{ $herramienta->id }}" title="Ver">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use>
                                                </svg>
                                                Ver
                                            </button>
                                        @endcan
                                        @can('editar herramientas')
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $herramienta->id }}" title="Editar">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('eliminar herramientas')
                                            <button type="button" class="btn btn-sm btn-danger" style="border-radius:0 8px 8px 0;" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $herramienta->id }}" title="Eliminar">
                                                <svg class="icon">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            @can('ver herramientas')
                            <div class="modal fade" id="showModal{{ $herramienta->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border-radius:15px; border:none;">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                            <h5 class="modal-title">
                                                <svg class="icon me-2">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
                                                </svg>
                                                Detalles de Herramienta
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="padding:2rem;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">NOMBRE</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $herramienta->nombre }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">TIPO</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $herramienta->tipo }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">MARCA</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $herramienta->marca }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">MODELO</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $herramienta->modelo }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">FECHA ADQUISICIÓN</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ \Carbon\Carbon::parse($herramienta->fechaAdquisicion)->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">ESTADO</label>
                                                        <p class="mb-0 mt-2">
                                                            <span class="badge bg-{{ $badgeClass }}" style="padding:0.5rem 1rem; border-radius:8px; font-size:1rem;">
                                                                {{ $herramienta->estadoHerramienta }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($herramienta->observacion)
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">OBSERVACIONES</label>
                                                        <p class="mb-0 mt-2">{{ $herramienta->observacion }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Editar -->
                            @can('editar herramientas')
                            <div class="modal fade" id="editModal{{ $herramienta->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border-radius:15px; border:none;">
                                        <form action="{{ route('herramientas.update', $herramienta->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                                <h5 class="modal-title">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                                    </svg>
                                                    Editar Herramienta
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="padding:2rem;">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="nombre{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Nombre *</label>
                                                        <input type="text" class="form-control" id="nombre{{ $herramienta->id }}" name="nombre" value="{{ $herramienta->nombre }}" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="tipo{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Tipo *</label>
                                                        <input type="text" class="form-control" id="tipo{{ $herramienta->id }}" name="tipo" value="{{ $herramienta->tipo }}" required style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="marca{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Marca *</label>
                                                        <input type="text" class="form-control" id="marca{{ $herramienta->id }}" name="marca" value="{{ $herramienta->marca }}" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="modelo{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Modelo *</label>
                                                        <input type="text" class="form-control" id="modelo{{ $herramienta->id }}" name="modelo" value="{{ $herramienta->modelo }}" required style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="fechaAdquisicion{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Fecha Adquisición *</label>
                                                        <input type="date" class="form-control" id="fechaAdquisicion{{ $herramienta->id }}" name="fechaAdquisicion" value="{{ $herramienta->fechaAdquisicion }}" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="estadoHerramienta{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Estado *</label>
                                                        <select class="form-select" id="estadoHerramienta{{ $herramienta->id }}" name="estadoHerramienta" required style="border-radius:10px;">
                                                            <option value="Disponible" {{ $herramienta->estadoHerramienta == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                                            <option value="En uso" {{ $herramienta->estadoHerramienta == 'En uso' ? 'selected' : '' }}>En uso</option>
                                                            <option value="En mantenimiento" {{ $herramienta->estadoHerramienta == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                                            <option value="Fuera de servicio" {{ $herramienta->estadoHerramienta == 'Fuera de servicio' ? 'selected' : '' }}>Fuera de servicio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="observacion{{ $herramienta->id }}" class="form-label" style="font-weight:600; color:#662a5b;">Observaciones</label>
                                                    <textarea class="form-control" id="observacion{{ $herramienta->id }}" name="observacion" rows="3" style="border-radius:10px;">{{ $herramienta->observacion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancelar</button>
                                                <button type="submit" class="btn text-white" style="background-color:#662a5b; border-radius:10px;">
                                                    <svg class="icon me-1">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-check') }}"></use>
                                                    </svg>
                                                    Actualizar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Eliminar -->
                            @can('eliminar herramientas')
                            <div class="modal fade" id="deleteModal{{ $herramienta->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius:15px; border:none;">
                                        <div class="modal-header" style="background-color:#dc3545; color:white; border-radius:15px 15px 0 0;">
                                            <h5 class="modal-title">
                                                <svg class="icon me-2">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                </svg>
                                                Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="padding:2rem;">
                                            <p>¿Está seguro de eliminar la herramienta <strong>{{ $herramienta->nombre }}</strong>?</p>
                                            <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancelar</button>
                                            <form action="{{ route('herramientas.destroy', $herramienta->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="border-radius:10px;">
                                                    <svg class="icon me-1">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding:3rem; color:#999;">
                                    <svg class="icon mb-3" style="width:48px; height:48px; color:#ccc;">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-wrench') }}"></use>
                                    </svg>
                                    <p class="mb-0">No hay herramientas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $herramientas->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
@can('crear herramientas')
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:15px; border:none;">
            <form action="{{ route('herramientas.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                    <h5 class="modal-title">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                        </svg>
                        Nueva Herramienta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:2rem;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label" style="font-weight:600; color:#662a5b;">Nombre *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required style="border-radius:10px;">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label" style="font-weight:600; color:#662a5b;">Tipo *</label>
                            <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo') }}" required style="border-radius:10px;">
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label" style="font-weight:600; color:#662a5b;">Marca *</label>
                            <input type="text" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ old('marca') }}" required style="border-radius:10px;">
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label" style="font-weight:600; color:#662a5b;">Modelo *</label>
                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{ old('modelo') }}" required style="border-radius:10px;">
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaAdquisicion" class="form-label" style="font-weight:600; color:#662a5b;">Fecha de Adquisición *</label>
                            <input type="date" class="form-control @error('fechaAdquisicion') is-invalid @enderror" id="fechaAdquisicion" name="fechaAdquisicion" value="{{ old('fechaAdquisicion') }}" required style="border-radius:10px;">
                            @error('fechaAdquisicion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estadoHerramienta" class="form-label" style="font-weight:600; color:#662a5b;">Estado *</label>
                            <select class="form-select @error('estadoHerramienta') is-invalid @enderror" id="estadoHerramienta" name="estadoHerramienta" required style="border-radius:10px;">
                                <option value="">Seleccione un estado</option>
                                <option value="Disponible" {{ old('estadoHerramienta') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="En uso" {{ old('estadoHerramienta') == 'En uso' ? 'selected' : '' }}>En uso</option>
                                <option value="En mantenimiento" {{ old('estadoHerramienta') == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                <option value="Fuera de servicio" {{ old('estadoHerramienta') == 'Fuera de servicio' ? 'selected' : '' }}>Fuera de servicio</option>
                            </select>
                            @error('estadoHerramienta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacion" class="form-label" style="font-weight:600; color:#662a5b;">Observaciones</label>
                        <textarea class="form-control @error('observacion') is-invalid @enderror" id="observacion" name="observacion" rows="3" style="border-radius:10px;">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
</div>
@endcan

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var createModal = new bootstrap.Modal(document.getElementById('createModal'));
        createModal.show();
    });
</script>
@endif

@endsection