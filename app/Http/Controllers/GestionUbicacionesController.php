<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class GestionUbicacionesController extends Controller
{


    public function index(Request $request)
    {
        $ubicaciones = Ubicacion::paginate(10);
        return view('ubicaciones.index', compact('ubicaciones'));
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