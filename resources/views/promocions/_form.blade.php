@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $promocion->nombre ?? '') }}" class="form-control promocion-nombre" required maxlength="255">
    @error('nombre') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control promocion-descripcion">{{ old('descripcion', $promocion->descripcion ?? '') }}</textarea>
    @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha inicio</label>
        <input type="date" name="fechaInicio" value="{{ old('fechaInicio', isset($promocion->fechaInicio) ? $promocion->fechaInicio->format('Y-m-d') : '') }}" class="form-control promocion-fechaInicio" required>
        @error('fechaInicio') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha fin</label>
        <input type="date" name="fechaFin" value="{{ old('fechaFin', isset($promocion->fechaFin) ? $promocion->fechaFin->format('Y-m-d') : '') }}" class="form-control promocion-fechaFin" required>
        @error('fechaFin') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Descuento</label>
    <input type="number" step="0.01" name="descuento" value="{{ old('descuento', $promocion->descuento ?? '') }}" class="form-control promocion-descuento" required>
    @error('descuento') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
