<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\estilistas\show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detalle del Estilista</h1>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Información del Estilista</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>ID:</strong> {{ $estilista->id }}
                </div>
                <div class="col-md-6">
                    <strong>Nombre:</strong> {{ $estilista->user->name }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Email:</strong> {{ $estilista->user->email }}
                </div>
                <div class="col-md-6">
                    <strong>Horario:</strong> 
                    @if($estilista->horario)
                        {{ $estilista->horario->dia }}: {{ $estilista->horario->horaInicio }} - {{ $estilista->horario->horaFin }}
                    @else
                        Sin horario
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Calificación:</strong> {{ $estilista->calificacion }} / 5
                </div>
                <div class="col-md-6">
                    <strong>Comisión:</strong> ${{ number_format($estilista->comision, 2) }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Disponibilidad:</strong> {{ $estilista->disponibilidad }}
                </div>
                <div class="col-md-6">
                    <strong>Especialidad:</strong> {{ $estilista->especialidad }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Creado:</strong> {{ $estilista->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="col-md-6">
                    <strong>Actualizado:</strong> {{ $estilista->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('estilistas.edit', $estilista->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('estilistas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection