<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial_log;
class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $query = Historial_log::with('equipo')->orderBy('created_at', 'desc');

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $query->where('serial_equipo', 'like', '%' . $request->search . '%')
                  ->orWhere('equipo_nombre', 'like', '%' . $request->search . '%');
        }

        // Filtro por tipo de evento
        if ($request->filled('evento')) {
            $query->where('modulo', $request->evento);
        }

        // Agrupamos por fecha para el diseño del Timeline
        $historiales = $query->get()->groupBy(function($data) {
            return $data->created_at->format('Y-m-d');
        });

        return view('historial.index', compact('historiales'));
    }
}
