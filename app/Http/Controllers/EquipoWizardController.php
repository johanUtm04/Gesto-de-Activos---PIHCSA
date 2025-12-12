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

class EquipoWizardController extends Controller
{
    //Function to show wizard menu
    public function show(Equipo $equipo)
    {
        return view('equipos.wizard', compact('equipo'));
    }
    
    //function to show ubication's form
    public function ubicacionForm(Equipo $equipo)
    {
        return view('equipos.wizard-ubicacion', compact('equipo'));
    }

    //function to send ubication's form
    public function saveUbicacion(Request $request, Equipo $equipo)
    {
        $request->validate([
            'ubicacion_id' => 'required|exists:ubicaciones,id',
        ]);

        $equipo->ubicacion_id = $request->ubicacion_id;
        $equipo->save();

        return redirect()->route('equipos.wizard-monitores', $equipo->id)
            ->with('success', 'Ubicación registrada');
    }

    //function to show monitores' form
    public function monitoresForm(Equipo $equipo)
    {

         return view('equipos.wizard-monitores', compact('equipo'));
    }

    //function to send Monitors' form
    public function saveMonitor(Request $request, Equipo $equipo)
    {
        $request->validate([
            'marca' => 'required|string',
            'serial' => 'required|string',
            'escala_pulgadas' => 'required|string',
        ]);

        Monitor::create([
            'equipo_id' => $equipo->id,
            'marca' => $request->marca,
            'serial' => $request->serial,
            'escala_pulgadas' => $request->escala_pulgadas,
            'interface' => $request->interface,
        ]);

        return redirect()->route('equipos.wizard-discos_duros', $equipo->id)
            ->with('success', 'Monitor registrado correctamente');
    }



    //function to show 'disco duro' form
    public function discoduroForm(Equipo $equipo)
    {
        return view('equipos.wizard-discos_duros', compact('equipo'));
    }

    //function to send 'disco duro' form
    public function saveDiscoduro(Request $request, Equipo $equipo)
    {
        $request->validate([
            'capacidad' => 'nullable|string',
            'tipo_hdd_ssd' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);

        DiscoDuro::create([
            'equipo_id' => $equipo->id,
            'capacidad' => $request->capacidad,
            'tipo_hdd_ssd' => $request->tipo_hdd_ssd,
            'interface' => $request->interface,
        ]);

        return redirect()->route('equipos.wizard-ram', $equipo->id)
            ->with('success', 'Disco Duro registrado correctamente');
    }

    //function to show ram's form
    public function ramForm(Equipo $equipo)
    {
        return view('equipos.wizard-rams', compact('equipo'));
    }
    
        //function to send saveDiscoduro's mini-form
    public function saveRam(Request $request, Equipo $equipo)
    {
        $request->validate([
            'capacidad_gb' => 'nullable|string',
            'clock_m' => 'nullable|string',
            'tipo_chz' => 'nullable|string',
        ]);

        Ram::create([
            'equipo_id' => $equipo->id,
            'capacidad_gb' => $request->capacidad_gb,
            'clock_mhz' => $request->clock_m,
            'tipo_chz' => $request->tipo_chz,
        ]);

        return redirect()->route('equipos.wizard-periferico', $equipo->id)
            ->with('success', 'Ram registrada correctamente');
    }

    //function to show periferico's form
    public function perifericoForm(Equipo $equipo)
    {
        return view('equipos.wizard-periferico', compact('equipo'));
    }
    
    //function to send periferico
    public function savePeriferico(Request $request, Equipo $equipo)
    {
        $request->validate([
            'tipo' => 'nullable|string',
            'marca' => 'nullable|string',
            'serial' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);

        Periferico::create([
            'equipo_id' => $equipo->id,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'serial' => $request->serial,
            'interface' => $request->interface,
        ]);

        return redirect()->route('equipos.wizard-procesador', $equipo->id)
            ->with('success', 'Periferico registrado correctamente');
    }

    //function to show periferico's form
    public function ProcesadorForm(Equipo $equipo)
    {
        return view('equipos.wizard-procesador', compact('equipo'));
    }
    
    //function to send periferico
    public function saveProcesador(Request $request, Equipo $equipo)
    {
        $request->validate([
            'marca' => 'nullable|string',
            'descripcion_tipo' => 'nullable|string',
        ]);

        Procesador::create([
            'equipo_id' => $equipo->id,
            'marca' => $request->marca,
            'descripcion_tipo' => $request->descripcion_tipo,
        ]);

        return redirect()->route('equipos.index', $equipo->id)
            ->with('success', 'Equipo registrado correctamente');
    }

}
