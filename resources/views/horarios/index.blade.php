<!-- filepath: c:\Mis-Documentos\Bety\TEST\magy-makeup\resources\views\horarios\index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">Horarios</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('horarios.create') }}"
            style="background-color: #e83e8c; color: white; text-decoration: none; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Nuevo
            Horario</a>

        <br><br>
        <table class="table table-bordered bg-white">
            <thead class="table-light">
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($horarios as $horario)
                    <tr>
                        <td>{{ $horario->dia }}</td>
                        <td>{{ $horario->horaInicio }}</td>
                        <td>{{ $horario->horaFin }}</td>
                        <td>
                            <a href="{{ route('horarios.show', $horario->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este horario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
