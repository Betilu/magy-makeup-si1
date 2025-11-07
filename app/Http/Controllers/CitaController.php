<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    /**
     * Obtener lista de clientes (usuarios con registro en tabla clients)
     */
    private function getClientes()
    {
        return User::select('users.id', 'users.name')
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->orderBy('users.name')
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Cita::class);
        
        $user = Auth::user();
        
        // Si es cliente, solo muestra sus propias citas
        if ($user->hasRole('cliente') && !$user->hasRole('super-admin')) {
            $citas = Cita::with('user')
                ->where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->paginate(15);
        } else {
            // Admin y recepcionista ven todas las citas
            $citas = Cita::with('user')->orderBy('fecha', 'desc')->paginate(15);
        }
        
        // Obtener solo los usuarios que son clientes (tienen registro en tabla clients)
        $clientes = $this->getClientes();
        
        return view('citas.index', compact('citas', 'clientes'));
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
        $this->authorize('create', Cita::class);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estado' => 'nullable|string',
            'anticipo' => 'nullable|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        // Si es cliente, forzar que el user_id sea el del usuario autenticado
        // y establecer el estado como "pendiente"
        if (Auth::user()->hasRole('cliente') && !Auth::user()->hasRole('super-admin')) {
            $validated['user_id'] = Auth::id();
            $validated['estado'] = 'pendiente';
        }
        
        // Si no se especificó estado, establecer como "pendiente"
        if (!isset($validated['estado'])) {
            $validated['estado'] = 'pendiente';
        }

        Cita::create($validated);
        return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::findOrFail($id);
        $this->authorize('view', $cita);
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
        $this->authorize('update', $cita);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|string',
            'anticipo' => 'nullable|numeric',
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
        $this->authorize('delete', $cita);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
    }
}
