@csrf

<div class="mb-3">
    <label class="form-label">Servicio</label>
    <select name="servicio_id" class="form-select promocion-servicio-servicio" required>
        <option value="">-- Seleccione --</option>
        @foreach($servicios as $s)
            <option value="{{ $s->id }}" {{ (string)old('servicio_id', isset($item) ? $item->servicio_id : '') === (string)$s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
        @endforeach
    </select>
    @error('servicio_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Promoción</label>
    <select name="promocion_id" class="form-select promocion-servicio-promocion" required>
        <option value="">-- Seleccione --</option>
        @foreach($promocions as $p)
            <option value="{{ $p->id }}" {{ (string)old('promocion_id', isset($item) ? $item->promocion_id : '') === (string)$p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
        @endforeach
    </select>
    @error('promocion_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
