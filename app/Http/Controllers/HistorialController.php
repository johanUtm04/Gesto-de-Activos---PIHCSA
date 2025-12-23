<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial_log;
class HistorialController extends Controller
{
        public function index()
    {
        // Traemos todos los logs, ordenados por fecha descendente
        $logs = Historial_log::with('usuario')->orderBy('created_at', 'desc')->get();

        // Retornamos la vista pasándole la variable $logs
        return view('historial.index', compact('logs'));
    }
}
