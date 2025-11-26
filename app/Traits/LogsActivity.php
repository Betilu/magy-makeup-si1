<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Registrar una actividad en la bitácora
     *
     * @param string $action Acción realizada (crear, editar, eliminar, etc.)
     * @param string $description Descripción detallada de la acción
     * @return void
     */
    protected function logActivity(string $action, string $description): void
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
                'ip_address' => Request::ip(),
                'browser' => Request::header('User-Agent') ?? 'Unknown'
            ]);
        } catch (\Exception $e) {
            // Si falla el registro, no interrumpir la operación principal
            \Log::error('Error al registrar actividad en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Obtener el nombre del usuario actual
     *
     * @return string
     */
    protected function getCurrentUserName(): string
    {
        return Auth::user() ? Auth::user()->name : 'Sistema';
    }

    /**
     * Obtener el rol principal del usuario actual
     *
     * @return string
     */
    protected function getCurrentUserRole(): string
    {
        if (!Auth::user()) {
            return 'Invitado';
        }

        $roles = Auth::user()->getRoleNames();
        return $roles->first() ?? 'Sin rol';
    }
}
