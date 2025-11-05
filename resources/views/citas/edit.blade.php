<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use></svg>
                Editar Cita
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
                @csrf
                @method('PUT')
                @php $users = App\Models\User::orderBy('name')->get(); @endphp
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <div>
                        @foreach($users as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_id" id="user_{{ $user->id }}" value="{{ $user->id }}" {{ (old('user_id', $cita->user_id) == $user->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_{{ $user->id }}">{{ $user->name }}{{ isset($user->email) ? ' - '.$user->email : '' }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('user_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="estado" value="{{ $cita->estado }}" class="form-control" required>
                    @error('estado')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Anticipo</label>
                    <input type="number" step="0.01" name="anticipo" value="{{ $cita->anticipo }}" class="form-control" required>
                    @error('anticipo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ $cita->fecha }}" class="form-control" required>
                    @error('fecha')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" value="{{ $cita->hora }}" class="form-control" required>
                    @error('hora')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="tipo" value="{{ $cita->tipo }}" class="form-control" required>
                    @error('tipo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white" style="background-color:#662a5b;">Actualizar</button>
                    <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection