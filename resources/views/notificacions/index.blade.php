<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\notificacions\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Notificaciones</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('notificacions.create') }}" class="btn btn-primary mb-3">Nueva Notificación</a>
    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Cliente</th>
                <th>Cita</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Mensaje</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notificacions as $notificacion)
            <tr>
                <td>{{ $notificacion->client_id }}</td>
                <td>{{ $notificacion->cita_id }}</td>
                <td>{{ $notificacion->estado }}</td>
                <td>{{ $notificacion->fecha }}</td>
                <td>{{ $notificacion->mensaje }}</td>
                <td>
                    <a href="{{ route('notificacions.show', $notificacion->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('notificacions.edit', $notificacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('notificacions.destroy', $notificacion->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta notificación?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection