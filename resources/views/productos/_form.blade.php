<div class="mb-3">
    <label for="cateogoria" class="form-label">Categoría</label>
    <input type="text" name="cateogoria" class="form-control producto-cateogoria" value="{{ old('cateogoria', $producto->cateogoria ?? '') }}">
    @error('cateogoria')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control producto-nombre" value="{{ old('nombre', $producto->nombre ?? '') }}">
    @error('nombre')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" name="marca" class="form-control producto-marca" value="{{ old('marca', $producto->marca ?? '') }}">
    @error('marca')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="text" name="precio" class="form-control producto-precio" value="{{ old('precio', $producto->precio ?? '') }}">
    @error('precio')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="stockActual" class="form-label">Stock Actual</label>
        <input type="number" step="0.01" name="stockActual" class="form-control producto-stockActual" value="{{ old('stockActual', $producto->stockActual ?? '') }}">
        @error('stockActual')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="stockMin" class="form-label">Stock Mínimo</label>
        <input type="number" step="0.01" name="stockMin" class="form-control producto-stockMin" value="{{ old('stockMin', $producto->stockMin ?? '') }}">
        @error('stockMin')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
    <input type="date" name="fechaVencimiento" class="form-control producto-fechaVencimiento" value="{{ old('fechaVencimiento', isset($producto->fechaVencimiento) ? $producto->fechaVencimiento->format('Y-m-d') : '') }}">
    @error('fechaVencimiento')<div class="text-danger">{{ $message }}</div>@enderror
</div>
