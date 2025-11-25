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
        $equipos = Equipo::all(); 
        return view('equipos.index', compact('equipos'));
    }

    //Funcion para crear un componente de la tabla
    public function create()
    {
        //Usamos el modelo usuario
        $usuarios = User::all();
        //Usamos el modelo ubicacion
        $ubicaciones = Ubicacion::all();
        return view('equipos.create', compact('usuarios', 'ubicaciones'));
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
        return redirect()->route('equipos.wizard', $equipo->id);
    }


    //Funcion para 
    public function edit(Equipo $equipo,)    //Inyecciones como parametro
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => '',
            'descripcion' => 'nullable',
        ]);

        $equipo->update($request->all());

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado correctamente');
    }
}
