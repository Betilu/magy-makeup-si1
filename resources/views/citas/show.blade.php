<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use></svg>
                Detalle de la Cita
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <div class="bg-white p-4 rounded shadow-sm mb-3">
                <p><strong>Usuario:</strong> {{ $cita->user->name ?? 'Usuario #'.$cita->user_id }}</p>
                <p><strong>Estado:</strong> {{ $cita->estado }}</p>
                <p><strong>Anticipo:</strong> ${{ number_format($cita->anticipo, 2) }}</p>
                <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
                <p><strong>Hora:</strong> {{ $cita->hora }}</p>
                <p><strong>Tipo:</strong> {{ $cita->tipo }}</p>
            </div>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
@endsection