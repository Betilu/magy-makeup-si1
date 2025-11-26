<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EstilistaController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\NotificacionController;
// Route::get('/', function () {

//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    // Rutas de usuarios
    Route::resource('users', UserController::class);

    // Rutas específicas para usuarios
    Route::get('users/{user}/roles-permissions', [UserController::class, 'editRoles'])
        ->name('users.roles.edit');
    Route::put('users/{user}/roles-permissions', [UserController::class, 'updateRoles'])
        ->name('users.roles.update');
    Route::get('users/{user}/roles/data', [UserController::class, 'getRolesData'])
        ->name('users.roles.data');
    Route::get('bitacora', [UserController::class, 'bitacora'])->name('bitacora.index');

    // Rutas de roles
    Route::resource('roles', RoleController::class);

    // Rutas de permisos
    Route::resource('permissions', PermissionController::class);


    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Rutas de clientes
    Route::resource('clients', ClientController::class);

    // Rutas de herramientas
    Route::resource('herramientas', HerramientaController::class);

    // Rutas de horarios
    Route::resource('horarios', HorarioController::class);

    // Rutas de citas
    Route::resource('citas', CitaController::class);
    Route::get('citas/servicios-estilista/{estilistaId}', [CitaController::class, 'getServiciosPorEstilista'])
        ->name('citas.servicios-estilista');

     // Rutas de estilistas
    Route::resource('estilistas', EstilistaController::class);

     // Rutas de notificaciones
    Route::resource('notificacions', NotificacionController::class);

    // Rutas de productos
    Route::resource('productos', \App\Http\Controllers\ProductoController::class);

    // Rutas de promociones
    Route::resource('promocions', \App\Http\Controllers\PromocionController::class);

    // Rutas de servicios
    Route::resource('servicios', \App\Http\Controllers\ServicioController::class);

    // Rutas de asignación producto-servicio
    Route::resource('servicio_productos', \App\Http\Controllers\ServicioProductoController::class);

    // Rutas de asignación promocion-servicio
    Route::resource('promocion_servicios', \App\Http\Controllers\PromocionServicioController::class);

    // Rutas de asignación herramienta-estilista
    Route::resource('asignacion_herramientas', \App\Http\Controllers\AsignacionHerramientaController::class);

    Route::resource('books', BookController::class)->only('index');
});
