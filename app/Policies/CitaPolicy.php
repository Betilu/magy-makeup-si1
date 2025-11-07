<?php

namespace App\Policies;

use App\Models\Cita;
use App\Models\User;

class CitaPolicy
{
    /**
     * Determine if the user can view any citas.
     */
    public function viewAny(User $user): bool
    {
        // Admin y recepcionista pueden ver todas las citas
        // Cliente solo puede ver sus propias citas
        return $user->hasAnyPermission(['ver citas', 'crear citas']) || 
               $user->hasRole('super-admin');
    }

    /**
     * Determine if the user can view the cita.
     */
    public function view(User $user, Cita $cita): bool
    {
        // Admin puede ver todas
        if ($user->hasRole('super-admin') || $user->hasPermissionTo('ver citas')) {
            return true;
        }
        
        // Cliente solo puede ver sus propias citas
        return $user->id === $cita->user_id;
    }

    /**
     * Determine if the user can create citas.
     */
    public function create(User $user): bool
    {
        // Admin y cliente pueden crear citas
        return $user->hasPermissionTo('crear citas') || 
               $user->hasRole('super-admin');
    }

    /**
     * Determine if the user can update the cita.
     */
    public function update(User $user, Cita $cita): bool
    {
        // Admin y recepcionista pueden editar citas
        return $user->hasRole('super-admin') || 
               $user->hasPermissionTo('editar citas');
    }

    /**
     * Determine if the user can delete the cita.
     */
    public function delete(User $user, Cita $cita): bool
    {
        // Solo admin puede eliminar citas
        return $user->hasRole('super-admin') || 
               $user->hasPermissionTo('eliminar citas');
    }
}
