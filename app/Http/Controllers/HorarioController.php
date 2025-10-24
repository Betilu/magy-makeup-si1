<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Illuminate\Support\Facades\Log;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Horario::query();

        // Aplicar filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('dia', 'like', "%{$search}%")
                  ->orWhere('horaInicio', 'like', "%{$search}%")
                  ->orWhere('horaFin', 'like', "%{$search}%");
        }

        // Filtro por día
        if ($request->filled('dia')) {
            $query->where('dia', $request->dia);
        }

        $horarios = $query->latest()->paginate(15)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($horarios);
        }

        return view('horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('horarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia' => 'required|string|max:255',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
        ], [
            'horaFin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ]);

        try {
            Horario::create($validated);
            
            Log::info('Horario creado', [
                'user_id' => auth()->id(),
                'dia' => $validated['dia']
            ]);

            return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear horario: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el horario.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $horario = Horario::findOrFail($id);
        return view('horarios.show', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $horario = Horario::findOrFail($id);
        return view('horarios.edit', compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        $validated = $request->validate([
            'dia' => 'required|string|max:255',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
        ], [
            'horaFin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ]);

        try {
            $horario->update($validated);
            
            Log::info('Horario actualizado', [
                'user_id' => auth()->id(),
                'horario_id' => $id
            ]);

            return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar horario: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el horario.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $horario = Horario::findOrFail($id);
            $dia = $horario->dia;
            
            $horario->delete();
            
            Log::info('Horario eliminado', [
                'user_id' => auth()->id(),
                'horario_id' => $id,
                'dia' => $dia
            ]);

            return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar horario: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el horario.');
        }
    }
}
