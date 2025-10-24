@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:24px; height:24px;">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
                </svg>
                Detalles de Herramienta
            </h4>
        </div>

        <div class="card-body" style="padding:2rem;">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">NOMBRE</label>
                        <p class="mb-0 mt-2" style="font-size:1.1rem; color:#212529;">{{ $herramienta->nombre }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">TIPO</label>
                        <p class="mb-0 mt-2" style="font-size:1.1rem; color:#212529;">{{ $herramienta->tipo }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">MARCA</label>
                        <p class="mb-0 mt-2" style="font-size:1.1rem; color:#212529;">{{ $herramienta->marca }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">MODELO</label>
                        <p class="mb-0 mt-2" style="font-size:1.1rem; color:#212529;">{{ $herramienta->modelo }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">FECHA DE ADQUISICIÓN</label>
                        <p class="mb-0 mt-2" style="font-size:1.1rem; color:#212529;">
                            {{ \Carbon\Carbon::parse($herramienta->fechaAdquisicion)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">ESTADO</label>
                        <p class="mb-0 mt-2">
                            @php
                                $badgeClass = match($herramienta->estadoHerramienta) {
                                    'Disponible' => 'success',
                                    'En uso' => 'primary',
                                    'En mantenimiento' => 'warning',
                                    'Fuera de servicio' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}" style="padding:0.5rem 1rem; border-radius:8px; font-size:1rem; font-weight:500;">
                                {{ $herramienta->estadoHerramienta }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            @if($herramienta->observacion)
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                            <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">OBSERVACIONES</label>
                            <p class="mb-0 mt-2" style="font-size:1rem; color:#212529;">{{ $herramienta->observacion }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">FECHA DE REGISTRO</label>
                        <p class="mb-0 mt-2" style="font-size:1rem; color:#212529;">
                            {{ $herramienta->created_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="p-3" style="background-color:#f8f9fa; border-radius:10px;">
                        <label style="font-weight:600; color:#662a5b; font-size:0.875rem;">ÚLTIMA ACTUALIZACIÓN</label>
                        <p class="mb-0 mt-2" style="font-size:1rem; color:#212529;">
                            {{ $herramienta->updated_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('herramientas.index') }}" class="btn btn-secondary" style="border-radius:10px; padding:0.75rem 2rem;">
                    <svg class="icon me-1">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-arrow-left') }}"></use>
                    </svg>
                    Volver
                </a>
                @can('editar herramientas')
                    <a href="{{ route('herramientas.edit', $herramienta->id) }}" class="btn btn-warning" style="border-radius:10px; padding:0.75rem 2rem;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                        </svg>
                        Editar
                    </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection