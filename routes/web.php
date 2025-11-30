<?php

//Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EquipoWizardController;
use App\Http\Controllers\ProfileController;

//Main Route
Route::get('/', function () {
    return view('welcome');
});

//Full crud to 'equipos'
Route::middleware(['auth'])->group(function () {
    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('/equipos/create', [EquipoController::class, 'create'])->name('equipos.create');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
    Route::get('/equipos/{equipo}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Wizard
    Route::get('/equipos/{equipo}/wizard', [EquipoWizardController::class, 'show'])->name('equipos.wizard');

    Route::get('/equipos/{equipo}/ubicacion', [EquipoWizardController::class, 'ubicacionForm'])->name('equipos.wizard-ubicacion');
    Route::post('/equipos/{equipo}/ubicacion', [EquipoWizardController::class, 'saveUbicacion'])->name('equipos.wizard.saveUbicacion');
    
    Route::get('/equipos/{equipo}/monitores', [EquipoWizardController::class, 'monitoresForm'])->name('equipos.wizard-monitores');
    Route::post('/equipos/{equipo}/monitores', [EquipoWizardController::class, 'saveMonitor'])->name('equipos.wizard.saveMonitor');



    // Route::get('/equipos/{equipo}/discoduro', [EquipoWizardController::class, 'discoduroForm'])->name('equipos.wizard.discoduro');
    // Route::post('/equipos/{equipo}/discoduro', [EquipoWizardController::class, 'saveDiscoduro'])->name('equipos.wizard.saveDiscoduro');

    // Route::get('/equipos/{equipo}/ram', [EquipoWizardController::class, 'ramForm'])->name('equipos.wizard.ram');
    // Route::post('/equipos/{equipo}/ram', [EquipoWizardController::class, 'saveRam'])->name('equipos.wizard.saveRam');


    // Route::get('/equipos/{equipo}/periferico', [EquipoWizardController::class, 'perifericoForm'])->name('equipos.wizard.ubicacion');
    // Route::post('/equipos/{equipo}/periferico', [EquipoWizardController::class, 'savePeriferico'])->name('equipos.wizard.savePeriferico');

    // Route::get('/equipos/{equipo}/precesador', [EquipoWizardController::class, 'procesadorForm'])->name('equipos.wizard.procesador');
    // Route::post('/equipos/{equipo}/procesador', [EquipoWizardController::class, 'savePreocesador'])->name('equipos.wizard.savePreocesador');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
