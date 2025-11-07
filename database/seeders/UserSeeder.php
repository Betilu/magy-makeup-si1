<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission::create(['name' => 'mostrar usuarios']);
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        // Permission::create(['name' => 'editar usuarios']);
        // Permission::create(['name' => 'eliminar usuarios']);
        // Permission::create(['name' => 'asignar']);

// ---------------------------------------------------------------
        // Permission::create(['name' => 'ver libros']);
        // Permission::create(['name' => 'crear libros']);
        // Permission::create(['name' => 'editar libros']);
        // Permission::create(['name' => 'eliminar libros']);

// ---------------------------------------------------------------
        // Permisos para citas
        Permission::create(['name' => 'ver citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'eliminar citas']);
       

        $adminUser = User::query()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'email_verified_at' => now()
        ]);

        $roleAdmin = Role::create(['name' => 'super-admin']);
        $adminUser->assignRole($roleAdmin);
        $permissionsAdmin = Permission::query()->pluck('name');
        $roleAdmin->syncPermissions($permissionsAdmin);
// ---------------------------------------------------------------
         $recepcionistaUser = User::query()->create([
            'name' => 'recepcionista',
            'email' => 'recepcionista@recepcionista.com',
            'password' => '12345',
            'email_verified_at' => now()
        ]);
        
        $roleRecepcionista = Role::create(['name' => 'recepcionista']);
        $recepcionistaUser->assignRole($roleRecepcionista);
        $roleRecepcionista->syncPermissions(['ver citas', 'editar citas']);
// ---------------------------------------------------------------

        $clienteUser = User::query()->create([
            'name' => 'cliente',
            'email' => 'cliente@cliente.com',
            'password' => '12345',
            'email_verified_at' => now()
        ]);

        $roleCliente = Role::create(['name' => 'cliente']);
        $clienteUser->assignRole($roleCliente);
        $roleCliente->syncPermissions(['ver citas', 'crear citas']);
        
        // ---------------------------------------------------------------

        $estilistaUser = User::query()->create([
            'name' => 'estilista',
            'email' => 'estilista@cliente.com',
            'password' => '12345',
            'email_verified_at' => now()
        ]);

        $roleEstilista = Role::create(['name' => 'estilista']);
        $estilistaUser->assignRole($roleEstilista);        
    }

    

    
}
