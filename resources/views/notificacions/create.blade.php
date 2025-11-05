<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Nueva Notificación</h1>
    <form action="{{ route('notificacions.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        {{-- Mostrar una lista de citas como radios con el nombre del cliente y el id de la cita. --}}
        <div class="mb-3">
            <label class="form-label">Seleccionar cita</label>
            <div>
                @forelse($citas as $cita)
                    <div class="form-check">
                        <input class="form-check-input cita-radio" type="radio"
                               name="cita_id" id="cita_{{ $cita->id }}"
                               value="{{ $cita->id }}"
                               data-client-id="{{ $cita->client_id }}"
                               {{ old('cita_id') == $cita->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="cita_{{ $cita->id }}">
                            Cita #{{ $cita->id }} - {{ $cita->client->user->name ?? 'Cliente #'.$cita->client_id }}
                        </label>
                    </div>
                @empty
                    <div class="text-muted small">No hay citas disponibles.</div>
                @endforelse
            </div>
            @error('cita_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo oculto client_id que se completa automáticamente desde la cita seleccionada. --}}
        <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id') }}">
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" class="form-control" required>
            @error('estado')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
            @error('fecha')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <input type="text" name="mensaje" class="form-control" required>
            @error('mensaje')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('notificacions.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Al cambiar la radio de cita, actualizar el campo oculto client_id
    document.addEventListener('DOMContentLoaded', function(){
        function updateClientField(el){
            var clientId = el.getAttribute('data-client-id');
            if(clientId){
                document.getElementById('client_id').value = clientId;
            }
        }

        // Si hay una cita seleccionada por old(), fijarla en el hidden
        var prechecked = document.querySelector('.cita-radio:checked');
        if(prechecked){ updateClientField(prechecked); }

        document.querySelectorAll('.cita-radio').forEach(function(r){
            r.addEventListener('change', function(e){ updateClientField(e.target); });
        });
    });
</script>
@endpush