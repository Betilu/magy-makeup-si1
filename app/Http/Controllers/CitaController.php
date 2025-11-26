<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\User;
use App\Models\Client;
use App\Models\Estilista;
use App\Models\Servicio;
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
            $citas = Cita::with(['user', 'estilista.user', 'servicio'])
                ->where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->paginate(15);
        } else {
            // Admin y recepcionista ven todas las citas
            $citas = Cita::with(['user', 'estilista.user', 'servicio'])
                ->orderBy('fecha', 'desc')
                ->paginate(15);
        }
        
        // Obtener solo los usuarios que son clientes (tienen registro en tabla clients)
        $clientes = $this->getClientes();
        
        // Obtener estilistas y servicios
        $estilistas = Estilista::with('user')->get();
        $servicios = Servicio::where('estado', 'activo')->get();
        
        return view('citas.index', compact('citas', 'clientes', 'estilistas', 'servicios'));
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
            'estilista_id' => 'required|exists:estilistas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado' => 'nullable|string',
            'anticipo' => 'nullable|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
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

            // Obtener el servicio para calcular el precio
            $servicio = Servicio::findOrFail($validated['servicio_id']);
            $estilista = Estilista::findOrFail($validated['estilista_id']);
            
            // Calcular precio total y comisión
            $validated['precio_total'] = $servicio->precio_servicio;
            $validated['comision_estilista'] = $estilista->calcularComision($servicio->precio_servicio);

            // Crear la cita
            $cita = Cita::create($validated);

            // Actualizar total de comisiones del estilista
            $estilista->total_comisiones += $validated['comision_estilista'];
            $estilista->save();

            DB::commit();

            return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear la cita: ' . $e->getMessage());
        }
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
            'estilista_id' => 'required|exists:estilistas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado' => 'required|string',
            'anticipo' => 'nullable|numeric',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'tipo' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Si cambiaron el servicio o estilista, recalcular comisiones
            $servicioAnterior = $cita->servicio;
            $estilistaAnterior = $cita->estilista;
            
            $servicio = Servicio::findOrFail($validated['servicio_id']);
            $estilista = Estilista::findOrFail($validated['estilista_id']);
            
            // Restar comisión anterior del estilista anterior
            if ($estilistaAnterior) {
                $estilistaAnterior->total_comisiones -= $cita->comision_estilista;
                $estilistaAnterior->save();
            }
            
            // Calcular nuevo precio total y comisión
            $validated['precio_total'] = $servicio->precio_servicio;
            $validated['comision_estilista'] = $estilista->calcularComision($servicio->precio_servicio);
            
            // Actualizar la cita
            $cita->update($validated);
            
            // Sumar nueva comisión al estilista
            $estilista->total_comisiones += $validated['comision_estilista'];
            $estilista->save();

            DB::commit();

            return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $this->authorize('delete', $cita);
        
        DB::beginTransaction();
        try {
            // Restar la comisión del estilista antes de eliminar
            if ($cita->estilista) {
                $cita->estilista->total_comisiones -= $cita->comision_estilista;
                $cita->estilista->save();
            }
            
            $cita->delete();
            
            DB::commit();
            
            return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }
}
