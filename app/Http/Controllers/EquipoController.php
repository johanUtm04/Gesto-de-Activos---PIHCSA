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
use Illuminate\Support\Str;


class EquipoController extends Controller
{
    //Function to explain the main table
    public function index()
    {
        session()->forget('wizard_equipo');
        $equipos = Equipo::paginate(10);
        return view('equipos.index', compact('equipos'));
    }

    //Function to explain the main table
    public function historial()
    {
        return view('equipos.historial');
    }

    //function to create a new 'equipo'
    public function create()
    {
        session()->forget('wizard_equipo');
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipo.wizard.create', compact('usuarios', 'ubicaciones'));
    }

//Funcion para Actualizar registros en la base de datos
public function store(Request $request)
{
    //Validamos cada Uno de ellos de la respuesta que nos de el Usuario
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

        //Lo guardamos en la variable $data
        $data = $request->all();

        //Condicionales en caso de que el usuario no mande esos campos
        if (empty($request->serial)) {
            $data['serial'] = 'INT-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        }
        
        if (empty($request->marca_equipo)) {
            $data['marca_equipo'] = 'Sin marca asignada';
        }

        if (empty($request->valor_inicial)) {
            $data['valor_inicial'] = 0;
        }

        $uuid = Str::uuid()->toString();

        session()->put('wizard_equipo.uuid', $uuid);

        //Data ya baja solito xd
        session()->put('wizard_equipo.equipo', $data);

        return redirect()->route('equipos.wizard-ubicacion', $uuid );
    }


    //function to edit a 'equipo'
    public function edit(Equipo $equipo)
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

//Funcion para actualizar en caso de que el Usuario lo necesecite
public function update(Request $request, Equipo $equipo)
{
    //1-Valores que si o si debemos de leer/obtener
    $equipo->update($request->only([
        'marca_equipo',
        'tipo_equipo',
        'serial',
        'sistema_operativo',
        'usuario_id',
        'ubicacion_id',
        'valor_inicial',
        'fecha_adquisicion',
        'vida_util_estimada',
    ]));

//2.-Valores Adicionales(En caso de tener)
if ($request->has('perifericos')) {

    //Por cada periferico 
    foreach ($request->input('perifericos') as $peripheralData) {
         
    //Ignorar perifericos completamente Vacios
    if (empty(array_filter($peripheralData))) {
        # code...
        continue;
    }
            //Si tiene ID
            if (isset($peripheralData['id'])) {

                $periferico = Periferico::find($peripheralData['id']);

                if ($periferico) {

                if (!empty($peripheralData['_delete'])) {
                    $periferico->delete();
                    continue;
                }

                    //Si no esta vacio y que se llenen Los 2 campos
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

                // else {
                //     $equipo->perifericos()->create([
                //         'tipo' => $peripheralData['tipo'],
                //         'serial' => $peripheralData['seriala']

                //     ]);

                // }
            } 

        else {
            $equipo->perifericos()->create([
                'tipo' => $peripheralData['tipo'],
                'serial' => $peripheralData['serial'],
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

if ($request->has('procesadores')) {
        foreach ($request->input('procesadores') as $peripheralData) {
            
            if (isset($peripheralData['id'])) {

                $procesador = Procesador::find($peripheralData['id']);
                
            
                if ($procesador) {
                    
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

    $equipo->update($request->all());


    $detalles = [];
    foreach($equipo->getChanges() as $campo => $valorNuevo){
        $detalles[$campo] = [
            'old' => $equipo->getOriginal($campo),
            'new' => $valorNuevo
        ];
    }
    \App\Services\AuditService::log('EDIT', $equipo->id, $detalles);


    return redirect()->route('equipos.index')
    ->with('warning', 'Equipo editado correctamente')
    ->with('actualizado->id', $equipo->id);
}


    //function to delete some 'equipo'
    public function indexaddwork(Equipo $equipo)
    {
        $usuarios = User::all();
        return view('equipos.addwork',compact('equipo', 'usuarios'));
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
