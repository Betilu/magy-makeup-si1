<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion as PromocionModel;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promocions = PromocionModel::orderBy('fechaInicio', 'desc')->paginate(15);
        return view('promocions.index', compact('promocions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promocions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'descuento' => 'required|numeric',
        ]);

        PromocionModel::create($data);

        return redirect()->route('promocions.index')->with('success', 'Promoción creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promocion = PromocionModel::findOrFail($id);
        return view('promocions.show', compact('promocion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promocion = PromocionModel::findOrFail($id);
        return view('promocions.edit', compact('promocion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promocion = PromocionModel::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'descuento' => 'required|numeric',
        ]);

        $promocion->update($data);

        return redirect()->route('promocions.index')->with('success', 'Promoción actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promocion = PromocionModel::findOrFail($id);
        $promocion->delete();

        return redirect()->route('promocions.index')->with('success', 'Promoción eliminada correctamente');
    }
}
