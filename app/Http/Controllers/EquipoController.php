<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $activos = Equipo::all(); // Trae todos los activos
        return view('activos.index', compact('activos'));
    }

    public function create()
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('activos.create', compact('usuarios', 'ubicaciones'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
        ]);

        Equipo::create($request->all());

        return redirect()->route('activos.index')->with('success', 'Equipo creado correctamente');
    }

    public function edit(Equipo $act)
    {
        return view('activos.edit', compact('activo'));
    }

    public function update(Request $request, Equipo $activo)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
        ]);

        $activo->update($request->all());

        return redirect()->route('activos.index')->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy(Equipo $activo)
    {
        $activo->delete();
        return redirect()->route('activos.index')->with('success', 'Equipo eliminado correctamente');
    }
}
