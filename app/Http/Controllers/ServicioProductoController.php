<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioProducto as ServicioProductoModel;
use App\Models\Servicio as ServicioModel;
use App\Models\Producto as ProductoModel;

class ServicioProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ServicioProductoModel::with(['servicio', 'producto'])->paginate(20);
        return view('servicio_productos.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = ServicioModel::orderBy('nombre')->get();
        $productos = ProductoModel::orderBy('nombre')->get();
        return view('servicio_productos.create', compact('servicios', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => 'required|integer|exists:servicios,id',
            'producto_id' => 'required|integer|exists:productos,id',
        ]);

        ServicioProductoModel::create($data);

        return redirect()->route('servicio_productos.index')->with('success', 'Producto asignado al servicio correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = ServicioProductoModel::with(['servicio', 'producto'])->findOrFail($id);
        return view('servicio_productos.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = ServicioProductoModel::findOrFail($id);
        $servicios = ServicioModel::orderBy('nombre')->get();
        $productos = ProductoModel::orderBy('nombre')->get();
        return view('servicio_productos.edit', compact('item', 'servicios', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = ServicioProductoModel::findOrFail($id);

        $data = $request->validate([
            'servicio_id' => 'required|integer|exists:servicios,id',
            'producto_id' => 'required|integer|exists:productos,id',
        ]);

        $item->update($data);

        return redirect()->route('servicio_productos.index')->with('success', 'Asignación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ServicioProductoModel::findOrFail($id);
        $item->delete();

        return redirect()->route('servicio_productos.index')->with('success', 'Asignación eliminada correctamente');
    }
}
