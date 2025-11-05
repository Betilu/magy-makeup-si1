<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Cita;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load client (and its user if needed) to avoid N+1 when rendering list
        $notificacions = Notificacion::with('client.user')->get();
        return view('notificacions.index', compact('notificacions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pasar las citas con su cliente (y el usuario del cliente) para mostrar
        // en la vista radios con "nombre del cliente - id de la cita".
        $citas = Cita::with('client.user')->get();
        return view('notificacions.create', compact('citas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cita_id' => 'required|exists:citas,id',
            'estado' => 'required|string',
            'fecha' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        // Asegurarse que client_id venga desde la cita seleccionada (evita manipulación desde el cliente)
        $cita = Cita::findOrFail($validated['cita_id']);
        $validated['client_id'] = $cita->client_id;

        Notificacion::create($validated);
        return redirect()->route('notificacions.index')->with('success', 'Notificación creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notificacion = Notificacion::findOrFail($id);
        return view('notificacions.show', compact('notificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notificacion = Notificacion::findOrFail($id);
        return view('notificacions.edit', compact('notificacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notificacion = Notificacion::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'cita_id' => 'required|exists:citas,id',
            'estado' => 'required|string',
            'fecha' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        $notificacion->update($validated);
        return redirect()->route('notificacions.index')->with('success', 'Notificación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();
        return redirect()->route('notificacions.index')->with('success', 'Notificación eliminada correctamente');
    }
}
