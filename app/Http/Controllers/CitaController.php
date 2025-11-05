<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Use pagination so the view can call ->links() without error
        $citas = Cita::with('user')->orderBy('fecha', 'desc')->paginate(15);
        return view('citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('citas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|string',
            'anticipo' => 'required|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        Cita::create($validated);
        return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|string',
            'anticipo' => 'required|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        $cita->update($validated);
        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
    }
}
