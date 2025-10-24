<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\citas\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Citas</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('citas.create') }}" style="background-color: #e83e8c; color: white; text-decoration: none; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Nueva Cita</a>
    <br><br>
    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Anticipo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->user_id }}</td>
                <td>{{ $cita->estado }}</td>
                <td>${{ number_format($cita->anticipo, 2) }}</td>
                <td>{{ $cita->fecha }}</td>
                <td>{{ $cita->hora }}</td>
                <td>{{ $cita->tipo }}</td>
                <td>
                    <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cita?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection