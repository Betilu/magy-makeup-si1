<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsignacionHerramienta as AsignacionHerramientaModel;
use App\Models\Herramienta as HerramientaModel;
use App\Models\Estilista as EstilistaModel;
use App\Models\User as UserModel;

class AsignacionHerramientaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = AsignacionHerramientaModel::with(['herramienta', 'estilista', 'recepcionista'])->orderBy('fechaAsignacion', 'desc')->paginate(20);
        return view('asignacion_herramientas.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $herramientas = HerramientaModel::orderBy('nombre')->get();
        $estilistas = EstilistaModel::orderBy('nombre')->get();
        $recepcionistas = UserModel::orderBy('name')->get();

        return view('asignacion_herramientas.create', compact('herramientas', 'estilistas', 'recepcionistas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'herramienta_id' => 'required|integer|exists:herramientas,id',
            'estilista_id' => 'required|integer|exists:estilistas,id',
            'recepcionista_id' => 'required|integer|exists:users,id',
            'estadoEntrega' => 'required|string|max:255',
            'estadoDevolucion' => 'nullable|string|max:255',
            'fechaAsignacion' => 'required|date',
            'fechaDevolucion' => 'nullable|date|after_or_equal:fechaAsignacion',
        ]);

        AsignacionHerramientaModel::create($data);

        return redirect()->route('asignacion_herramientas.index')->with('success', 'Asignación creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = AsignacionHerramientaModel::with(['herramienta', 'estilista', 'recepcionista'])->findOrFail($id);
        return view('asignacion_herramientas.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = AsignacionHerramientaModel::findOrFail($id);
        $herramientas = HerramientaModel::orderBy('nombre')->get();
        $estilistas = EstilistaModel::orderBy('nombre')->get();
        $recepcionistas = UserModel::orderBy('name')->get();

        return view('asignacion_herramientas.edit', compact('item', 'herramientas', 'estilistas', 'recepcionistas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = AsignacionHerramientaModel::findOrFail($id);

        $data = $request->validate([
            'herramienta_id' => 'required|integer|exists:herramientas,id',
            'estilista_id' => 'required|integer|exists:estilistas,id',
            'recepcionista_id' => 'required|integer|exists:users,id',
            'estadoEntrega' => 'required|string|max:255',
            'estadoDevolucion' => 'nullable|string|max:255',
            'fechaAsignacion' => 'required|date',
            'fechaDevolucion' => 'nullable|date|after_or_equal:fechaAsignacion',
        ]);

        $item->update($data);

        return redirect()->route('asignacion_herramientas.index')->with('success', 'Asignación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = AsignacionHerramientaModel::findOrFail($id);
        $item->delete();

        return redirect()->route('asignacion_herramientas.index')->with('success', 'Asignación eliminada correctamente');
    }
}
