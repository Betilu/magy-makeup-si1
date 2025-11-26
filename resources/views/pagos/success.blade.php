@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.08);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color:white; border-radius:15px 15px 0 0; padding:2rem;">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    <h3 class="mb-0" style="font-weight:600;">¡Pago Exitoso!</h3>
                </div>
                <div class="card-body" style="padding:2rem;">
                    <div class="text-center mb-4">
                        <p class="lead">Tu pago ha sido procesado correctamente.</p>
                        <p class="text-muted">Recibirás un correo de confirmación en breve.</p>
                    </div>

                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Detalles del Pago
                        </h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Servicio:</strong> {{ $cita->servicio->nombre ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Fecha de Cita:</strong> {{ $cita->fecha }}</p>
                                <p class="mb-2"><strong>Hora:</strong> {{ $cita->hora }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($pago)
                                <p class="mb-2"><strong>Monto Pagado:</strong> <span class="text-success">${{ number_format($pago->monto, 2) }}</span></p>
                                <p class="mb-2"><strong>Tipo de Pago:</strong> {{ ucfirst($pago->tipo_pago) }}</p>
                                <p class="mb-2"><strong>Método:</strong> {{ ucfirst($pago->metodo_pago) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($cita->saldoPendiente() > 0)
                    <div class="alert alert-warning" role="alert">
                        <h6 class="alert-heading">Saldo Pendiente</h6>
                        <p class="mb-0">
                            Aún tienes un saldo pendiente de <strong>${{ number_format($cita->saldoPendiente(), 2) }}</strong> que deberás pagar antes o el día de tu cita.
                        </p>
                    </div>
                    @else
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                            </svg>
                            ¡Tu cita está completamente pagada!
                        </p>
                    </div>
                    @endif

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('citas.index') }}" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check me-2" viewBox="0 0 16 16">
                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                            Ver Mis Citas
                        </a>
                        @if($cita->saldoPendiente() > 0)
                        <form action="{{ route('payment.checkout') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                            <input type="hidden" name="tipo_pago" value="total">
                            <button type="submit" class="btn btn-success btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card me-2" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                                </svg>
                                Pagar Saldo Restante
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
