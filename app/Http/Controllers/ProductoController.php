<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto as ProductoModel;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = ProductoModel::orderBy('nombre')->paginate(15);
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cateogoria' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'required|string|max:255',
            'stockActual' => 'required|numeric',
            'stockMin' => 'required|numeric',
            'fechaVencimiento' => 'required|date',
        ]);

        ProductoModel::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = ProductoModel::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = ProductoModel::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = ProductoModel::findOrFail($id);

        $data = $request->validate([
            'cateogoria' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'required|string|max:255',
            'stockActual' => 'required|numeric',
            'stockMin' => 'required|numeric',
            'fechaVencimiento' => 'required|date',
        ]);

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = ProductoModel::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }

}
