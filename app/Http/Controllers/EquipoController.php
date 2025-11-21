<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    //Funcion para mostrar tabla
    public function index()
    {
        //Tomamos el modelo de la tabla y lo pasamos a la vista
        $activos = Equipo::all(); 
        return view('activos.index', compact('activos'));
    }

    //Funcion para crear un componente de la tabla
    public function create()
    {
        //Usamos el modelo usuario
        $usuarios = User::all();
        //Usamos el modelo ubicacion
        $ubicaciones = Ubicacion::all();
        return view('activos.create', compact('usuarios', 'ubicaciones'));
    }

    //Funcion para guardar un registro en la base de datos
    public function store(Request $request)
    {
        // Crear el equipo con los datos enviados del formulario
        $equipo = Equipo::create([
            'marca_equipo' => $request->marca_equipo,
            'tipo_equipo' => $request->tipo_equipo,
            'serial' => $request->serial,
            'sistema_operativo' => $request->sistema_operativo,
            'usuario_id' => $request->usuario_id,
            'ubicacion_id' => $request->ubicacion_id,
            'valor_inicial' => $request->valor_inicial,
            'fecha_adquisicion' => $request->fecha_adquisicion,
            'vida_util_estimada' => $request->vida_util_estimada,
        ]);
        //Una ves se crea el registro de un nuevo equipo, vamos al segundo formulario, enviando el id del equipo recien creado
        //Para trabajar sobre el
        return redirect()->route('activos.create', $equipo->id);
    }


    //Funcion para 
    public function edit(Equipo $activo)
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
