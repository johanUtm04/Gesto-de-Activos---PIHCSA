<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EquipoWizardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepreciacionController;
use App\Http\Controllers\PapeleraController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\GestionUbicacionesController;
use App\Http\Controllers\HistorialController;

/*
|--------------------------------------------------------------------------
| Ruta principal (Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas (Usuario autenticado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Perfil de usuario
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Módulo: Gestión de Equipos (Core)
    |--------------------------------------------------------------------------
    */
    Route::prefix('equipos')->group(function () {

        // Inventario y auditoría
        Route::get('/', [EquipoController::class, 'index'])->name('equipos.index');
        Route::get('/historial', [EquipoController::class, 'historial'])->name('equipos.historial');

        // Creación (Wizard)
        Route::get('/wizard/create', [EquipoWizardController::class, 'create'])->name('equipos.wizard.create');

        // CRUD
        Route::post('/', [EquipoController::class, 'store'])->name('equipos.store');
        Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
        Route::put('/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
        Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');

        // Mantenimiento
        Route::get('/{equipo}/addwork', [EquipoController::class, 'indexaddwork'])->name('equipos.addwork.index');
        Route::post('/{equipo}/addwork', [EquipoController::class, 'addwork'])->name('equipos.addwork.store');

        /*
        |--------------------------------------------------------------------------
        | Wizard por componentes
        |--------------------------------------------------------------------------
        */
        Route::prefix('{uuid}')->group(function () {

            Route::get('/wizard', [EquipoWizardController::class, 'show'])->name('equipos.wizard');

            // Ubicación
            Route::get('/ubicacion', [EquipoWizardController::class, 'ubicacionForm'])->name('equipos.wizard.ubicacion');
            Route::post('/ubicacion', [EquipoWizardController::class, 'saveUbicacion'])->name('equipos.wizard.saveUbicacion');

            // Monitores
            Route::get('/monitores', [EquipoWizardController::class, 'monitoresForm'])->name('equipos.wizard.monitores');
            Route::post('/monitores', [EquipoWizardController::class, 'saveMonitor'])->name('equipos.wizard.saveMonitor');

            // Discos duros
            Route::get('/discoduro', [EquipoWizardController::class, 'discoduroForm'])->name('equipos.wizard.discoduro');
            Route::post('/discoduro', [EquipoWizardController::class, 'saveDiscoduro'])->name('equipos.wizard.saveDiscoduro');

            // RAM
            Route::get('/ram', [EquipoWizardController::class, 'ramForm'])->name('equipos.wizard.ram');
            Route::post('/ram', [EquipoWizardController::class, 'saveRam'])->name('equipos.wizard.saveRam');

            // Periféricos
            Route::get('/periferico', [EquipoWizardController::class, 'perifericoForm'])->name('equipos.wizard.periferico');
            Route::post('/periferico', [EquipoWizardController::class, 'savePeriferico'])->name('equipos.wizard.savePeriferico');

            // Procesador
            Route::get('/procesador', [EquipoWizardController::class, 'procesadorForm'])->name('equipos.wizard.procesador');
            Route::post('/procesador', [EquipoWizardController::class, 'saveProcesador'])->name('equipos.wizard.saveProcesador');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Módulo: Depreciación
    |--------------------------------------------------------------------------
    */
    Route::prefix('depreciacion')->group(function () {
        Route::get('/', [DepreciacionController::class, 'index'])->name('depreciacion.index');
        Route::get('/reporte/pdf', [DepreciacionController::class, 'exportPdf'])->name('depreciacion.pdf');
        Route::get('/{equipo}', [DepreciacionController::class, 'show'])->name('depreciacion.show');
    });

    /*
    |--------------------------------------------------------------------------
    | Papelera
    |--------------------------------------------------------------------------
    */
    Route::get('/papelera', [PapeleraController::class, 'index'])->name('papelera.index');

    /*
    |--------------------------------------------------------------------------
    | Gestión de Usuarios
    |--------------------------------------------------------------------------
    */
    Route::prefix('gestionUsuarios')->group(function () {
        Route::get('/', [GestionUsuariosController::class, 'index'])->name('users.index');
        Route::get('/create', [GestionUsuariosController::class, 'create'])->name('users.create');
        Route::post('/', [GestionUsuariosController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [GestionUsuariosController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [GestionUsuariosController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [GestionUsuariosController::class, 'destroy'])->name('users.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestión de Ubicaciones
    |--------------------------------------------------------------------------
    */
    Route::prefix('gestionUbicaciones')->group(function () {
        Route::get('/', [GestionUbicacionesController::class, 'index'])->name('ubicaciones.index');
        Route::get('/create', [GestionUbicacionesController::class, 'create'])->name('ubicaciones.create');
        Route::post('/', [GestionUbicacionesController::class, 'store'])->name('ubicaciones.store');
        Route::get('/{ubicacion}/edit', [GestionUbicacionesController::class, 'edit'])->name('ubicaciones.edit');
        Route::put('/{ubicacion}', [GestionUbicacionesController::class, 'update'])->name('ubicaciones.update');
        Route::delete('/{ubicacion}', [GestionUbicacionesController::class, 'destroy'])->name('ubicaciones.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Historial global
    |--------------------------------------------------------------------------
    */
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rutas de prueba (middlewares)
|--------------------------------------------------------------------------
*/
Route::get('/mayorDeEdad', function () {
    return "Unico correo autorizado Correcto";
})->middleware('age');

Route::get('/no-autorizado', function () {
    return "Mentira ese correo ni esta";
});
