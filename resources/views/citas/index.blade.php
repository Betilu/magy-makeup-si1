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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><svg class="icon me-2" style="width:16px; height:16px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use></svg></strong>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><svg class="icon me-2" style="width:16px; height:16px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>Error:</strong>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('modal_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><svg class="icon me-2" style="width:16px; height:16px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-x-circle') }}"></use></svg>Conflicto de Horario:</strong>
                    {{ session('modal_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Mostrar errores de validación en la página principal -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>Error de Validación:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
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
                            @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                            <th>Comisión</th>
                            @endif
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
                                    @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                    <span class="badge bg-info">{{ $cita->estilista->porcentaje_comision }}%</span>
                                    @endif
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
                            @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                            <td>
                                <span class="text-success fw-bold">${{ number_format($cita->comision_estilista ?? 0, 2) }}</span>
                            </td>
                            @endif
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

                                    {{-- Botón de Pago --}}
                                    @if($cita->saldoPendiente() > 0 && ($cita->estado === 'pendiente' || $cita->estado === 'confirmada'))
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#pagoModal-{{ $cita->id }}" title="Realizar pago">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Botón de Historial de Pagos --}}
                                    @if($cita->pagos->count() > 0)
                                        <a href="{{ route('payment.historial', $cita->id) }}" class="btn btn-sm btn-outline-info" title="Ver historial de pagos">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                                <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de Pago --}}
                        @if($cita->saldoPendiente() > 0)
                        <div class="modal fade" id="pagoModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-credit-card me-2" viewBox="0 0 16 16">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                            </svg>
                                            Realizar Pago - Cita #{{ $cita->id }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <h6>Información de la Cita</h6>
                                            <p class="mb-1"><strong>Servicio:</strong> {{ $cita->servicio->nombre ?? 'N/A' }}</p>
                                            <p class="mb-1"><strong>Fecha:</strong> {{ $cita->fecha }} - {{ $cita->hora }}</p>
                                            <p class="mb-0"><strong>Precio Total:</strong> ${{ number_format($cita->precio_total, 2) }}</p>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="card bg-light">
                                                    <div class="card-body text-center">
                                                        <small class="text-muted d-block">Pagado</small>
                                                        <h5 class="text-success mb-0">${{ number_format($cita->totalPagado(), 2) }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card bg-light">
                                                    <div class="card-body text-center">
                                                        <small class="text-muted d-block">Pendiente</small>
                                                        <h5 class="text-danger mb-0">${{ number_format($cita->saldoPendiente(), 2) }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            @if($cita->anticipo > 0 && $cita->totalPagado() == 0)
                                            <form action="{{ route('payment.checkout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                                                <input type="hidden" name="tipo_pago" value="anticipo">
                                                <button type="submit" class="btn btn-warning btn-lg w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash me-2" viewBox="0 0 16 16">
                                                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                                        <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                                                    </svg>
                                                    Pagar Anticipo - ${{ number_format($cita->anticipo, 2) }}
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('payment.checkout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                                                <input type="hidden" name="tipo_pago" value="total">
                                                <button type="submit" class="btn btn-success btn-lg w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                    </svg>
                                                    Pagar Total - ${{ number_format($cita->saldoPendiente(), 2) }}
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-3 text-center">
                                            <small class="text-muted">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-shield-check me-1" viewBox="0 0 16 16">
                                                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                                Pago seguro procesado por Stripe
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

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
                                                    @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                                    <span class="badge bg-info ms-2">{{ $cita->estilista->estado }} - {{ $cita->estilista->porcentaje_comision }}%</span>
                                                    @endif
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

                                            @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                            <dt class="col-4">Comisión Estilista</dt>
                                            <dd class="col-8"><strong class="text-success">${{ number_format($cita->comision_estilista ?? 0, 2) }}</strong></dd>
                                            @endif

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
                                            <!-- Alerta de error de conflicto de horario -->
                                            @if($errors->has('conflicto'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>
                                                <strong>Conflicto de Horario:</strong> {{ $errors->first('conflicto') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            @endif

                                            <!-- Mostrar todos los errores de validación -->
                                            @if($errors->any() && !$errors->has('conflicto'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>
                                                <strong>Error:</strong> Por favor, corrija los siguientes errores:
                                                <ul class="mb-0 mt-2">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            @endif

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
                                                                {{ $estilista->user->name }}
                                                                @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                                                ({{ ucfirst($estilista->estado) }} - {{ $estilista->porcentaje_comision }}%)
                                                                @endif
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
                        <!-- Alerta de error de conflicto de horario desde sesión -->
                        @if(session('modal_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>Conflicto de Horario:</strong>
                            {{ session('modal_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Alerta de error de conflicto de horario -->
                        @if($errors->has('conflicto'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>
                            <strong>Conflicto de Horario:</strong> {{ $errors->first('conflicto') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Mostrar todos los errores de validación -->
                        @if($errors->any() && !$errors->has('conflicto'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-warning') }}"></use></svg>
                            <strong>Error:</strong> Por favor, corrija los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

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
                                            {{ $estilista->user->name }}
                                            @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                            - {{ ucfirst($estilista->estado) }} ({{ $estilista->porcentaje_comision }}%)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
                                <small class="text-muted">La comisión se calculará automáticamente</small>
                                @endif
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

                        @if(!auth()->user()->hasRole('cliente') || auth()->user()->hasRole('super-admin'))
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
                        @endif

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
    // Reabrir el modal si hay errores de validación o conflictos de horario
    @if($errors->any() || session('modal_error'))
        console.log('Hay errores de validación o conflicto de horario, abriendo modal...');
        var modalElement = document.getElementById('crearCitaModal');
        if (modalElement) {
            var crearCitaModal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });
            crearCitaModal.show();
        }
    @endif

    const estilistaDrop = document.getElementById('estilistaDrop');
    const servicioDrop = document.getElementById('servicioDrop');
    const precioServicioEl = document.getElementById('precioServicio');
    const comisionEstilistaEl = document.getElementById('comisionEstilista');

    // Guardar los servicios originales para restaurar
    let serviciosOriginales = [];
    if (servicioDrop) {
        serviciosOriginales = Array.from(servicioDrop.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            precio: opt.dataset.precio
        }));
    }

    // Función para cargar servicios de una estilista mediante AJAX
    function cargarServiciosPorEstilista(estilistaId) {
        if (!estilistaId) {
            // Si no hay estilista seleccionada, mostrar todos los servicios
            restaurarServiciosOriginales();
            return;
        }

        fetch(`/citas/servicios-estilista/${estilistaId}`)
            .then(response => response.json())
            .then(data => {
                // Limpiar el dropdown de servicios
                servicioDrop.innerHTML = '<option value="">Seleccione un servicio...</option>';

                // Agregar los servicios de la estilista
                data.servicios.forEach(servicio => {
                    const option = document.createElement('option');
                    option.value = servicio.id;
                    option.text = `${servicio.nombre} - $${parseFloat(servicio.precio_servicio).toFixed(2)}`;
                    option.dataset.precio = servicio.precio_servicio;
                    servicioDrop.appendChild(option);
                });

                // Si no hay servicios disponibles para esta estilista
                if (data.servicios.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.text = 'No hay servicios disponibles para esta estilista';
                    option.disabled = true;
                    servicioDrop.appendChild(option);
                }

                // Actualizar la comisión
                calcularComision();
            })
            .catch(error => {
                console.error('Error al cargar servicios:', error);
                restaurarServiciosOriginales();
            });
    }

    function restaurarServiciosOriginales() {
        servicioDrop.innerHTML = '<option value="">Seleccione un servicio...</option>';
        serviciosOriginales.forEach(servicio => {
            if (servicio.value) {
                const option = document.createElement('option');
                option.value = servicio.value;
                option.text = servicio.text;
                option.dataset.precio = servicio.precio;
                servicioDrop.appendChild(option);
            }
        });
    }

    function calcularComision() {
        const servicioOption = servicioDrop.options[servicioDrop.selectedIndex];
        const estilistaOption = estilistaDrop.options[estilistaDrop.selectedIndex];

        if (servicioOption && estilistaOption && servicioOption.value && estilistaOption.value) {
            const precio = parseFloat(servicioOption.dataset.precio) || 0;
            const comisionPorcentaje = parseFloat(estilistaOption.dataset.comision) || 0;
            const comision = (precio * comisionPorcentaje) / 100;

            if (precioServicioEl) precioServicioEl.textContent = '$' + precio.toFixed(2);
            if (comisionEstilistaEl) comisionEstilistaEl.textContent = '$' + comision.toFixed(2);
        } else {
            if (precioServicioEl) precioServicioEl.textContent = '$0.00';
            if (comisionEstilistaEl) comisionEstilistaEl.textContent = '$0.00';
        }
    }

    if (estilistaDrop && servicioDrop) {
        // Al cambiar estilista, cargar sus servicios
        estilistaDrop.addEventListener('change', function() {
            cargarServiciosPorEstilista(this.value);
        });

        servicioDrop.addEventListener('change', calcularComision);

        // Calcular si hay valores pre-seleccionados
        calcularComision();
    }
});
</script>
@endpush

@endsection
