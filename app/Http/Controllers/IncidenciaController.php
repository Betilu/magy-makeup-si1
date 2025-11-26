<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Herramienta;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidencias = Incidencia::with('herramienta')->orderBy('fechaIncidente', 'desc')->paginate(15);
        return view('incidencias.index', compact('incidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incidencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'herramienta_id' => 'required|exists:herramientas,id',
            'tipo_incidente' => 'required|in:En revisión,Dañada,Perdida',
            'descripcion' => 'required|string',
            'fechaIncidente' => 'required|date',
            'fechaRemplazo' => 'nullable|date|after_or_equal:fechaIncidente',
        ]);

        // Crear la incidencia
        $incidencia = Incidencia::create($validated);

        // Actualizar el estado de la herramienta y disminuir cantidad
        $mensaje = $this->actualizarEstadoYCantidadHerramienta($validated['herramienta_id'], $validated['tipo_incidente']);

        return redirect()->route('incidencias.index')->with($mensaje['type'], $mensaje['message']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incidencia = Incidencia::with('herramienta')->findOrFail($id);
        return view('incidencias.show', compact('incidencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('incidencias.edit', compact('incidencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $incidencia = Incidencia::findOrFail($id);
        $herramientaAnterior = $incidencia->herramienta_id;

        $validated = $request->validate([
            'herramienta_id' => 'required|exists:herramientas,id',
            'tipo_incidente' => 'required|in:En revisión,Dañada,Perdida',
            'descripcion' => 'required|string',
            'fechaIncidente' => 'required|date',
            'fechaRemplazo' => 'nullable|date|after_or_equal:fechaIncidente',
        ]);

        $incidencia->update($validated);

        // Si cambió la herramienta, actualizar la nueva
        if ($herramientaAnterior != $validated['herramienta_id']) {
            $mensaje = $this->actualizarEstadoYCantidadHerramienta($validated['herramienta_id'], $validated['tipo_incidente']);
        } else {
            // Actualizar solo el estado si es la misma herramienta
            $this->actualizarEstadoHerramienta($validated['herramienta_id'], $validated['tipo_incidente']);
            $mensaje = ['type' => 'success', 'message' => 'Incidencia actualizada correctamente'];
        }

        return redirect()->route('incidencias.index')->with($mensaje['type'], $mensaje['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incidencia = Incidencia::findOrFail($id);
        $incidencia->delete();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada correctamente');
    }

    /**
     * Actualizar el estado de la herramienta según el tipo de incidente (sin modificar cantidad)
     */
    private function actualizarEstadoHerramienta($herramientaId, $tipoIncidente)
    {
        $herramienta = Herramienta::find($herramientaId);

        if (!$herramienta) {
            return;
        }

        // Determinar el nuevo estado según el tipo de incidente
        switch ($tipoIncidente) {
            case 'En revisión':
                $nuevoEstado = 'En mantenimiento';
                break;
            case 'Dañada':
            case 'Perdida':
                $nuevoEstado = 'Fuera de servicio';
                break;
            default:
                return; // No cambiar el estado si no coincide
        }

        // Actualizar el estado de la herramienta
        $herramienta->update(['estadoHerramienta' => $nuevoEstado]);
    }

    /**
     * Actualizar el estado y disminuir la cantidad de la herramienta
     */
    private function actualizarEstadoYCantidadHerramienta($herramientaId, $tipoIncidente)
    {
        $herramienta = Herramienta::find($herramientaId);

        if (!$herramienta) {
            return ['type' => 'error', 'message' => 'Herramienta no encontrada'];
        }

        // Determinar el nuevo estado según el tipo de incidente
        switch ($tipoIncidente) {
            case 'En revisión':
                $nuevoEstado = 'En mantenimiento';
                break;
            case 'Dañada':
            case 'Perdida':
                $nuevoEstado = 'Fuera de servicio';
                break;
            default:
                return ['type' => 'success', 'message' => 'Incidencia registrada correctamente'];
        }

        // Disminuir la cantidad solo si es mayor a 0
        $cantidadAnterior = $herramienta->cantidad;
        $nuevaCantidad = max(0, $herramienta->cantidad - 1);

        // Actualizar el estado y la cantidad de la herramienta
        $herramienta->update([
            'estadoHerramienta' => $nuevoEstado,
            'cantidad' => $nuevaCantidad
        ]);

        // Verificar si la cantidad llegó a 0
        if ($nuevaCantidad == 0) {
            return [
                'type' => 'warning',
                'message' => 'Incidencia registrada correctamente. ⚠️ HERRAMIENTA AGOTADA - La herramienta "' . $herramienta->nombre . '" no tiene unidades disponibles.'
            ];
        }

        return [
            'type' => 'success',
            'message' => 'Incidencia registrada correctamente. Cantidad de herramienta actualizada: ' . $cantidadAnterior . ' → ' . $nuevaCantidad
        ];
    }
}
