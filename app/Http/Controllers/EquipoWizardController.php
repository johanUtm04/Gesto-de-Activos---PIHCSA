<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

use App\Models\user;

class EquipoWizardController extends Controller
{


public function create()
{
    // session()->forget('wizard_equipo');
    $wizard = session('wizard_equipo');
    $usuarios = User::all();
    $equipo = data_get($wizard, 'equipo', []);
    return view('equipos.create', compact('equipo', 'usuarios'));
}

    //Function to show wizard menu
    public function show(Equipo $equipo)
    {
        return view('equipos.wizard', compact('equipo'));
    }
    
    //function to show ubication's form
    public function ubicacionForm($uuid)
    {
        $wizard = session('wizard_equipo');


        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Incorrecto continua con el flujo habitual');
        }

        $equipo = data_get($wizard, 'equipo');
      

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
            abort(403, 'Incorrecto continua con el flujo Habitual');
        }

        $equipo = data_get($wizard, 'equipo');

        // dd($equipo);

        //Vamonos ahora si a la vista
         return view('equipos.wizard-monitores', compact('equipo', 'uuid'));
    }

    //function to send Monitors' form
    public function saveMonitor(Request $request, $uuid)
    {
        $request->validate([
            'marca' => 'nullable|string',
            'serial' => 'nullable|string',
            'escala_pulgadas' => 'nullable|string',
            'interface' => 'nullable|string'
        ]);
        session()->put('wizard_equipo.monitor', [
            'marca' => $request->marca,
            'serial' => $request->serial,
            'escala_pulgadas' => $request->escala_pulgadas,
            'interface' => $request->interface,
        ]);
    $wizard = session ('wizard_equipo');
    $uuid = $wizard['uuid'];
        return redirect()->route('equipos.wizard-discos_duros', $uuid);
    }

    //function to show 'disco duro' form
    public function discoduroForm($uuid)
    {
        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Incorrecto continua con el flujo Habitual');
        }

        $equipo = data_get($wizard, 'equipo');

        return view('equipos.wizard-discos_duros', compact('equipo','uuid'));
    }

    //function to send 'disco duro' form
    public function saveDiscoduro(Request $request, $uuid)
    {
        //1.-Validar los datos 
        $request->validate([
            'capacidad' => 'nullable|string',
            'tipo_hdd_ssd' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);
        //2.-Agregarlos al wizard
        session()->put('wizard_equipo.disco_duro', [
            'capacidad' => $request->capacidad,
            'tipo_hdd_ssd' => $request->tipo_hdd_ssd,
            'interface' => $request->interface,
        ]);
        $wizard = session ('wizard_equipo');
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
            abort(403, 'Incorrecto continua con el flujo Habitual');
        }

        //GUardamos el equipo pero esta mal alv
        $equipo = data_get($wizard, 'equipo');

        //Reyornamos ahora si la vista con el equipo que esta mal ALV y el detergente
        return view('equipos.wizard-rams', compact('equipo', 'uuid'));
    }
    
        //function to send saveDiscoduro's mini-form
    public function saveRam(Request $request, $uuid)
    {
        //1.-VAlidamos lo del formulario alv
        $request->validate([
            'capacidad_gb' => 'nullable|string',
            'clock_mhz' => 'nullable|string',
            'tipo_chz' => 'nullable|string'
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
        abort(403, 'Incorrecto continua con el flujo Habitual');
    }
    //3.-Tomar el id y el equipo para pasarlo al formulario (esta mal pero Igual)
    $equipo = data_get($wizard, 'equipo');
    return view('equipos.wizard-periferico', compact('equipo', 'uuid'));
    }
    
    //Guardar el periferico en la session
    public function savePeriferico(Request $request, $uuid)
    {
        //1.-Validamos los datos
        $request->validate([
            'tipo' => 'nullable|string',
            'marca' => 'nullable|string',
            'serial' => 'nullable|string',
            'interface' => 'nullable|string',
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

        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Incorrecto continua con el flujo Habitual');
        }

        $equipo = data_get($wizard, 'equipo');

        return view('equipos.wizard-procesador', compact('uuid', 'equipo'));
    }
    
    //function to send procesador
    public function saveProcesador(Request $request, $uuid)
    {   //1.-Validamos los datos
        $request->validate([
            'marca' => 'nullable|string',
            'descripcion_tipo' => 'nullable|string',
            'frecuenciaMicro' => 'nullable|string',
        ]);
        //2.-Guardamos esta parte en el Wizard
        session()->put('wizard_equipo.procesador', [
            'marca' => $request->marca,
            'descripcion_tipo' => $request->descripcion_tipo,
            'frecuenciaMicro' => $request->frecuenciaMicro,
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
