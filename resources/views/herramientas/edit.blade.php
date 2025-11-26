@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.5rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:24px; height:24px;">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                </svg>
                Editar Herramienta
            </h4>
        </div>

        <div class="card-body" style="padding:2rem;">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #dc3545;">
                    <h5 class="alert-heading">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-x-circle') }}"></use>
                        </svg>
                        Por favor corrija los siguientes errores:
                    </h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('herramientas.update', $herramienta->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label" style="font-weight:600; color:#662a5b;">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre" name="nombre" value="{{ old('nombre', $herramienta->nombre) }}"
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tipo" class="form-label" style="font-weight:600; color:#662a5b;">Tipo *</label>
                        <input type="text" class="form-control @error('tipo') is-invalid @enderror"
                               id="tipo" name="tipo" value="{{ old('tipo', $herramienta->tipo) }}"
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="marca" class="form-label" style="font-weight:600; color:#662a5b;">Marca *</label>
                        <input type="text" class="form-control @error('marca') is-invalid @enderror"
                               id="marca" name="marca" value="{{ old('marca', $herramienta->marca) }}"
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="modelo" class="form-label" style="font-weight:600; color:#662a5b;">Modelo *</label>
                        <input type="text" class="form-control @error('modelo') is-invalid @enderror"
                               id="modelo" name="modelo" value="{{ old('modelo', $herramienta->modelo) }}"
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label" style="font-weight:600; color:#662a5b;">Cantidad *</label>
                        <input type="number" class="form-control @error('cantidad') is-invalid @enderror"
                               id="cantidad" name="cantidad" value="{{ old('cantidad', $herramienta->cantidad) }}"
                               min="0" required
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fechaAdquisicion" class="form-label" style="font-weight:600; color:#662a5b;">Fecha de Adquisición *</label>
                        <input type="date" class="form-control @error('fechaAdquisicion') is-invalid @enderror"
                               id="fechaAdquisicion" name="fechaAdquisicion" value="{{ old('fechaAdquisicion', $herramienta->fechaAdquisicion) }}"
                               style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                        @error('fechaAdquisicion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estadoHerramienta" class="form-label" style="font-weight:600; color:#662a5b;">Estado *</label>
                        <select class="form-select @error('estadoHerramienta') is-invalid @enderror"
                                id="estadoHerramienta" name="estadoHerramienta"
                                style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">
                            <option value="">Seleccione un estado</option>
                            <option value="Disponible" {{ old('estadoHerramienta', $herramienta->estadoHerramienta) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="En uso" {{ old('estadoHerramienta', $herramienta->estadoHerramienta) == 'En uso' ? 'selected' : '' }}>En uso</option>
                            <option value="En mantenimiento" {{ old('estadoHerramienta', $herramienta->estadoHerramienta) == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                            <option value="Fuera de servicio" {{ old('estadoHerramienta', $herramienta->estadoHerramienta) == 'Fuera de servicio' ? 'selected' : '' }}>Fuera de servicio</option>
                        </select>
                        @error('estadoHerramienta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="observacion" class="form-label" style="font-weight:600; color:#662a5b;">Observaciones</label>
                    <textarea class="form-control @error('observacion') is-invalid @enderror"
                              id="observacion" name="observacion" rows="3"
                              style="border-radius:10px; border:1px solid #dee2e6; padding:0.75rem;">{{ old('observacion', $herramienta->observacion) }}</textarea>
                    @error('observacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('herramientas.index') }}" class="btn btn-secondary" style="border-radius:10px; padding:0.75rem 2rem;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-x') }}"></use>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn text-white" style="background-color:#662a5b; border-radius:10px; padding:0.75rem 2rem;">
                        <svg class="icon me-1">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-check') }}"></use>
                        </svg>
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
