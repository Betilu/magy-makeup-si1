<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromocionServicio as PromocionServicioModel;
use App\Models\Servicio as ServicioModel;
use App\Models\Promocion as PromocionModel;

class PromocionServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PromocionServicioModel::with(['servicio', 'promocion'])->paginate(20);
        return view('promocion_servicios.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = ServicioModel::orderBy('nombre')->get();
        $promocions = PromocionModel::orderBy('nombre')->get();
        return view('promocion_servicios.create', compact('servicios', 'promocions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'servicio_id' => 'required|integer|exists:servicios,id',
            'promocion_id' => 'required|integer|exists:promocions,id',
        ]);

        PromocionServicioModel::create($data);

        return redirect()->route('promocion_servicios.index')->with('success', 'Promoción asignada al servicio correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = PromocionServicioModel::with(['servicio', 'promocion'])->findOrFail($id);
        return view('promocion_servicios.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = PromocionServicioModel::findOrFail($id);
        $servicios = ServicioModel::orderBy('nombre')->get();
        $promocions = PromocionModel::orderBy('nombre')->get();
        return view('promocion_servicios.edit', compact('item', 'servicios', 'promocions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = PromocionServicioModel::findOrFail($id);

        $data = $request->validate([
            'servicio_id' => 'required|integer|exists:servicios,id',
            'promocion_id' => 'required|integer|exists:promocions,id',
        ]);

        $item->update($data);

        return redirect()->route('promocion_servicios.index')->with('success', 'Asignación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = PromocionServicioModel::findOrFail($id);
        $item->delete();

        return redirect()->route('promocion_servicios.index')->with('success', 'Asignación eliminada correctamente');
    }
}
