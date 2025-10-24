@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:24px; height:24px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                    </svg>
                    Gestión de Estilistas
                </h4>
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createEstilistaModal" 
                        style="border-radius:10px; font-weight:500;">
                    <svg class="icon me-1">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use>
                    </svg>
                    Agregar Estilista
                </button>
            </div>
        </div>

        <div class="card-body" style="padding:2rem;">
            {{-- Mensajes de éxito y error --}}
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

            {{-- Filtros de búsqueda --}}
            <div class="card mb-4" style="border:1px solid #dee2e6; border-radius:10px;">
                <div class="card-body">
                    <form action="{{ route('estilistas.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label" style="font-weight:600; color:#662a5b;">
                                    <svg class="icon me-1">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-magnifying-glass') }}"></use>
                                    </svg>
                                    Buscar
                                </label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Nombre, email o especialidad..."
                                       style="border-radius:10px; border:1px solid #dee2e6;">
                            </div>

                            <div class="col-md-3">
                                <label for="calificacion" class="form-label" style="font-weight:600; color:#662a5b;">
                                    <svg class="icon me-1">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                                    </svg>
                                    Calificación
                                </label>
                                <select class="form-select" id="calificacion" name="calificacion" 
                                        style="border-radius:10px; border:1px solid #dee2e6;">
                                    <option value="">Todas</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('calificacion') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'estrella' : 'estrellas' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="disponibilidad" class="form-label" style="font-weight:600; color:#662a5b;">
                                    <svg class="icon me-1">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-clock') }}"></use>
                                    </svg>
                                    Disponibilidad
                                </label>
                                <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" 
                                       value="{{ request('disponibilidad') }}" 
                                       placeholder="Ej: Tiempo completo"
                                       style="border-radius:10px; border:1px solid #dee2e6;">
                            </div>

                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn text-white" 
                                        style="background-color:#662a5b; border-radius:10px; padding:0.6rem 1.5rem;">
                                    <svg class="icon me-1">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-filter') }}"></use>
                                    </svg>
                                    Filtrar
                                </button>
                                <a href="{{ route('estilistas.index') }}" class="btn btn-secondary" 
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

            {{-- Tabla de estilistas --}}
            <div class="table-responsive">
                <table class="table table-hover" style="border-radius:10px; overflow:hidden;">
                    <thead style="background-color:#f8f9fa;">
                        <tr>
                            {{-- <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">ID</th> --}}
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Nombre</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Email</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Horario</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Calificación</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Comisión</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Disponibilidad</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b;">Especialidad</th>
                            <th style="border:none; padding:1rem; font-weight:600; color:#662a5b; text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estilistas as $estilista)
                            <tr style="border-bottom:1px solid #f0f0f0;">
                                {{-- <td style="padding:1rem; vertical-align:middle;">{{ $estilista->id }}</td> --}}
                                <td style="padding:1rem; vertical-align:middle;">{{ $estilista->user->name }}</td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $estilista->user->email }}</td>
                                <td style="padding:1rem; vertical-align:middle;">
                                    @if($estilista->horario)
                                        <span class="badge bg-info" style="padding:0.5rem 1rem; border-radius:8px;">
                                            {{ $estilista->horario->dia }}: {{ $estilista->horario->horaInicio }} - {{ $estilista->horario->horaFin }}
                                        </span>
                                    @else
                                        <span class="text-muted">Sin horario</span>
                                    @endif
                                </td>
                                <td style="padding:1rem; vertical-align:middle;">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="icon" style="width:16px; height:16px; color:{{ $i <= $estilista->calificacion ? '#ffc107' : '#e0e0e0' }};">
                                                <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                                            </svg>
                                        @endfor
                                        <span class="ms-2">{{ $estilista->calificacion }}</span>
                                    </div>
                                </td>
                                <td style="padding:1rem; vertical-align:middle;">
                                    <span class="badge bg-success" style="padding:0.5rem 1rem; border-radius:8px;">
                                        ${{ number_format($estilista->comision, 2) }}
                                    </span>
                                </td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $estilista->disponibilidad }}</td>
                                <td style="padding:1rem; vertical-align:middle;">{{ $estilista->especialidad }}</td>
                                <td style="padding:1rem; vertical-align:middle; text-align:center;">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" style="border-radius:8px 0 0 8px;" 
                                                data-bs-toggle="modal" data-bs-target="#showModal{{ $estilista->id }}" title="Ver">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $estilista->id }}" title="Editar">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius:0 8px 8px 0;" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $estilista->id }}" title="Eliminar">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Ver --}}
                            <div class="modal fade" id="showModal{{ $estilista->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border-radius:15px; border:none;">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                            <h5 class="modal-title">
                                                <svg class="icon me-2">
                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
                                                </svg>
                                                Detalles del Estilista
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="padding:2rem;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">NOMBRE</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $estilista->user->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">EMAIL</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $estilista->user->email }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">HORARIO</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">
                                                            @if($estilista->horario)
                                                                {{ $estilista->horario->dia }}: {{ $estilista->horario->horaInicio }} - {{ $estilista->horario->horaFin }}
                                                            @else
                                                                Sin horario
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">CALIFICACIÓN</label>
                                                        <p class="mb-0 mt-2">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="icon" style="width:20px; height:20px; color:{{ $i <= $estilista->calificacion ? '#ffc107' : '#e0e0e0' }};">
                                                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                                                                </svg>
                                                            @endfor
                                                            <span class="ms-2">{{ $estilista->calificacion }}/5</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">COMISIÓN</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">${{ number_format($estilista->comision, 2) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">DISPONIBILIDAD</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $estilista->disponibilidad }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                                                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">ESPECIALIDAD</label>
                                                        <p class="mb-0 mt-2" style="font-size:1.1rem;">{{ $estilista->especialidad }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Editar --}}
                            <div class="modal fade" id="editModal{{ $estilista->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border-radius:15px; border:none;">
                                        <form action="{{ route('estilistas.update', $estilista->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                                                <h5 class="modal-title">
                                                    <svg class="icon me-2">
                                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                                                    </svg>
                                                    Editar Estilista
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="padding:2rem;">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Nombre Completo *</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $estilista->user->name }}" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Email *</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $estilista->user->email }}" required style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Nueva Contraseña (opcional)</label>
                                                        <input type="password" name="password" class="form-control" style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Confirmar Contraseña</label>
                                                        <input type="password" name="password_confirmation" class="form-control" style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" style="font-weight:600; color:#662a5b;">Horario *</label>
                                                    <select name="horario_id" class="form-select" required style="border-radius:10px;">
                                                        @foreach(\App\Models\Horario::all() as $horario)
                                                            <option value="{{ $horario->id }}" {{ $estilista->horario_id == $horario->id ? 'selected' : '' }}>
                                                                {{ $horario->dia }}: {{ $horario->horaInicio }} - {{ $horario->horaFin }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Calificación (0-5) *</label>
                                                        <input type="number" name="calificacion" class="form-control" value="{{ $estilista->calificacion }}" min="0" max="5" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Comisión *</label>
                                                        <input type="number" step="0.01" name="comision" class="form-control" value="{{ $estilista->comision }}" required style="border-radius:10px;">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Disponibilidad *</label>
                                                        <input type="text" name="disponibilidad" class="form-control" value="{{ $estilista->disponibilidad }}" required style="border-radius:10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" style="font-weight:600; color:#662a5b;">Especialidad *</label>
                                                        <input type="text" name="especialidad" class="form-control" value="{{ $estilista->especialidad }}" required style="border-radius:10px;">
                                                    </div>
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

                            {{-- Modal Eliminar --}}
                            <div class="modal fade" id="deleteModal{{ $estilista->id }}" tabindex="-1" aria-hidden="true">
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
                                            <p>¿Está seguro de eliminar al estilista <strong>{{ $estilista->user->name }}</strong>?</p>
                                            <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Cancelar</button>
                                            <form action="{{ route('estilistas.destroy', $estilista->id) }}" method="POST" style="display:inline;">
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

                        @empty
                            <tr>
                                <td colspan="9" class="text-center" style="padding:3rem; color:#999;">
                                    <svg class="icon mb-3" style="width:48px; height:48px; color:#ccc;">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                                    </svg>
                                    <p class="mb-0">
                                        @if(request('search') || request('calificacion') || request('disponibilidad'))
                                            No se encontraron estilistas con los criterios de búsqueda.
                                        @else
                                            No hay estilistas registrados.
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
                {{ $estilistas->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear --}}
<div class="modal fade" id="createEstilistaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:15px; border:none;">
            <form action="{{ route('estilistas.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0;">
                    <h5 class="modal-title">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-user-plus') }}"></use>
                        </svg>
                        Agregar Estilista
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding:2rem;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_name" class="form-label" style="font-weight:600; color:#662a5b;">Nombre Completo *</label>
                            <input type="text" name="name" id="modal_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required style="border-radius:10px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_email" class="form-label" style="font-weight:600; color:#662a5b;">Correo Electrónico *</label>
                            <input type="email" name="email" id="modal_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required style="border-radius:10px;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_password" class="form-label" style="font-weight:600; color:#662a5b;">Contraseña *</label>
                            <input type="password" name="password" id="modal_password" class="form-control @error('password') is-invalid @enderror" required style="border-radius:10px;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_password_confirmation" class="form-label" style="font-weight:600; color:#662a5b;">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" id="modal_password_confirmation" class="form-control" required style="border-radius:10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600; color:#662a5b;">Seleccionar Horario *</label>
                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto; background-color:#f8f9fa;">
                            @php
                                $horarios = \App\Models\Horario::all();
                            @endphp
                            @forelse($horarios as $horario)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="horario_id" id="modal_horario_{{ $horario->id }}" value="{{ $horario->id }}" {{ old('horario_id') == $horario->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="modal_horario_{{ $horario->id }}">
                                        {{ $horario->dia }}: {{ $horario->horaInicio }} - {{ $horario->horaFin }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No hay horarios disponibles. <a href="{{ route('horarios.create') }}" target="_blank">Crear horario</a></p>
                            @endforelse
                        </div>
                        @error('horario_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_calificacion" class="form-label" style="font-weight:600; color:#662a5b;">Calificación (0-5) *</label>
                            <input type="number" name="calificacion" id="modal_calificacion" class="form-control @error('calificacion') is-invalid @enderror" value="{{ old('calificacion') }}" min="0" max="5" required style="border-radius:10px;">
                            @error('calificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_comision" class="form-label" style="font-weight:600; color:#662a5b;">Comisión *</label>
                            <input type="number" step="0.01" name="comision" id="modal_comision" class="form-control @error('comision') is-invalid @enderror" value="{{ old('comision') }}" required style="border-radius:10px;">
                            @error('comision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_disponibilidad" class="form-label" style="font-weight:600; color:#662a5b;">Disponibilidad *</label>
                            <input type="text" name="disponibilidad" id="modal_disponibilidad" class="form-control @error('disponibilidad') is-invalid @enderror" value="{{ old('disponibilidad') }}" required style="border-radius:10px;">
                            @error('disponibilidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modal_especialidad" class="form-label" style="font-weight:600; color:#662a5b;">Especialidad *</label>
                            <input type="text" name="especialidad" id="modal_especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad') }}" required style="border-radius:10px;">
                            @error('especialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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

{{-- Script para reabrir el modal si hay errores --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('createEstilistaModal'));
        modal.show();
    });
</script>
@endif
@endsection