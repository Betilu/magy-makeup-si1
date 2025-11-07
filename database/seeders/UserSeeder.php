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
        
        // ---------------------------------------------------------------
        // Crear más usuarios clientes para el seeder
        $clientes = [
            ['name' => 'María García', 'email' => 'maria.garcia@gmail.com', 'password' => '12345'],
            ['name' => 'Ana López', 'email' => 'ana.lopez@gmail.com', 'password' => '12345'],
            ['name' => 'Carmen Martínez', 'email' => 'carmen.martinez@gmail.com', 'password' => '12345'],
            ['name' => 'Laura Rodríguez', 'email' => 'laura.rodriguez@gmail.com', 'password' => '12345'],
            ['name' => 'Sofía Hernández', 'email' => 'sofia.hernandez@gmail.com', 'password' => '12345'],
            ['name' => 'Isabella Torres', 'email' => 'isabella.torres@gmail.com', 'password' => '12345'],
        ];

        foreach ($clientes as $clienteData) {
            $user = User::create([
                'name' => $clienteData['name'],
                'email' => $clienteData['email'],
                'password' => $clienteData['password'],
                'email_verified_at' => now()
            ]);
            $user->assignRole($roleCliente);
        }

        // Crear más usuarios estilistas para el seeder
        $estilistas = [
            ['name' => 'Valentina Ruiz', 'email' => 'valentina.ruiz@magy.com', 'password' => '12345'],
            ['name' => 'Camila Díaz', 'email' => 'camila.diaz@magy.com', 'password' => '12345'],
            ['name' => 'Gabriela Morales', 'email' => 'gabriela.morales@magy.com', 'password' => '12345'],
            ['name' => 'Daniela Castro', 'email' => 'daniela.castro@magy.com', 'password' => '12345'],
            ['name' => 'Natalia Ramos', 'email' => 'natalia.ramos@magy.com', 'password' => '12345'],
            ['name' => 'Fernanda Silva', 'email' => 'fernanda.silva@magy.com', 'password' => '12345'],
        ];

        foreach ($estilistas as $estilistaData) {
            $user = User::create([
                'name' => $estilistaData['name'],
                'email' => $estilistaData['email'],
                'password' => $estilistaData['password'],
                'email_verified_at' => now()
            ]);
            $user->assignRole($roleEstilista);
        }
    }
}
