<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">Editar Notificación</h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form action="{{ route('notificacions.update', $notificacion->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
                @csrf
                @method('PUT')
        @php
            $clients = App\Models\Client::with('user')->get()->sortBy(function($c){
                return strtolower($c->user->name ?? '');
            });
            $citas = App\Models\Cita::with('user')->get();
        @endphp
        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <div>
                @foreach($clients as $client)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="client_id" id="client_{{ $client->id }}" value="{{ $client->id }}" {{ (old('client_id', $notificacion->client_id) == $client->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="client_{{ $client->id }}">{{ $client->user->name ?? $client->nombre ?? $client->name ?? 'Cliente #'.$client->id }}{{ isset($client->telefono) ? ' - '.$client->telefono : '' }}</label>
                    </div>
                @endforeach
            </div>
            @error('client_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Cita</label>
            <div>
                @foreach($citas as $cita)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cita_id" id="cita_edit_{{ $cita->id }}" value="{{ $cita->id }}" {{ (old('cita_id', $notificacion->cita_id) == $cita->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cita_edit_{{ $cita->id }}">
                            Cita #{{ $cita->id }} - {{ $cita->user->name ?? 'Usuario #'.$cita->user_id }} - {{ $cita->fecha }} {{ $cita->hora }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('cita_id')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" value="{{ $notificacion->estado }}" class="form-control" required>
            @error('estado')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" value="{{ $notificacion->fecha }}" class="form-control" required>
            @error('fecha')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <input type="text" name="mensaje" value="{{ $notificacion->mensaje }}" class="form-control" required>
            @error('mensaje')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white" style="background-color:#662a5b;">Actualizar</button>
                    <a href="{{ route('notificacions.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection