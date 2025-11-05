@csrf

<div class="mb-3">
    <label class="form-label">Categoría</label>
    <input type="number" name="categoria" value="{{ old('categoria', $servicio->categoria ?? '') }}" class="form-control servicio-categoria" required>
    @error('categoria') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre ?? '') }}" class="form-control servicio-nombre" required maxlength="255">
    @error('nombre') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control servicio-descripcion">{{ old('descripcion', $servicio->descripcion ?? '') }}</textarea>
    @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Duración</label>
    <input type="text" name="duracion" value="{{ old('duracion', $servicio->duracion ?? '') }}" class="form-control servicio-duracion" required maxlength="255">
    @error('duracion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
