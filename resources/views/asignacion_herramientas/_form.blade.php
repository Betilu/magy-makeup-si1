@csrf

<div class="mb-3">
    <label class="form-label">Herramienta</label>
    <select name="herramienta_id" class="form-select asignacion-herramienta-herramienta" required>
        <option value="">-- Seleccione --</option>
        @foreach($herramientas as $h)
            <option value="{{ $h->id }}" {{ (string)old('herramienta_id', isset($item) ? $item->herramienta_id : '') === (string)$h->id ? 'selected' : '' }}>{{ $h->nombre }}</option>
        @endforeach
    </select>
    @error('herramienta_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Estilista</label>
    <select name="estilista_id" class="form-select asignacion-herramienta-estilista" required>
        <option value="">-- Seleccione --</option>
        @foreach($estilistas as $e)
            <option value="{{ $e->id }}" {{ (string)old('estilista_id', isset($item) ? $item->estilista_id : '') === (string)$e->id ? 'selected' : '' }}>{{ $e->user->name ?? 'Sin nombre' }}</option>
        @endforeach
    </select>
    @error('estilista_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Recepcionista</label>
    <select name="recepcionista_id" class="form-select asignacion-herramienta-recepcionista" required>
        <option value="">-- Seleccione --</option>
        @foreach($recepcionistas as $r)
            <option value="{{ $r->id }}" {{ (string)old('recepcionista_id', isset($item) ? $item->recepcionista_id : '') === (string)$r->id ? 'selected' : '' }}>{{ $r->name }}</option>
        @endforeach
    </select>
    @error('recepcionista_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado entrega</label>
        <select name="estadoEntrega" class="form-select asignacion-herramienta-estadoEntrega" required>
            <option value="">-- Seleccione --</option>
            @foreach(App\Models\AsignacionHerramienta::getEstados() as $value => $label)
                <option value="{{ $value }}" {{ old('estadoEntrega', isset($item) ? $item->estadoEntrega : '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('estadoEntrega') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Estado devolución</label>
        <select name="estadoDevolucion" class="form-select asignacion-herramienta-estadoDevolucion">
            <option value="">-- Seleccione --</option>
            @foreach(App\Models\AsignacionHerramienta::getEstados() as $value => $label)
                <option value="{{ $value }}" {{ old('estadoDevolucion', isset($item) ? $item->estadoDevolucion : '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('estadoDevolucion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha asignación</label>
        <input type="date" name="fechaAsignacion" value="{{ old('fechaAsignacion', isset($item->fechaAsignacion) ? $item->fechaAsignacion->format('Y-m-d') : '') }}" class="form-control asignacion-herramienta-fechaAsignacion" required>
        @error('fechaAsignacion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha devolución</label>
        <input type="date" name="fechaDevolucion" value="{{ old('fechaDevolucion', isset($item->fechaDevolucion) ? $item->fechaDevolucion->format('Y-m-d') : '') }}" class="form-control asignacion-herramienta-fechaDevolucion">
        @error('fechaDevolucion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>
