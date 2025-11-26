<div class="mb-3">
    <label class="form-label">Herramienta <span class="text-danger">*</span></label>
    <select name="herramienta_id" class="form-select" required>
        <option value="">-- Seleccione una herramienta --</option>
        @foreach(App\Models\Herramienta::orderBy('nombre')->get() as $herramienta)
            <option value="{{ $herramienta->id }}" {{ old('herramienta_id', isset($incidencia) ? $incidencia->herramienta_id : '') == $herramienta->id ? 'selected' : '' }}>
                {{ $herramienta->nombre }} (Disponibles: {{ $herramienta->cantidad }})
            </option>
        @endforeach
    </select>
    @error('herramienta_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="alert alert-info" style="border-radius:10px; border-left:4px solid #0dcaf0;">
    <svg class="icon me-2">
        <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
    </svg>
    <strong>Nota:</strong> Al registrar esta incidencia, la cantidad disponible de la herramienta seleccionada se reducirá automáticamente en 1 unidad y su estado cambiará según el tipo de incidente.
</div>

<div class="mb-3">
    <label class="form-label">Tipo de Incidente <span class="text-danger">*</span></label>
    <select name="tipo_incidente" class="form-select" required>
        <option value="">-- Seleccione --</option>
        @foreach(App\Models\Incidencia::getTiposIncidente() as $value => $label)
            <option value="{{ $value }}" {{ old('tipo_incidente', isset($incidencia) ? $incidencia->tipo_incidente : '') === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('tipo_incidente') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción <span class="text-danger">*</span></label>
    <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', isset($incidencia) ? $incidencia->descripcion : '') }}</textarea>
    @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha Incidente <span class="text-danger">*</span></label>
        <input type="date" name="fechaIncidente" class="form-control" value="{{ old('fechaIncidente', isset($incidencia) && $incidencia->fechaIncidente ? $incidencia->fechaIncidente->format('Y-m-d') : '') }}" required>
        @error('fechaIncidente') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha Remplazo</label>
        <input type="date" name="fechaRemplazo" class="form-control" value="{{ old('fechaRemplazo', isset($incidencia) && $incidencia->fechaRemplazo ? $incidencia->fechaRemplazo->format('Y-m-d') : '') }}">
        @error('fechaRemplazo') <div class="text-danger small">{{ $message }}</div> @enderror
        <small class="text-muted">Opcional - Debe ser igual o posterior a la fecha del incidente</small>
    </div>
</div>
