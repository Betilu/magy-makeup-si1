@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Productos</h1>
        <!-- Botón para abrir modal Crear -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">Crear producto</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Stock Mín</th>
                    <th>Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->cateogoria }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->marca }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->stockActual }}</td>
                        <td>{{ $producto->stockMin }}</td>
                        <td>{{ optional($producto->fechaVencimiento)->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info btn-show" type="button" data-product='@json($producto)'>Ver</button>
                            <button class="btn btn-sm btn-warning btn-edit" type="button" data-product='@json($producto)'>Editar</button>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $productos->links() }}
    </div>
</div>

<!-- Modal Crear Producto -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Crear producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        @include('productos._form')
                        <div class="mt-3 text-end">
                                <button class="btn btn-primary">Crear</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        @include('productos._form')
                        <div class="mt-3 text-end">
                                <button class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mostrar Producto -->
<div class="modal fade" id="showProductModal" tabindex="-1" aria-labelledby="showProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showProductModalLabel">Detalle producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="showProductBody">
                <!-- Contenido llenado por JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
        // Handler para Edit
        document.querySelectorAll('.btn-edit').forEach(function(btn){
                btn.addEventListener('click', function(){
                        const product = JSON.parse(this.getAttribute('data-product'));
                        const form = document.getElementById('editProductForm');
                        form.action = '/productos/' + product.id;
                        // populate fields
                        document.getElementById('cateogoria').value = product.cateogoria ?? '';
                        document.getElementById('nombre').value = product.nombre ?? '';
                        document.getElementById('marca').value = product.marca ?? '';
                        document.getElementById('precio').value = product.precio ?? '';
                        document.getElementById('stockActual').value = product.stockActual ?? '';
                        document.getElementById('stockMin').value = product.stockMin ?? '';
                        // fecha - try to extract date part
                        let fecha = product.fechaVencimiento ?? null;
                        if(fecha){
                                // fecha might be '2025-11-04T00:00:00.000000Z' or '2025-11-04'
                                const d = new Date(fecha);
                                if(!isNaN(d)){
                                        const yyyy = d.getFullYear();
                                        const mm = String(d.getMonth()+1).padStart(2,'0');
                                        const dd = String(d.getDate()).padStart(2,'0');
                                        document.getElementById('fechaVencimiento').value = `${yyyy}-${mm}-${dd}`;
                                } else {
                                        document.getElementById('fechaVencimiento').value = fecha;
                                }
                        } else {
                                document.getElementById('fechaVencimiento').value = '';
                        }

                        // show modal
                        var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                        editModal.show();
                });
        });

        // Handler para Show
        document.querySelectorAll('.btn-show').forEach(function(btn){
                btn.addEventListener('click', function(){
                        const product = JSON.parse(this.getAttribute('data-product'));
                        const body = document.getElementById('showProductBody');
                        body.innerHTML = `
                                <p><strong>Categoría:</strong> ${product.cateogoria ?? ''}</p>
                                <p><strong>Nombre:</strong> ${product.nombre ?? ''}</p>
                                <p><strong>Marca:</strong> ${product.marca ?? ''}</p>
                                <p><strong>Precio:</strong> ${product.precio ?? ''}</p>
                                <p><strong>Stock actual:</strong> ${product.stockActual ?? ''}</p>
                                <p><strong>Stock mínimo:</strong> ${product.stockMin ?? ''}</p>
                                <p><strong>Fecha de vencimiento:</strong> ${product.fechaVencimiento ? (new Date(product.fechaVencimiento)).toISOString().split('T')[0] : ''}</p>
                        `;
                        var showModal = new bootstrap.Modal(document.getElementById('showProductModal'));
                        showModal.show();
                });
        });
});
</script>
@endpush

@endsection
