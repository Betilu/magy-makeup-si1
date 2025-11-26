@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-receipt me-2" viewBox="0 0 16 16">
                    <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                </svg>
                Historial de Pagos - Cita #{{ $cita->id }}
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <!-- Información de la Cita -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3">Información de la Cita</h6>
                            <p class="mb-2"><strong>Cliente:</strong> {{ $cita->user->name }}</p>
                            <p class="mb-2"><strong>Servicio:</strong> {{ $cita->servicio->nombre ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Fecha:</strong> {{ $cita->fecha }}</p>
                            <p class="mb-2"><strong>Hora:</strong> {{ $cita->hora }}</p>
                            <p class="mb-0"><strong>Estado:</strong>
                                <span class="badge {{ $cita->estado === 'confirmada' ? 'bg-success' : ($cita->estado === 'pendiente' ? 'bg-warning' : 'bg-secondary') }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3">Resumen de Pagos</h6>
                            <p class="mb-2"><strong>Precio Total:</strong> <span class="text-primary">${{ number_format($cita->precio_total, 2) }}</span></p>
                            <p class="mb-2"><strong>Total Pagado:</strong> <span class="text-success">${{ number_format($cita->totalPagado(), 2) }}</span></p>
                            <p class="mb-0"><strong>Saldo Pendiente:</strong>
                                @if($cita->saldoPendiente() > 0)
                                    <span class="text-danger">${{ number_format($cita->saldoPendiente(), 2) }}</span>
                                @else
                                    <span class="text-success">$0.00</span>
                                    <span class="badge bg-success ms-2">Pagado Completo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Pagos -->
            <h5 class="mb-3">Transacciones</h5>
            @if($cita->pagos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Método</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cita->pagos as $pago)
                        <tr>
                            <td>{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($pago->tipo_pago) }}</span>
                            </td>
                            <td>{{ ucfirst($pago->metodo_pago) }}</td>
                            <td>
                                <strong class="{{ $pago->esExitoso() ? 'text-success' : 'text-muted' }}">
                                    ${{ number_format($pago->monto, 2) }}
                                </strong>
                            </td>
                            <td>
                                @if($pago->esExitoso())
                                    <span class="badge bg-success">Exitoso</span>
                                @elseif($pago->estaPendiente())
                                    <span class="badge bg-warning">Pendiente</span>
                                @elseif($pago->fueReembolsado())
                                    <span class="badge bg-secondary">Reembolsado</span>
                                @else
                                    <span class="badge bg-danger">Fallido</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $pago->descripcion ?? 'N/A' }}</small>
                            </td>
                        </tr>
                        @if($pago->fueReembolsado())
                        <tr class="table-warning">
                            <td colspan="6" class="text-end">
                                <small>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-return-left me-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    Reembolsado: ${{ number_format($pago->monto_reembolsado, 2) }} el {{ $pago->fecha_reembolso->format('d/m/Y') }}
                                </small>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
                No hay pagos registrados para esta cita.
            </div>
            @endif

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('citas.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Volver a Citas
                </a>

                @if($cita->saldoPendiente() > 0)
                <form action="{{ route('payment.checkout') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                    <input type="hidden" name="tipo_pago" value="total">
                    <button type="submit" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card me-2" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                        Pagar Saldo Restante (${{ number_format($cita->saldoPendiente(), 2) }})
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
