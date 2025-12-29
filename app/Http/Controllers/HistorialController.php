<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial_log;
use App\Models\Equipo;
class HistorialController extends Controller
{
    public function index()
    {

        //eager loading
        $equipos = Equipo::with(['historials', 'historials.usuario'])->get();
        // Cargamos los equipos con sus historiales y los usuarios de esos historiales de un solo golpe
        // $equipos = Equipo::with(['historials.usuario'])->get();
        return view('historial.index', compact('equipos'));
    }
}
