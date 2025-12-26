<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use App\Services\AuditService;


class GestionUbicacionesController extends Controller
{


public function index(Request $request)
{
    $ubicaciones = Ubicacion::paginate(3);
    return view('ubicaciones.index', compact('ubicaciones'));
}

public function create()
{
    $ubicaciones = Ubicacion::all();
        return view('ubicaciones.create', compact('ubicaciones'));

}


public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'codigo' => 'required|string|max:255',
    ]);
    $ubicacion=Ubicacion::create($request->all());

    //1.-Cuantos usuarios mostramos por pagina ??
    $perPage = 3;


    //2.-Cuants hay por detras?
    $position = Ubicacion::where('id', '<=', $ubicacion->id)->count();

    //3.-Descubrir en que pagina va?
    $page = ceil($position/$perPage);

    return redirect()->route('ubicaciones.index', ['page' => $page])
    ->with('success', 'Ubicacion agregada correctamente')
    ->with('new_id', $ubicacion->id);
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


        //1.-Cuantos usuarios mostramos por pagina ??
        $perPage = 3;


        //2.-Cuants hay por detras?
        $position = Ubicacion::where('id', '<=', $ubicacion->id)->count();

        //3.-Descubrir en que pagina va?
        $page = ceil($position/$perPage);

    return redirect()->route('ubicaciones.index', ['page' => $page])
    ->with('warning', 'Ubicacion editada correctamente')
    ->with('actualizado->id', $ubicacion->id);
}


public function destroy(Ubicacion $ubicacion)
{
    $ubicacion->delete();
    $perPage = 3;

        //cuantos hay detras ??
        $position = Ubicacion::where('id', '<=', $ubicacion->id)->count();

        $page = ceil($position/$perPage);
    return redirect()->route('ubicaciones.index' , ['page' => $page])
    ->with('danger', 'Ubicacion Eliminada correctamente');
}
}