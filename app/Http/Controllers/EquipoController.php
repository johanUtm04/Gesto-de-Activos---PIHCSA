<?php
namespace App\Http\Controllers;

//IMPORTACION DE MODELOS
use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\Historial_log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class EquipoController extends Controller
{
    // FUNCION PARA IR AL DASHBOARD PRINCIPAL, 
    // OLVIDA EL ACTIVO CON UN IDENTIFICADOR UNICO DE SESSION EN CASA DE QUE 
    // HAGAMOS UN 'BACK' A LA PANTALLA DE DASHBOARD PRINCIPAL, ADEMAS CONPAGINA 
    // LOS ACTIVOS DE LA BASE DE DATOS
    public function index()
    {
        session()->forget('wizard_equipo');
        $equipos = Equipo::with(['usuario', 'ubicacion'])->paginate(11);
        return view('equipos.index', compact('equipos'));
    }

    //FUNCION PARA VALIDAR DATOS DEL FORMULARIO BASE, MANDARLOS
    //Y ENTRAR DE UNA VEZ AL WIZARD, OCURRE LA VALIDACIONM ADEMAS
    //CAMPOS DE RESPALDO EN CASO DE QUE NO SE LLENEN LOS CAMPOS NO 
    //OBLIGATORIOS, AGREGANDO LA CREACION DEL INENTIFICADOR UNICO QUE 
    //ESTAREMOS "PASEANDO" POR LA URL DEL WIZARD
    public function store(Request $request)
    {
        $request->validate([
            'marca_equipo' => 'nullable|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'serial' => 'nullable|string|max:255',
            'sistema_operativo' => 'required|string|max:35', 
            'usuario_id' => 'required|integer|exists:users,id',
            'ubicacion_id' => 'nullable|integer|exists:ubicaciones,id',
            'valor_inicial' => 'nullable|numeric|min:0|max:99999999.99',
            'fecha_adquisicion' => 'required|date',
            'vida_util_estimada' => 'required|string|max:255',
        ]);
        $data = $request->all();

        $data['serial'] = $request->serial ?? 'INT-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $data['marca_equipo'] = $request->marca_equipo ?? 'Sin marca asignada';
        $data['valor_inicial'] = $request->valor_inicial ?? 0;

        $uuid = Str::uuid()->toString();
        session()->put('wizard_equipo.uuid', $uuid);
        session()->put('wizard_equipo.equipo', $data);
        return redirect()->route('equipos.wizard-ubicacion', $uuid );
    }


    //FUNCION PARA VER LA VISTA DE EDICION DE ACTIVOS, 
    //Donde recibe 3 tablas equipo(junto con sus relaciones), 
    //usuario y ubicaciones que son independientes, y las 
    //Usaremos para crear una vista comoda para el usuario
    public function edit(Equipo $equipo)
    {
        // 1. Eager Loading: Traemos todas las piezas del equipo en un solo viaje
        $equipo->load([
            'monitores', 
            'discosDuros', 
            'rams', 
            'perifericos', 
            'procesadores'
        ]);
        $usuarios = User::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

//FUNCION PARA
public function update(Request $request, Equipo $equipo)
{

    //1.-Busca en el Formulario Unicamente estos datos
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


    /* 2.-
        En caso de que en la edicion se vea afectada una de las tablas
        extras, entrara en cualquiera de estas condiciones, 
        ese es el proposito de esta seccion
    */
    //3.-En caso de ver un input con estos nombres...
    if ($request->has('perifericos')) {

        //3.1.- Por cada Input hallado, guardalo como $peripheralData
        foreach ($request->input('perifericos') as $peripheralData) {

        //3.2.- Si esta completamente Vacio pasamos al sigueinte, ejemplo si 
        //perifericos[index+2][tipo]
        //perifericos[index+2][marca]
        //perifericos[index+2][serial]
        //perifericos[index+2][interface]
        //perifericos[index+2][id]  value="{{ $periferico->id }}">
        //Es decir, todos estos estan vacios
        if (empty(array_filter($peripheralData))) {
            continue;
        }

        //CASO 1 //perifericos[index+2][id] 
        //3.3 SI ESE ID ya esta quiere decir que ese ya existe en la DB
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
                    //11.-Si alguno de los 2 tiene datos actualizamos
                    $periferico->update([
                    'tipo' => $peripheralData['tipo'],
                    'serial' => $peripheralData['serial'],
                    'marca' => $peripheralData['marca'],
                    'interface' => $peripheralData['interface'],
                ]);
                }
            }
        } 
        //CASO 2 //perifericos[index+2]['vacio'] viene vacio pq en ningun momento lo llena el Usuario   

        else {
        $equipo->perifericos()->create([
            'tipo' => $peripheralData['tipo'],
            'serial' => $peripheralData['serial'],
            'marca' => $peripheralData['marca'],
            'interface' => $peripheralData['interface'],
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


    //Detalles de Auditoria.. en proceso...

/**
 * Paginacion, logica para dependiendo la accion que hagas en el activo qeu lo hagas te devuelva a esa 
 * pagina
 */

    //1.-Tomar en cuenta cuantos registros hay por pagina
    $perPage =11;

    //2.-Calculamos cuantos registros hay por detras
    $position = Equipo::where('id', '<=', $equipo->id)->count();

    //3.-Calculamos el numero y lo redondeamos de manera ascendente
    $page = ceil($position / $perPage);

    //4.-Mandar parametro para que la URL se vea afectada y aparezca en la pagina que quiero
    return redirect()->route('equipos.index', ['page' => $page])
    ->with('warning', 'Equipo editado correctamente')
    ->with('actualizado->id', $equipo->id);
}


    //Funcion para devolver la vista de mantenimientos 🟦
    public function indexaddwork(Equipo $equipo)
    {
        $usuarios = User::all();
        return view('equipos.addwork',compact('equipo', 'usuarios'));
    }


    //Funcion para mandar mantenimiento 🟦
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



    //funcion para elminar activos 🟦
    public function destroy(Equipo $equipo)
    {
        $perPage = 11;

        $position = Equipo::where('id', '<=', $equipo->id)->count();

        $page = ceil($position/$perPage);
        
        $equipo->delete();
        return redirect()->route('equipos.index', ['page' => $page])
        ->with('danger', 'Equipo Eliminado correctamente');
    }

public function show($id) // Cambiamos el nombre de la variable de uuid a id para que sea claro
{

    $equipo = Equipo::with(['usuario', 'ubicacion', 'monitores', 'discosDuros', 'rams', 'perifericos', 'procesadores'])
    ->findOrFail($id); 

    return view('equipos.detalles', compact('equipo'));
}

}
