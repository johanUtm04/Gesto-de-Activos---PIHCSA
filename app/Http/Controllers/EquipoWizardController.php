<?php

namespace App\Http\Controllers;

use App\Models\Disco_Duro;
use App\Models\DiscoDuro;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Monitor;
use App\Models\Periferico;
use App\Models\Procesador;
use App\Models\Ram;
use Illuminate\Support\Str;

class EquipoWizardController extends Controller
{
    //Function to show wizard menu
    public function show(Equipo $equipo)
    {
        return view('equipos.wizard', compact('equipo'));
    }
    
    //function to show ubication's form
    public function ubicacionForm($uuid)
    {
        $wizard = session('wizard_equipo');

        // dd($wizard);

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wiazard Invalido o no funcional');
        }

        $equipo = $wizard['equipo'];
        // $wizard[equipo]
        // equipo => [
        //     "marca" => ['lenovo'],
        //     "serial" => ['091279486234987']
        // ]
        
        //equipo es para tener acceso a serial y demas mmda y uuid para el que estamos llenando
        return view('equipos.wizard-ubicacion', compact('equipo','uuid'));
    }

    //function to send ubication's form
    //Solo le pasamos como argumento lo que recoja del formualario qeu sera 
    //lo la ID de la Ubicacion de la base de datos
    public function saveUbicacion(Request $request)
    {
        $request->validate([
            'ubicacion_id' => 'required|exists:ubicaciones,id',
        ]);
        //Aqui estaba Erroneo ya que genero otra Identificador Unico temporal y se pierde la intencion de esto
        // $uuid = Str::uuid()->toString();
        //Guardamos mas bien en la variable el arreglo o no se como se le llame de wizard_equipo
        $wizard = session('wizard_equipo');
        session()->put('wizard_equipo.ubicacion', [
            'ubicacion_id' => $request->ubicacion_id,
        ]);
        //Guardamos en otra variable la part del ID ahora si 
        $uuid = $wizard['uuid'];
        //Vamos a donde la vista con el Puro ID generado que traemos arrastrasndo desde store del equipo
        return redirect()->route('equipos.wizard-monitores', $uuid);

    }

    //function to show monitores' form
    public function monitoresForm($uuid)
    {
        $wizard = session('wizard_equipo');

        //Si esta vacio o no cosincide con el que se esta manejando en la session
        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wiazard Invalido o no funcional');
        }

        $equipo = data_get($wizard, 'equipo.marca_equipo');


        //Vamonos ahora si a la vista
         return view('equipos.wizard-monitores', compact('equipo', 'uuid'));
    }

    //function to send Monitors' form
    public function saveMonitor(Request $request, $uuid)
    {
        $request->validate([
            'marca' => 'required|string',
            'serial' => 'required|string',
            'escala_pulgadas' => 'required|string',
            'interface' => 'required|string'
        ]);
        session()->put('wizard_equipo.monitor', [
            'marca' => $request->marca,
            'serial' => $request->serial,
            'escala_pulgadas' => $request->escala_pulgadas,
            'interface' => $request->interface,
        ]);
    $wizard = session('wizard_equipo');
    $uuid = $wizard['uuid'];
        return redirect()->route('equipos.wizard-discos_duros', $uuid);
    }

    //function to show 'disco duro' form
    public function discoduroForm($uuid)
    {
        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wiazard Invalido o no funcional');
        }

        $equipo = data_get($wizard, 'equipo.marca_equipo');

        return view('equipos.wizard-discos_duros', compact('equipo','uuid'));
    }

    //function to send 'disco duro' form
    public function saveDiscoduro(Request $request, $uuid)
    {
        //1.-Validar los datos 
        $request->validate([
            'capacidad' => 'required|string',
            'tipo_hdd_ssd' => 'required|string',
            'interface' => 'required|string',
        ]);
        //2.-Agregarlos al wizard
        session()->put('wizard_equipo.disco_duro', [
            'capacidad' => $request->capacidad,
            'tipo_hdd_ssd' => $request->tipo_hdd_ssd,
            'interface' => $request->interface,
        ]);
        //4.-Jalamoe al papau wizard
        $wizard = session ('wizard_equipo');
        //5.-El token detergente lo tomamos de la session
        $uuid = $wizard['uuid'];
        //6.-Pasamos esa vaina
        return redirect()->route('equipos.wizard-ram', $uuid);    

    }

    //function to show ram's form
    public function ramForm($uuid)
    {
        //1.-Llammos la pana wiazrd
        $wizard = session('wizard_equipo');

        //Validamos que el token sea detergemte
        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wiazard Invalido o no funcional');
        }

        //GUardamos el equipo pero esta mal alv
        $equipo = data_get($wizard, 'equipo.marca_equipo');

        //Reyornamos ahora si la vista con el equipo que esta mal ALV y el detergente
        return view('equipos.wizard-rams', compact('equipo', 'uuid'));
    }
    
        //function to send saveDiscoduro's mini-form
    public function saveRam(Request $request, $uuid)
    {
        //1.-VAlidamos lo del formulario alv
        $request->validate([
            'capacidad_gb' => 'required|string',
            'clock_mhz' => 'required|string',
            'tipo_chz' => 'required|string'
        ]);

        //2.-Los Agregamos al wizard 
        session()->put('wizard_equipo.ram', [
            'capacidad_gb' => $request->capacidad_gb,
            'clock_mhz' => $request->clock_mhz,
            'tipo_chz' => $request->tipo_chz,
        ]);

        //3.-Jalamoe al papau wizard
        $wizard = session ('wizard_equipo');
        //4.-El token detergente lo tomamos de la session
        $uuid = $wizard['uuid'];

        return redirect()->route('equipos.wizard-periferico', $uuid);

    }

    //function to show periferico's form
    public function perifericoForm($uuid)
    {
    //1.-Llamar al wizard
    $wizard = session('wizard_equipo');
    //2.-Validar que el Token sobre el que vamos a estar trabajando Funcione
    if (!$wizard || $wizard['uuid'] !== $uuid) {
        abort(403, 'Wiazard Invalido o no funcional');
    }
    //3.-Tomar el id y el equipo para pasarlo al formulario (esta mal pero Igual)
    $equipo = data_get($wizard, 'equipo.marca_equipo');
    return view('equipos.wizard-periferico', compact('equipo', 'uuid'));
    }
    
    //Guardar el periferico en la session
    public function savePeriferico(Request $request, $uuid)
    {
        //1.-Validamos los datos
        $request->validate([
            'tipo' => 'required|string',
            'marca' => 'required|string',
            'serial' => 'required|string',
            'interface' => 'required|string',
        ]);
        //2.-Creamos esta parte en el wizard
        session()->put('wizard_equipo.periferico', [
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'serial' => $request->serial,
            'interface' => $request->interface,
        ]);
        //3.-Jalamoe al papau wizard
        $wizard = session ('wizard_equipo');
        //4.-El token detergente lo tomamos de la session
        $uuid = $wizard['uuid'];

        return redirect()->route('equipos.wizard-procesador', $uuid);
    }

    //function to show periferico's form
    public function ProcesadorForm($uuid)
    {
        // dd($uuid);
        //1.-Llamar al wizard
        $wizard = session('wizard_equipo');

        //2.-Validar que el toquen sobre el que estamos trabajando Funcione
        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wiazard Invalido o no funcional');
        }

        //3.-Tomar el id... aunque no funciona
        $equipo = data_get($wizard, 'equipos.marca_equipo');
        // dd($uuid);
        // dd($equipo);
        return view('equipos.wizard-procesador', compact('uuid'));
    }
    
    //function to send procesador
    public function saveProcesador(Request $request, $uuid)
    {   //1.-Validamos los datos
        $request->validate([
            'marca' => 'required|string',
            'descripcion_tipo' => 'required|string',
        ]);
        //2.-Guardamos esta parte en el Wizard
        session()->put('wizard_equipo.procesador', [
            'marca' => $request->marca,
            'descripcion_tipo' => $request->descripcion_tipo,
        ]);
        //3.-Jalamoe al papau wizard
        $wizard = session ('wizard_equipo');

        //Validar que el detergente es valido o no
        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Wizard inválido');
        }

        //Crear base del registro 
        $equipo = Equipo::create([
            ...$wizard['equipo'],
            'ubicacion_id' => $wizard['ubicacion']['ubicacion_id'] ?? null,
        ]);
        
        //Llaves Foraneas del registro
        if (!empty($wizard['monitor'])) {
            $equipo->monitores()->create($wizard['monitor']);
        }

        if (!empty($wizard['disco_duro'])) {
            $equipo->discosDuros()->create($wizard['disco_duro']);
        }
    
        if (!empty($wizard['ram'])) {
            $equipo->rams()->create($wizard['ram']);
        }

        if (!empty($wizard['periferico'])) {
            $equipo->perifericos()->create($wizard['periferico']);
        }

        if (!empty($wizard['procesador'])) {
            $equipo->procesadores()->create($wizard['procesador']);
        };

        //Limpiar sesion
        session()->forget('wizard_equipo');

        return redirect()->route('equipos.index', $uuid)
        ->with('success', 'Equipo registrado correctamente')
        ->with('highlight_id', $equipo->id);
        ;
    }

}
