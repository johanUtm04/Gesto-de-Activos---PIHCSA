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
    Route::get('/equipos', [EquipoController::class, 'index'])->name('activos.index');
    Route::get('/equipos/create', [EquipoController::class, 'create'])->name('activos.create');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('activos.store');
    Route::get('/equipos/{equipo}/edit', [EquipoController::class, 'edit'])->name('activos.edit');
    Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])->name('activos.update');
    Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('activos.destroy');

    //Wizard
    Route::post('/activos/store-step1', [EquipoController::class, 'storeStep1'])->name('activos.store.step1');
    Route::get('/activos/create/hardware/{equipo}', [EquipoController::class, 'createHardware'])
    ->name('activos.create.hardware');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
