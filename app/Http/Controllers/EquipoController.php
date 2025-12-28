<?php
namespace App\Http\Controllers;

//Importacion de Modelos
use App\Models\DiscoDuro;
use App\Models\Equipo;
use App\Models\Monitor;
use App\Models\Ubicacion;
use App\Models\Historial_log;
use App\Models\Procesador;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use Illuminate\Support\Str;


class EquipoController extends Controller
{
    //Funcion para mostrar vista principal 🟦
    public function index()
    {
        session()->forget('wizard_equipo');
        $equipos = Equipo::paginate(8);
        return view('equipos.index', compact('equipos'));
    }

    //Funcion para mostrar fomrulario basico 🟦
    public function create()
    {
        session()->forget('wizard_equipo');
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipo.wizard.create', compact('usuarios', 'ubicaciones'));
    }

    //Funcion para mandar datos del formulario del equipo 🟦
    public function store(Request $request, Equipo $equipo)
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

        //$uuid es un numero unico generado en cada envio y se guarda en la sesion
        $uuid = Str::uuid()->toString();

        session()->put('wizard_equipo.uuid', $uuid);

        session()->put('wizard_equipo.equipo', $data);

        return redirect()->route('equipos.wizard-ubicacion', $uuid );
    }


    //Funcion para ver la vista de edicion (pantalla dividida) 🟦
    public function edit(Equipo $equipo)
    {
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

//Funcion para mandar datos del equipos.edit 🟦
public function update(Request $request, Equipo $equipo)
{

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


    /*
    En caso de que en la edicion se vea afectada una de las tablas
    extras, entrara en cualquiera de estas condiciones, 
    ese es el proposito de esta seccion
    */
    if ($request->has('perifericos')) {

        //1.-Por cada input 'perifericos' recibido lo metemos en una cajita llamada $peripheralData
        foreach ($request->input('perifericos') as $peripheralData) {

        //2.- Ignorar en caso de que este completamente vacio, es decir, no se edito en lo absoluto
        if (empty(array_filter($peripheralData))) {
            continue;
        }

        //3.-Si tiene ID Valido entrasmos aqui
        if (isset($peripheralData['id'])) {

            //4.-Guardamos la relacion cuando coincida con ese Id
            $periferico = $equipo->perifericos()->where('id', $peripheralData['id'])->first();

            //5.-Si no esta vacio entramos aqui
            if ($periferico) {

                //6.-En caso de que el usuario presione el boton de Eliminar entra aqui
                if (!empty($peripheralData['_delete'])) {
                    $periferico->delete();
                    continue;
                }

                //7.-2da confirmacion, si ambos estan vacios, quiere decir que el usuario lo quiere Eliminar
                if (empty($peripheralData['tipo']) && empty($peripheralData['serial'])) {
                    $periferico->delete(); 
                } else {    
                    //8.-Si alguno de los 2 tiene datos actualizamos
                    $periferico->update([
                    'tipo' => $peripheralData['tipo'],
                    'serial' => $peripheralData['serial'],
                    ]);
                }
            }
        } 

        else {
        $equipo->perifericos()->create([
        'tipo' => $peripheralData['tipo'],
        'serial' => $peripheralData['serial'],
        ]);
        }

        } 
    }

    if ($request->has('rams')) {

        foreach ($request->input('rams') as $peripheralData) {

            if (empty(array_filter($peripheralData))) {
                continue;
            }

            if (isset($peripheralData['id'])) {

                $ram = $equipo->rams()
                    ->where('id', $peripheralData['id'])
                    ->first();

                if ($ram) {

                    if (!empty($peripheralData['_delete'])) {
                        $ram->delete();
                        continue;
                    }

                    if (
                        empty($peripheralData['capacidad_gb']) &&
                        empty($peripheralData['clock_mhz']) &&
                        empty($peripheralData['tipo_chz'])
                    ) {
                        $ram->delete();
                    } else {
                        $ram->update([
                            'capacidad_gb' => $peripheralData['capacidad_gb'],
                            'clock_mhz'    => $peripheralData['clock_mhz'],
                            'tipo_chz'     => $peripheralData['tipo_chz'],
                        ]);
                    }
                }
            } else {
                $equipo->rams()->create([
                    'capacidad_gb' => $peripheralData['capacidad_gb'],
                    'clock_mhz'    => $peripheralData['clock_mhz'],
                    'tipo_chz'     => $peripheralData['tipo_chz'],
                ]);
            }
        }
    }



    if ($request->has('procesadores')) {

        foreach ($request->input('procesadores') as $peripheralData) {

            if (empty(array_filter($peripheralData))) {
                continue;
            }

            if (isset($peripheralData['id'])) {

                $procesador = $equipo->procesadores()
                    ->where('id', $peripheralData['id'])
                    ->first();

                if ($procesador) {

                    if (!empty($peripheralData['_delete'])) {
                        $procesador->delete();
                        continue;
                    }

                    if (
                        empty($peripheralData['marca']) &&
                        empty($peripheralData['descripcion_tipo'])
                    ) {
                        $procesador->delete();
                    } else {
                        $procesador->update([
                            'marca'             => $peripheralData['marca'],
                            'descripcion_tipo'  => $peripheralData['descripcion_tipo'],
                        ]);
                    }
                }
            } else {
                $equipo->procesadores()->create([
                    'marca'            => $peripheralData['marca'],
                    'descripcion_tipo' => $peripheralData['descripcion_tipo'],
                ]);
            }
        }
    }


    if ($request->has('monitores')) {

        foreach ($request->input('monitores') as $peripheralData) {

            if (empty(array_filter($peripheralData))) {
                continue;
            }

            if (isset($peripheralData['id'])) {

                $monitor = $equipo->monitores()
                    ->where('id', $peripheralData['id'])
                    ->first();

                if ($monitor) {

                    if (!empty($peripheralData['_delete'])) {
                        $monitor->delete();
                        continue;
                    }

                    if (
                        empty($peripheralData['marca']) &&
                        empty($peripheralData['serial']) &&
                        empty($peripheralData['escala_pulgadas']) &&
                        empty($peripheralData['interface'])
                    ) {
                        $monitor->delete();
                    } else {
                        $monitor->update([
                            'marca'            => $peripheralData['marca'],
                            'serial'           => $peripheralData['serial'],
                            'escala_pulgadas'  => $peripheralData['escala_pulgadas'],
                            'interface'        => $peripheralData['interface'],
                        ]);
                    }
                }
            } else {
                $equipo->monitores()->create([
                    'marca'           => $peripheralData['marca'],
                    'serial'          => $peripheralData['serial'],
                    'escala_pulgadas' => $peripheralData['escala_pulgadas'],
                    'interface'       => $peripheralData['interface'],
                ]);
            }
        }
    }


    
    if ($request->has('discoDuros')) {

        foreach ($request->input('discoDuros') as $peripheralData) {

            if (empty(array_filter($peripheralData))) {
                continue;
            }

            if (isset($peripheralData['id'])) {

                $discoDuro = $equipo->discosDuros()
                    ->where('id', $peripheralData['id'])
                    ->first();

                if ($discoDuro) {

                    if (!empty($peripheralData['_delete'])) {
                        $discoDuro->delete();
                        continue;
                    }

                    if (
                        empty($peripheralData['capacidad']) &&
                        empty($peripheralData['tipo_hdd_ssd']) &&
                        empty($peripheralData['interface'])
                    ) {
                        $discoDuro->delete();
                    } else {
                        $discoDuro->update([
                            'capacidad'     => $peripheralData['capacidad'],
                            'tipo_hdd_ssd'  => $peripheralData['tipo_hdd_ssd'],
                            'interface'     => $peripheralData['interface'],
                        ]);
                    }
                }
            } else {
                $equipo->discosDuros()->create([
                    'capacidad'    => $peripheralData['capacidad'],
                    'tipo_hdd_ssd' => $peripheralData['tipo_hdd_ssd'],
                    'interface'    => $peripheralData['interface'],
                ]);
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

    //1.-Cuantos activos vemos por pagina
    $perPage =8;

    //2.-Calculamos su posicion, contamos todos los equipos antes del que estamos editando
    //ejemplo si hay 12 antes position es 13 pq tmbn cuenta =<
    $position = Equipo::where('id', '<=', $equipo->id)->count();

    //hacemos la division de 13 / 8 ceil redondea hacia Arriba
    $page = ceil($position / $perPage); //1.65 === 2 

    //Es HTTP puro, manda a la url el ?page=2
    return redirect()->route('equipos.index', ['page' => $page])
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
        //1.-Cuantos activos mostramos por pagina ??
        $perPage = 8;


        //2.-Cuants hay por detras?
        $position = Equipo::where('id', '<=', $equipo->id)->count();

        //3.-Descubrir en que pagina va?
        $page = ceil($position/$perPage);
        
        $equipo->delete();
        return redirect()->route('equipos.index', ['page' => $page])
        ->with('danger', 'Equipo Eliminado correctamente');
    }
}
