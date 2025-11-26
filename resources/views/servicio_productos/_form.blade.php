@csrf

<div class="mb-3">
    <label class="form-label">Servicio</label>
    <select name="servicio_id" class="form-select servicio-producto-servicio" required>
        <option value="">-- Seleccione --</option>
        @foreach($servicios as $s)
            <option value="{{ $s->id }}" {{ (string)old('servicio_id', isset($item) ? $item->servicio_id : '') === (string)$s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
        @endforeach
    </select>
    @error('servicio_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Producto</label>
    <select name="producto_id" class="form-select servicio-producto-producto" required>
        <option value="">-- Seleccione --</option>
        @foreach($productos as $p)
            <option value="{{ $p->id }}" {{ (string)old('producto_id', isset($item) ? $item->producto_id : '') === (string)$p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
        @endforeach
    </select>
    @error('producto_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Cantidad</label>
    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', isset($item) ? $item->cantidad : 1) }}" min="1" required>
    @error('cantidad') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
