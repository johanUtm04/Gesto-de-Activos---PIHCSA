<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
