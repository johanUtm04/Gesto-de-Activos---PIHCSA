<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use App\Services\AuditService;


class GestionUbicacionesController extends Controller
{


    public function index(Request $request)
    {
        $ubicaciones = Ubicacion::paginate(10);
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function create()
    {
        $ubicaciones = Ubicacion::all();
            return view('ubicaciones.create', compact('ubicaciones'));

    }


    public function store(Request $request, Ubicacion $ubicacion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);
        $ubicacion->create($request->all());

        return redirect()->route('ubicaciones.index')->with('succes', 'ubicacion agregada correctamente');
    }


    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit', compact('ubicacion'));
    }
    
    public function update(Request $request,Ubicacion $ubicacion)
    {

        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'codigo' => 'nullable|string|max:255',
        ]);

    $ubicacion->update($request->all());

        return redirect()->route('ubicaciones.index')->with('warning', 'Ubicacion editada correctamente');
    }


    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return redirect()->route('ubicaciones.index')->with('danger', 'Ubicacion Eliminada correctamente');
    }
}