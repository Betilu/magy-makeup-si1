<div class="mb-3">
    <label for="cateogoria" class="form-label">Categoría</label>
    <input type="text" name="cateogoria" id="cateogoria" class="form-control" value="{{ old('cateogoria', $producto->cateogoria ?? '') }}">
    @error('cateogoria')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre ?? '') }}">
    @error('nombre')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca', $producto->marca ?? '') }}">
    @error('marca')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="text" name="precio" id="precio" class="form-control" value="{{ old('precio', $producto->precio ?? '') }}">
    @error('precio')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="stockActual" class="form-label">Stock Actual</label>
        <input type="number" step="0.01" name="stockActual" id="stockActual" class="form-control" value="{{ old('stockActual', $producto->stockActual ?? '') }}">
        @error('stockActual')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="stockMin" class="form-label">Stock Mínimo</label>
        <input type="number" step="0.01" name="stockMin" id="stockMin" class="form-control" value="{{ old('stockMin', $producto->stockMin ?? '') }}">
        @error('stockMin')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
    <input type="date" name="fechaVencimiento" id="fechaVencimiento" class="form-control" value="{{ old('fechaVencimiento', isset($producto->fechaVencimiento) ? $producto->fechaVencimiento->format('Y-m-d') : '') }}">
    @error('fechaVencimiento')<div class="text-danger">{{ $message }}</div>@enderror
</div>
