<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estilista;
use App\Models\User;
use App\Models\Horario;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class EstilistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todos los estilistas con sus usuarios y horarios
        $estilistas = Estilista::with('user', 'horario')->latest()->paginate(15);

        if ($request->wantsJson()) {
            return response()->json($estilistas);
        }

        return view('estilistas.index', compact('estilistas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $horarios = Horario::all();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Provide data to create an estilista.', 'horarios' => $horarios], 200);
        }

        return view('estilistas.create', compact('horarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'horario_id' => 'required|exists:horarios,id',
            'calificacion' => 'required|integer|min:0|max:5',
            'comision' => 'required|numeric|min:0',
            'disponibilidad' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Asignar rol de estilista
            $estilistaRole = Role::where('name', 'estilista')->first();
            if ($estilistaRole) {
                $user->assignRole($estilistaRole);
            }

            // Crear estilista
            $estilista = new Estilista();
            $estilista->user_id = $user->id;
            $estilista->horario_id = $data['horario_id'];
            $estilista->calificacion = $data['calificacion'];
            $estilista->comision = $data['comision'];
            $estilista->disponibilidad = $data['disponibilidad'];
            $estilista->especialidad = $data['especialidad'];
            $estilista->save();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Creación de estilista',
                'description' => 'Estilista creado: ' . $user->name . ' (' . $user->email . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json($estilista->load('user'), 201);
            }

            return redirect()->route('estilistas.index')->with('success', 'Estilista creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al crear estilista: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Error al crear el estilista: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Estilista $estilista, Request $request)
    {
        $estilista->load('user', 'horario');

        if ($request->wantsJson()) {
            return response()->json($estilista);
        }

        return view('estilistas.show', compact('estilista'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estilista $estilista, Request $request)
    {
        $estilista->load('user', 'horario');
        $horarios = Horario::all();

        if ($request->wantsJson()) {
            return response()->json(['estilista' => $estilista, 'horarios' => $horarios]);
        }

        return view('estilistas.edit', compact('estilista', 'horarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estilista $estilista)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $estilista->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'horario_id' => 'required|exists:horarios,id',
            'calificacion' => 'required|integer|min:0|max:5',
            'comision' => 'required|numeric|min:0',
            'disponibilidad' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar usuario
            $user = $estilista->user;
            $updateUserData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $updateUserData['password'] = Hash::make($data['password']);
            }

            $user->update($updateUserData);

            // Actualizar estilista
            $estilista->horario_id = $data['horario_id'];
            $estilista->calificacion = $data['calificacion'];
            $estilista->comision = $data['comision'];
            $estilista->disponibilidad = $data['disponibilidad'];
            $estilista->especialidad = $data['especialidad'];
            $estilista->save();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Actualización de estilista',
                'description' => 'Estilista actualizado: ' . $user->name . ' (' . $user->email . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json($estilista->load('user'));
            }

            return redirect()->route('estilistas.index')->with('success', 'Estilista actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al actualizar estilista: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Error al actualizar el estilista: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estilista $estilista, Request $request)
    {
        $userName = $estilista->user->name;
        $userEmail = $estilista->user->email;
        $userId = $estilista->user_id;

        DB::beginTransaction();
        try {
            // Eliminar estilista
            $estilista->delete();

            // Eliminar usuario asociado
            User::find($userId)->delete();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Eliminación de estilista',
                'description' => 'Estilista eliminado: ' . $userName . ' (' . $userEmail . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Estilista eliminado correctamente.']);
            }

            return redirect()->route('estilistas.index')->with('success', 'Estilista eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al eliminar estilista'], 500);
            }

            return back()->with('error', 'Error al eliminar el estilista.');
        }
    }
}
