<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todos los clientes con sus usuarios
        $clients = Client::with('user')->latest()->paginate(15);

        if ($request->wantsJson()) {
            return response()->json($clients);
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Provide direccion, frecuencia, observacion to create a client.'], 200);
        }

        return view('clients.create');
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
            'direccion' => 'required|string|max:255',
            'frecuencia' => 'required|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Asignar rol de cliente
            $clientRole = Role::where('name', 'cliente')->first();
            if ($clientRole) {
                $user->assignRole($clientRole);
            }

            // Crear cliente
            $client = new Client();
            $client->user_id = $user->id;
            $client->direccion = $data['direccion'];
            $client->frecuencia = $data['frecuencia'];
            $client->observacion = $data['observacion'] ?? null;
            $client->save();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Creación de cliente',
                'description' => 'Cliente creado: ' . $user->name . ' (' . $user->email . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json($client->load('user'), 201);
            }

            return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al crear cliente: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client, Request $request)
    {
        $client->load('user');

        if ($request->wantsJson()) {
            return response()->json($client);
        }

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, Request $request)
    {
        $client->load('user');

        if ($request->wantsJson()) {
            return response()->json($client);
        }

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $client->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'direccion' => 'required|string|max:255',
            'frecuencia' => 'required|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar usuario
            $user = $client->user;
            $updateUserData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $updateUserData['password'] = Hash::make($data['password']);
            }

            $user->update($updateUserData);

            // Actualizar cliente
            $client->direccion = $data['direccion'];
            $client->frecuencia = $data['frecuencia'];
            $client->observacion = $data['observacion'] ?? null;
            $client->save();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Actualización de cliente',
                'description' => 'Cliente actualizado: ' . $user->name . ' (' . $user->email . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json($client->load('user'));
            }

            return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al actualizar cliente: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client, Request $request)
    {
        $userName = $client->user->name;
        $userEmail = $client->user->email;
        $userId = $client->user_id;

        DB::beginTransaction();
        try {
            // Eliminar cliente
            $client->delete();

            // Eliminar usuario asociado
            User::find($userId)->delete();

            // Registrar en bitácora
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Eliminación de cliente',
                'description' => 'Cliente eliminado: ' . $userName . ' (' . $userEmail . ')',
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('user-agent') ?? 'No disponible',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Cliente eliminado correctamente.']);
            }

            return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error al eliminar cliente'], 500);
            }

            return back()->with('error', 'Error al eliminar el cliente.');
        }
    }
}
