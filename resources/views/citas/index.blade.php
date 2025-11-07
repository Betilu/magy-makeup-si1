<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:20px; height:20px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                    </svg>
                    Citas
                </h4>
                @can('create', App\Models\Cita::class)
                <div>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#crearCitaModal" style="border-radius:8px; font-weight:500;">Nueva Cita</button>
                </div>
                @endcan
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($citas->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Estilista</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Comisión</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($cita->estilista)
                                    {{ $cita->estilista->user->name ?? 'N/A' }}
                                    <span class="badge bg-info">{{ $cita->estilista->porcentaje_comision }}%</span>
                                @else
                                    <span class="text-muted">Sin asignar</span>
                                @endif
                            </td>
                            <td>{{ $cita->servicio->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $cita->estado === 'confirmada' ? 'bg-success' : ($cita->estado === 'pendiente' ? 'bg-warning' : ($cita->estado === 'completada' ? 'bg-primary' : 'bg-secondary')) }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td><strong>${{ number_format($cita->precio_total ?? 0, 2) }}</strong></td>
                            <td>
                                <span class="text-success fw-bold">${{ number_format($cita->comision_estilista ?? 0, 2) }}</span>
                            </td>
                            <td>{{ optional($cita->fecha)->format ? $cita->fecha : $cita->fecha }}</td>
                            <td>{{ $cita->hora }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    @can('view', $cita)
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showCitaModal-{{ $cita->id }}">Ver</button>
                                    @endcan
                                    @can('update', $cita)
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCitaModal-{{ $cita->id }}">Editar</button>
                                    @endcan
                                    @can('delete', $cita)
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCitaModal-{{ $cita->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Show Modal -->
                        @can('view', $cita)
                        <div class="modal fade" id="showCitaModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ver Cita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-4">Cliente</dt>
                                            <dd class="col-8">{{ $cita->user->name ?? 'N/A' }}</dd>

                                            <dt class="col-4">Estilista</dt>
                                            <dd class="col-8">
                                                @if($cita->estilista)
                                                    {{ $cita->estilista->user->name ?? 'N/A' }}
                                                    <span class="badge bg-info ms-2">{{ $cita->estilista->estado }} - {{ $cita->estilista->porcentaje_comision }}%</span>
                                                @else
                                                    <span class="text-muted">Sin asignar</span>
                                                @endif
                                            </dd>

                                            <dt class="col-4">Servicio</dt>
                                            <dd class="col-8">{{ $cita->servicio->nombre ?? 'N/A' }}</dd>

                                            <dt class="col-4">Estado</dt>
                                            <dd class="col-8">
                                                <span class="badge {{ $cita->estado === 'confirmada' ? 'bg-success' : ($cita->estado === 'pendiente' ? 'bg-warning' : ($cita->estado === 'completada' ? 'bg-primary' : 'bg-secondary')) }}">
                                                    {{ ucfirst($cita->estado) }}
                                                </span>
                                            </dd>

                                            <dt class="col-4">Precio Total</dt>
                                            <dd class="col-8"><strong class="text-primary">${{ number_format($cita->precio_total ?? 0, 2) }}</strong></dd>

                                            <dt class="col-4">Comisión Estilista</dt>
                                            <dd class="col-8"><strong class="text-success">${{ number_format($cita->comision_estilista ?? 0, 2) }}</strong></dd>

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
                        @endcan

                        <!-- Edit Modal -->
                        @can('update', $cita)
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
                                                <label class="form-label">Cliente</label>
                                                <select name="user_id" class="form-select" required>
                                                    <option value="">Seleccione un cliente...</option>
                                                    @foreach($clientes as $cliente)
                                                        <option value="{{ $cliente->id }}" {{ (old('user_id', $cita->user_id) == $cliente->id) ? 'selected' : '' }}>
                                                            {{ $cliente->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Estilista</label>
                                                    <select name="estilista_id" class="form-select" required>
                                                        <option value="">Seleccione un estilista...</option>
                                                        @foreach($estilistas as $estilista)
                                                            <option value="{{ $estilista->id }}" {{ (old('estilista_id', $cita->estilista_id) == $estilista->id) ? 'selected' : '' }}>
                                                                {{ $estilista->user->name }} ({{ ucfirst($estilista->estado) }} - {{ $estilista->porcentaje_comision }}%)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Servicio</label>
                                                    <select name="servicio_id" class="form-select" required>
                                                        <option value="">Seleccione un servicio...</option>
                                                        @foreach($servicios as $servicio)
                                                            <option value="{{ $servicio->id }}" {{ (old('servicio_id', $cita->servicio_id) == $servicio->id) ? 'selected' : '' }}>
                                                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio_servicio, 2) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Estado</label>
                                                <select name="estado" class="form-select" required>
                                                    <option value="pendiente" {{ old('estado', $cita->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="confirmada" {{ old('estado', $cita->estado) == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                                    <option value="cancelada" {{ old('estado', $cita->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                                    <option value="completada" {{ old('estado', $cita->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Anticipo</label>
                                                <input type="number" step="0.01" name="anticipo" value="{{ old('anticipo', $cita->anticipo) }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Fecha</label>
                                                    <input type="date" name="fecha" value="{{ old('fecha', $cita->fecha) }}" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Hora</label>
                                                    <input type="time" name="hora" value="{{ old('hora', $cita->hora) }}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tipo de Servicio</label>
                                                <input type="text" name="tipo" value="{{ old('tipo', $cita->tipo) }}" class="form-control" required>
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
                        @endcan

                        <!-- Delete Modal -->
                        @can('delete', $cita)
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
                        @endcan

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
    @can('create', App\Models\Cita::class)
    <div class="modal fade" id="crearCitaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('citas.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        @php 
                            $isCliente = auth()->user()->hasRole('cliente') && !auth()->user()->hasRole('super-admin');
                        @endphp
                        
                        @if(!$isCliente)
                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Seleccione un cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('user_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="alert alert-info">
                            <strong>Cliente:</strong> {{ auth()->user()->name }}
                        </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estilista <span class="text-danger">*</span></label>
                                <select name="estilista_id" class="form-select" required id="estilistaDrop">
                                    <option value="">Seleccione un estilista...</option>
                                    @foreach($estilistas as $estilista)
                                        <option value="{{ $estilista->id }}" 
                                                data-comision="{{ $estilista->porcentaje_comision }}"
                                                {{ old('estilista_id') == $estilista->id ? 'selected' : '' }}>
                                            {{ $estilista->user->name }} - {{ ucfirst($estilista->estado) }} ({{ $estilista->porcentaje_comision }}%)
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">La comisión se calculará automáticamente</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Servicio <span class="text-danger">*</span></label>
                                <select name="servicio_id" class="form-select" required id="servicioDrop">
                                    <option value="">Seleccione un servicio...</option>
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}" 
                                                data-precio="{{ $servicio->precio_servicio }}"
                                                {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                            {{ $servicio->nombre }} - ${{ number_format($servicio->precio_servicio, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <small class="text-muted">Precio del Servicio:</small>
                                        <h5 class="mb-0 text-primary" id="precioServicio">$0.00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <small class="text-muted">Comisión Estilista:</small>
                                        <h5 class="mb-0 text-success" id="comisionEstilista">$0.00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(!$isCliente)
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select" required>
                                <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ old('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="estado" value="pendiente">
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Anticipo</label>
                            <input type="number" step="0.01" name="anticipo" value="{{ old('anticipo', 0) }}" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora</label>
                                <input type="time" name="hora" value="{{ old('hora') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Servicio</label>
                            <input type="text" name="tipo" value="{{ old('tipo') }}" class="form-control" required placeholder="Ej: Corte, Peinado, Maquillaje...">
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
    @endcan

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const estilistaDrop = document.getElementById('estilistaDrop');
    const servicioDrop = document.getElementById('servicioDrop');
    const precioServicioEl = document.getElementById('precioServicio');
    const comisionEstilistaEl = document.getElementById('comisionEstilista');

    function calcularComision() {
        const servicioOption = servicioDrop.options[servicioDrop.selectedIndex];
        const estilistaOption = estilistaDrop.options[estilistaDrop.selectedIndex];
        
        if (servicioOption && estilistaOption && servicioOption.value && estilistaOption.value) {
            const precio = parseFloat(servicioOption.dataset.precio) || 0;
            const comisionPorcentaje = parseFloat(estilistaOption.dataset.comision) || 0;
            const comision = (precio * comisionPorcentaje) / 100;
            
            precioServicioEl.textContent = '$' + precio.toFixed(2);
            comisionEstilistaEl.textContent = '$' + comision.toFixed(2);
        } else {
            precioServicioEl.textContent = '$0.00';
            comisionEstilistaEl.textContent = '$0.00';
        }
    }

    if (estilistaDrop && servicioDrop) {
        estilistaDrop.addEventListener('change', calcularComision);
        servicioDrop.addEventListener('change', calcularComision);
        
        // Calcular si hay valores pre-seleccionados
        calcularComision();
    }
});
</script>
@endpush

@endsection