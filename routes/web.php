<?php

//Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;

//Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// CRUD completo para equipos
Route::middleware(['auth'])->group(function () {
    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('/equipos/create', [EquipoController::class, 'create'])->name('equipos.create');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
    Route::get('/equipos/{equipo}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');

    //Wizard
    Route::post('/equipos/store-step1', [EquipoController::class, 'storeStep1'])->name('equipos.store.step1');
    Route::get('/equipos/create/hardware/{equipo}', [EquipoController::class, 'createHardware'])
    ->name('equipos.create.hardware');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
