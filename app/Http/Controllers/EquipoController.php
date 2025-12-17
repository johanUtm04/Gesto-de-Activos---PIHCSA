<?php
namespace App\Http\Controllers;

use App\Models\DiscoDuro;
use App\Models\Equipo;
use App\Models\Monitor;
use App\Models\Ubicacion;
use App\Models\discos_duros;
use App\Models\Historial_log;
use App\Models\Periferico;
use App\Models\Procesador;
use App\Models\Ram;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class EquipoController extends Controller
{
    //Function to explain the main table
    public function index()
    {
        $equipos = Equipo::paginate(5);
        return view('equipos.index', compact('equipos'))->with('info', 'Bienvenido');
    }

    //Function to explain the main table
    public function historial()
    {
        return view('equipos.historial');
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
        'serial' => 'nullable|string|max:255',
        'sistema_operativo' => 'required|string|max:35', 
        'usuario_id' => 'required|integer|exists:users,id',
        'ubicacion_id' => 'nullable|integer|exists:ubicaciones,id',
        'valor_inicial' => 'nullable|numeric|min:0|max:999999.99',
        'fecha_adquisicion' => 'required|date',
        'vida_util_estimada' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if (empty($request->serial)) {
            $data['serial'] = 'INT-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        }
        
        if (empty($request->marca_equipo)) {
            $data['marca_equipo'] = 'Sin marca asignada';
        }

        if (empty($request->valor_inicial)) {
            $data['valor_inicial'] = 0;
        }

        $equipo = Equipo::create($data);

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
            ''
            ]);

        $equipo->update($request->all());

//¿Vino algo llamado perifericos?
if ($request->has('perifericos')) {
    //Recorremos cada periferico enviado por el formulario $peripheralData es como una cajita 
        foreach ($request->input('perifericos') as $peripheralData) {
            
            // Si el periférico tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {

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
                    'equipo_id' => $equipo->id, 
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
                    if (empty($peripheralData['capacidad_gb']) && empty($peripheralData['clock_mhz']) && empty($periphereData['tipo_chz'])) {
                        $ram->delete(); 
                    } else {

                        //Caso contrario solo actualizamos el registro existente
                        $ram->update([
                            'capacidad_gb' => $peripheralData['capacidad_gb'],
                            'clock_mhz' => $peripheralData['clock_mhz'],
                            'tipo_chz' => $peripheralData['tipo_chz'],
                        ]);
                    }
                }
            } 
        }
    }


    //El formualario envio el arreglo de procesadores
if ($request->has('procesadores')) {
    //Recorremos cada ram enviado por el formulario $peripheralData es como una cajita 
        foreach ($request->input('procesadores') as $peripheralData) {
            
            // Si la ram tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {

                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $procesador = Procesador::find($peripheralData['id']);
                
            
                if ($procesador) {
                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['marca']) && empty($peripheralData['descripcion_tipo'])) {
                        $procesador->delete(); 
                    } else {

                        //Caso contrario solo actualizamos el registro existente
                        $procesador->update([
                            'descripcion_tipo' => $peripheralData['descripcion_tipo'],
                            'marca' => $peripheralData['marca'],
                        ]);
                    }
                }
            } 
        }
    }


//Si se envia el arreglo de monitores
if ($request->has('monitores')) {
    //recorremos ese arreglo
        foreach ($request->input('monitores') as $peripheralData) {
            
            // Si la ram tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {
                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $monitor = Monitor::find($peripheralData['id']);
                
            
                if ($monitor) {
                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['marca']) && empty($peripheralData['serial']) && empty($peripheralData['escala_pulgadas']) && empty($peripheralData['interface'])) {
                        $monitor->delete(); 
                    } else {

                        //Caso contrario solo actualizamos el registro existente
                        $monitor->update([
                            'marca' => $peripheralData['marca'],
                            'serial' => $peripheralData['serial'],
                            'escala_pulgadas' => $peripheralData['escala_pulgadas'],
                            'interface' => $peripheralData['interface'],
                        ]);
                    }
                }
            } 
        }
    }

    
//Si se envia el arreglo de monitores
if ($request->has('discoDuros')) {
    //recorremos ese arreglo
        foreach ($request->input('discoDuros') as $peripheralData) {
            
            // Si la ram tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {
                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $discoDuro = DiscoDuro::find($peripheralData['id']);
                
            
                if ($discoDuro) {
                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['capacidad']) && empty($peripheralData['tipo_hdd_ssd']) && empty($peripheralData['interface'])) {
                        $discoDuro->delete(); 
                    } else {

                        //Caso contrario solo actualizamos el registro existente
                        $discoDuro->update([
                            'capacidad' => $peripheralData['capacidad'],
                            'tipo_hdd_ssd' => $peripheralData['tipo_hdd_ssd'],
                            'interface' => $peripheralData['interface'],
                        ]);
                    }
                }
            } 
        }
    }

//Si se envia el arreglo de monitores
if ($request->has('discoDuros')) {
    //recorremos ese arreglo
        foreach ($request->input('discoDuros') as $peripheralData) {
            
            // Si la ram tiene un ID, es un registro existente, entramos aqui 
            if (isset($peripheralData['id'])) {
                //La guardamos en una variable
                //Buscamos en el modelo la que coincida con ese ID ejemplo 10
                //Lo trae de la DB 
                $discoDuro = DiscoDuro::find($peripheralData['id']);
                
            
                if ($discoDuro) {
                    //Si los espacios de la cajita ambos estan vacios 
                    //la mauqina interpreta que como estan vacios se borraron, los borramos
                    if (empty($peripheralData['capacidad']) && empty($peripheralData['tipo_hdd_ssd']) && empty($peripheralData['interface'])) {
                        $discoDuro->delete(); 
                    } else {

                        //Caso contrario solo actualizamos el registro existente
                        $discoDuro->update([
                            'capacidad' => $peripheralData['capacidad'],
                            'tipo_hdd_ssd' => $peripheralData['tipo_hdd_ssd'],
                            'interface' => $peripheralData['interface'],
                        ]);
                    }
                }
            } 
        }
    }

    return redirect()->route('equipos.index')->with('warning', 'Equipo actualizado correctamente');
}


    //function to delete some 'equipo'
    public function indexaddwork(Equipo $equipo)
    {
        return view('equipos.addwork',compact('equipo'));
    }


    //function to delete some 'equipo'
    public function addwork(Equipo $equipo, Request $request)
    {

    $data = $request->validate([
        'tipo_evento'  => 'required|string',
        'fecha_evento' => 'required|date',
        'contexto'     => 'required|string',
        'costo'        => 'nullable|numeric',
    ]);

    $payload = [
        'tipo_evento'  => $data['tipo_evento'],
        'fecha_evento' => $data['fecha_evento'],
        'contexto'     => $data['contexto'],
        'costo'        => $data['costo'],
    ];

    Historial_log::create([
        'activo_id'          => $equipo->id,
        'usuario_accion_id'  => auth()->id(),
        'tipo_registro'           => 'MANTENIMIENTO',
        'detalles_json'            => $payload,
    ]);
    $equipos = Equipo::all();
    return view('equipos.index', compact('equipos') );
    }



    //function to delete some 'equipo'
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('danger', 'Equipo Eliminado correctamente');
    }
}
