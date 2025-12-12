<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Monitor;
use App\Models\Ubicacion;
use App\Models\discos_duros;
use App\Models\Periferico;
use App\Models\Ram;
use App\Models\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    //Function to explain the main table
    public function index()
    {
        $equipos = Equipo::all(); 
        return view('equipos.index', compact('equipos'));
    }

    //function to create a new 'equipo'
    public function create()
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.create', compact('usuarios', 'ubicaciones'));
    }

    //function to send the data from index's form
    public function store(Request $request)
    {
        $request->validate([
            'marca_equipo' => 'nullable|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'sistema_operativo' => 'required|string|max:11', 
            'usuario_id' => 'required|integer|exists:users,id',
            'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            'valor_inicial' => 'required|numeric|min:0|max:999999.99',
            'fecha_adquisicion' => 'required|date',
            'vida_util_estimada' => 'required|string|max:255',
            ]);

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

        return redirect()->route('equipos.wizard-ubicacion', $equipo->id);
    }


    //function to edit a 'equipo'
    public function edit(Equipo $equipo)
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

    //function to send the changes data from edit's form
    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'marca_equipo' => 'nullable|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'sistema_operativo' => 'required|string|max:11', 
            'usuario_id' => 'required|integer|exists:users,id',
            'ubicacion_id' => 'required|integer|exists:ubicaciones,id',
            'valor_inicial' => 'required|numeric|min:0|max:999999.99',
            'fecha_adquisicion' => 'required|date',
            'vida_util_estimada' => 'required|string|max:255',

            ]);

        $equipo->update($request->all());

//El formualario envio el arreglo de perifericos
if ($request->has('perifericos')) {
    //Recorremos cada periferico enviado por el formulario $peripheralData es como una cajita 
        foreach ($request->input('perifericos') as $peripheralData) {
            
            // Si el periférico tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {

                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $periferico = Periferico::find($peripheralData['id']);
                
            
                if ($periferico) {


                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['tipo']) && empty($peripheralData['serial'])) {
                        $periferico->delete(); 
                    } else {    //Si no estan vacion lo aignamos o bien solo lo actualizamod

                        //Caso contrario solo actualizamos el registro existente
                        $periferico->update([
                            'tipo' => $peripheralData['tipo'],
                            'serial' => $peripheralData['serial'],

                        ]);
                    }
                }
            } 

            // Si NO tiene ID y al menos un campo está lleno, es un nuevo periférico
            elseif (!empty($peripheralData['tipo']) || !empty($peripheralData['serial'])) {
                $equipo->perifericos()->create([
                    'tipo' => $peripheralData['tipo'],
                    'serial' => $peripheralData['serial'],
                    'equipo_id' => $equipo->id, // Aunque la relación lo hace automático, es bueno ser explícito.
                ]);
            }
        }
    }


//El formualario envio el arreglo de rams
if ($request->has('rams')) {
    //Recorremos cada ram enviado por el formulario $peripheralData es como una cajita 
        foreach ($request->input('rams') as $peripheralData) {
            
            // Si la ram tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {

                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $ram = Ram::find($peripheralData['id']);
                
            
                if ($ram) {


                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['capacidad_gb'])) {
                        $ram->delete(); 
                    } else {    //Si no estan vacion lo aignamos o bien solo lo actualizamod

                        //Caso contrario solo actualizamos el registro existente
                        $ram->update([
                            'capacidad_gb' => $peripheralData['capacidad_gb'],
                        ]);
                    }
                }
            } 
        }
    }




        return redirect()->route('equipos.index')->with('primary', 'Equipo actualizado correctamente');
    }

    //function to delete some 'equipo'
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('danger', 'Equipo eliminado correctamente');
    }
}
