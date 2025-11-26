<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio as ServicioModel;
use App\Traits\LogsActivity;

class ServicioController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = ServicioModel::orderBy('nombre')->paginate(15);
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria' => 'required|string',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'required|string|max:255',
            'precio_servicio' => 'required|numeric|min:0',
            'estado' => 'required|string',
        ]);

        $servicio = ServicioModel::create($data);

        // Registrar en bitácora
        $this->logActivity(
            'Crear Servicio',
            "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) creó el servicio '{$servicio->nombre}' - Categoría: {$servicio->categoria} - Precio: \${$servicio->precio_servicio}"
        );

        return redirect()->route('servicios.index')->with('success', 'Servicio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servicio = ServicioModel::findOrFail($id);

        // Registrar en bitácora
        $this->logActivity(
            'Ver Servicio',
            "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) visualizó el servicio '{$servicio->nombre}'"
        );

        return view('servicios.show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = ServicioModel::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $servicio = ServicioModel::findOrFail($id);

        $data = $request->validate([
            'categoria' => 'required|string',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'required|string|max:255',
            'precio_servicio' => 'required|numeric|min:0',
            'estado' => 'required|string',
        ]);

        $servicio->update($data);

        // Registrar en bitácora
        $this->logActivity(
            'Editar Servicio',
            "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) editó el servicio '{$servicio->nombre}' - Categoría: {$servicio->categoria} - Precio: \${$servicio->precio_servicio}"
        );

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = ServicioModel::findOrFail($id);
        $servicioNombre = $servicio->nombre;
        $servicioCategoria = $servicio->categoria;

        $servicio->delete();

        // Registrar en bitácora
        $this->logActivity(
            'Eliminar Servicio',
            "{$this->getCurrentUserName()} ({$this->getCurrentUserRole()}) eliminó el servicio '{$servicioNombre}' - Categoría: {$servicioCategoria}"
        );

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente');
    }
}
