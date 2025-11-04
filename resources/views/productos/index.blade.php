@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0" style="font-weight:600;">
                    <svg class="icon me-2" style="width:20px; height:20px;">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                    </svg>
                    Gestión de Productos
                </h4>
                @can('crear productos')
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createProductModal" style="border-radius:8px; font-weight:500;">
                        <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use></svg>
                        Nuevo Producto
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body" style="padding:1.5rem;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border-left:4px solid #28a745;">
                    <svg class="icon me-2"><use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use></svg>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" style="border-radius:8px; overflow:hidden;">
                    <thead style="background-color:#f8f9fa;">
                        <tr>
                            <th style="font-weight:600;">Categoría</th>
                            <th style="font-weight:600;">Nombre</th>
                            <th style="font-weight:600;">Marca</th>
                            <th style="font-weight:600;">Precio</th>
                            <th style="font-weight:600;">Stock</th>
                            <th style="font-weight:600;">Vencimiento</th>
                            <th style="text-align:center; font-weight:600;">Acciones</th>
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
                                <td>{{ optional($producto->fechaVencimiento)->format('Y-m-d') }}</td>
                                <td style="text-align:center;">
                                    @can('ver productos')
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#showModal{{ $producto->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-eye') }}"></use></svg>
                                            Ver
                                        </button>
                                    @endcan

                                    @can('editar productos')
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{ $producto->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use></svg>
                                            Editar
                                        </button>
                                    @endcan

                                    @can('eliminar productos')
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $producto->id }}">
                                            <svg class="icon me-1"><use xlink:href="{{ asset('icons/coreui.svg#cil-trash') }}"></use></svg>
                                            Eliminar
                                        </button>
                                    @endcan
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            @can('ver productos')
                            <div class="modal fade" id="showModal{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background:#f8f9fa;">
                                            <h5 class="modal-title">Detalle Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Categoría:</strong> {{ $producto->cateogoria }}</p>
                                            <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                                            <p><strong>Marca:</strong> {{ $producto->marca }}</p>
                                            <p><strong>Precio:</strong> {{ $producto->precio }}</p>
                                            <p><strong>Stock actual:</strong> {{ $producto->stockActual }}</p>
                                            <p><strong>Stock mínimo:</strong> {{ $producto->stockMin }}</p>
                                            <p><strong>Fecha de vencimiento:</strong> {{ optional($producto->fechaVencimiento)->format('Y-m-d') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Editar -->
                            @can('editar productos')
                            <div class="modal fade" id="editModal{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('productos.update', $producto) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header" style="background:#f8f9fa;">
                                                <h5 class="modal-title">Editar Producto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('productos._form')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan

                            <!-- Modal Eliminar -->
                            @can('eliminar productos')
                            <div class="modal fade" id="deleteModal{{ $producto->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan

                        @empty
                            <tr>
                                <td colspan="7">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Producto -->
@can('crear productos')
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background:#f8f9fa;">
                    <h5 class="modal-title">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('productos._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var createModal = new bootstrap.Modal(document.getElementById('createProductModal'));
        createModal.show();
    });
</script>
@endif

@endsection
