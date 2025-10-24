<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HerramientaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $herramientas = Herramienta::latest()->paginate(10);
        return view('herramientas.index', compact('herramientas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('herramientas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'fechaAdquisicion' => 'required|date',
            'estadoHerramienta' => 'required|in:Disponible,En uso,En mantenimiento,Fuera de servicio',
            'observacion' => 'nullable|string|max:1000',
        ]);

        try {
            Herramienta::create($validated);
            
            Log::info('Herramienta creada', [
                'user_id' => auth()->id(),
                'herramienta' => $validated['nombre']
            ]);

            return redirect()->route('herramientas.index')
                ->with('success', 'Herramienta creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear herramienta: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al crear la herramienta.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $herramienta = Herramienta::findOrFail($id);
        return view('herramientas.show', compact('herramienta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $herramienta = Herramienta::findOrFail($id);
        return view('herramientas.edit', compact('herramienta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $herramienta = Herramienta::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'fechaAdquisicion' => 'required|date',
            'estadoHerramienta' => 'required|in:Disponible,En uso,En mantenimiento,Fuera de servicio',
            'observacion' => 'nullable|string|max:1000',
        ]);

        try {
            $herramienta->update($validated);
            
            Log::info('Herramienta actualizada', [
                'user_id' => auth()->id(),
                'herramienta_id' => $id,
                'herramienta' => $validated['nombre']
            ]);

            return redirect()->route('herramientas.index')
                ->with('success', 'Herramienta actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar herramienta: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al actualizar la herramienta.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $herramienta = Herramienta::findOrFail($id);
            $nombreHerramienta = $herramienta->nombre;
            
            $herramienta->delete();
            
            Log::info('Herramienta eliminada', [
                'user_id' => auth()->id(),
                'herramienta_id' => $id,
                'herramienta' => $nombreHerramienta
            ]);

            return redirect()->route('herramientas.index')
                ->with('success', 'Herramienta eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar herramienta: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la herramienta.');
        }
    }
}
