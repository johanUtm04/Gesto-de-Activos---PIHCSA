<?php

//Controladores
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EquipoWizardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepreciacionController;
use App\Http\Controllers\GestionUsuariosController;
use App\Http\Controllers\GestionUbicacionesController;
use App\Http\Controllers\HistorialController;



//Ruta Principal al entrar
Route::get('/', function () {
return view('auth.login');});

//Crud Completo -ACCECIBLE UNA VEZ SE LOGEA-- Estamos haiendo uso de laravel/breeze
Route::middleware(['auth'])->group(function () {

    //CRUD DE EQUIPOS -COMPLETO- 
    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');

    //CREACION DE ACTIVO BASE -COMPLETO-
    Route::get('/equipos/wizard/create', [EquipoWizardController::class, 'create'])->name('equipos.wizard.create');
    //VALIDAR ACTIVO BASE Y SEGUIR CON EL WIZARD -COMPLETO-
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
    

    Route::get('/equipos/{uuid}/ubicacion', [EquipoWizardController::class, 'ubicacionForm'])->name('equipos.wizard-ubicacion');
    //store
    Route::post('/equipos/{uuid}/ubicacion', [EquipoWizardController::class, 'saveUbicacion'])->name('equipos.wizard.saveUbicacion');

    Route::get('/equipos/{uuid}/monitores', [EquipoWizardController::class, 'monitoresForm'])->name('equipos.wizard-monitores');
    Route::post('/equipos/{uuid}/monitores', [EquipoWizardController::class, 'saveMonitor'])->name('equipos.wizard.saveMonitor');

    Route::get('/equipos/{uuid}/discoduro', [EquipoWizardController::class, 'discoduroForm'])->name('equipos.wizard-discos_duros');
    Route::post('/equipos/{uuid}/discoduro', [EquipoWizardController::class, 'saveDiscoduro'])->name('equipos.wizard.saveDiscoduro');

    Route::get('/equipos/{uuid}/ram', [EquipoWizardController::class, 'ramForm'])->name('equipos.wizard-ram');
    Route::post('/equipos/{uuid}/ram', [EquipoWizardController::class, 'saveRam'])->name('equipos.wizard.saveRam');


    Route::get('/equipos/{uuid}/periferico', [EquipoWizardController::class, 'perifericoForm'])->name('equipos.wizard-periferico');
    Route::post('/equipos/{uuid}/periferico', [EquipoWizardController::class, 'savePeriferico'])->name('equipos.wizard.savePeriferico');

    Route::get('/equipos/{uuid}/procesador', [EquipoWizardController::class, 'procesadorForm'])->name('equipos.wizard-procesador');
    Route::post('/equipos/{uuid}/procesador', [EquipoWizardController::class, 'saveProcesador'])->name('equipos.wizard.saveProcesador');


    
    //Edicion de un ACTIVO(COMPLETO)
    Route::get('/equipos/{equipo}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');

    //AGREGAR MANTENIMIENTO A UN ACTIVO
    Route::get('/equipos/{equipo}/addwork', [EquipoController::class, 'indexaddwork'])->name('equipos.addwork.index');
    Route::post('/equipos/{equipo}/addwork', [EquipoController::class, 'addwork'])->name('equipos.addwork.store');

    //MOSTRAR DETALLES COMPLETOD DE UN ACTIVO
    Route::get('/equipos/{uuid}/detalles', [EquipoController::class, 'show'])->name('equipos.show');


    //CONFIGURACION ESCENCIAL DE UN PERFIL DESDE EL LADO DE ADMINISTARDOR
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Depreciacon de una Activo
    Route::get('/depreciacion', [DepreciacionController::class, 'index'])->name('depreciacion.index');
    Route::get('/depreciacion/reporte/pdf', [DepreciacionController::class, 'exportPdf'])->name('depreciacion.pdf');
    Route::get('/depreciacion/{equipo}', [DepreciacionController::class, 'show'])->name('depreciacion.show');

    //Gestion de Usuarios
    Route::get('/gestionUsuarios', [GestionUsuariosController::class, 'index'])->name('users.index');
    Route::get('/gestionUsuarios/create', [GestionUsuariosController::class, 'create'])->name('users.create');
    Route::post('/gestionUsuarios', [GestionUsuariosController::class, 'store'])->name('users.store');

    Route::get('/gestionUsuarios/{user}/edit', [GestionUsuariosController::class, 'edit'])->name('users.edit');
    Route::delete('/gestionUsuarios/{user}', [GestionUsuariosController::class, 'destroy'])->name('users.destroy');
    Route::put('/gestionUsuarios/{user}', [GestionUsuariosController::class, 'update'])->name('users.update');


    //Gestion de Ubicaciones 
    Route::get('/gestionUbicaciones', [GestionUbicacionesController::class, 'index'])->name('ubicaciones.index');
    Route::get('/gestionUbicaciones/create', [GestionUbicacionesController::class, 'create'])->name('ubicaciones.create');
    Route::post('/gestionUbicaciones', [GestionUbicacionesController::class, 'store'])->name('ubicaciones.store');
    
    Route::get('/gestionUbicaciones/{ubicacion}/edit', [GestionUbicacionesController::class, 'edit'])->name('ubicaciones.edit');
    Route::delete('/gestionUbicaciones/{ubicacion}', [GestionUbicacionesController::class, 'destroy'])->name('ubicaciones.destroy');
    Route::put('/gestionUbicaciones/{ubicacion}', [GestionUbicacionesController::class, 'update'])->name('ubicaciones.update');


    //Historial
    Route::get('/historial/', [HistorialController::class, 'index'])->name('historial.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';



//Vista de pueba para middleware

Route::get('/mayorDeEdad', function () {
return "Unico correo autorizado Correcto";
})->middleware('age');

Route::get('no-autorizado', function () {
return "Mentira ese correo ni esta";
});

