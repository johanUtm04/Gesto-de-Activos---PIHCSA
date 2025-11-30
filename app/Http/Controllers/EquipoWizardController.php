<?php

namespace App\Http\Controllers;

use App\Models\Disco_Duro;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Monitor;

class EquipoWizardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    //Function to show wizard menu
    public function show(Equipo $equipo)
    {
        return view('equipos.wizard', compact('equipo'));
    }
    
    //function to show ubication mini-form
    public function ubicacionForm(Equipo $equipo)
    {
        return view('equipos.wizard-ubicacion', compact('equipo'));
    }

    //function to send ubication's mini-form
    public function saveUbicacion(Request $request, Equipo $equipo)
    {
        $request->validate([
            'ubicacion_id' => 'required|exists:ubicaciones,id',
        ]);

        $equipo->ubicacion_id = $request->ubicacion_id;
        $equipo->save();

        return redirect()->route('equipos.wizard', $equipo->id)
            ->with('success', 'Ubicación registrada');
    }

    //function to show monitores mini-form
    public function monitoresForm(Equipo $equipo)
    {

         return view('equipos.wizard-monitores', compact('equipo'));
    }

    //function to save Monitors' mini-form
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

        return redirect()->route('equipos.wizard', $equipo->id)
            ->with('success', 'Monitor registrado correctamente');
    }



    //function to show monitor mini-form
    public function discoduroForm(Equipo $equipo)
    {
        return view('equipos.wizard-discos_duros', compact('equipo'));
    }

    //function to save Monitors' mini-form
    public function saveDiscoduro(Request $request, Equipo $equipo)
    {
        $request->validate([
            'capacidad' => 'nullable|string',
            'tipo_hdd_ssd' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);

        Disco_Duro::create([
            'equipo_id' => $equipo->id,
            'capacidad' => $request->capacidad,
            'tipo_hdd_ssd' => $request->tipo_hdd_ssd,
            'interface' => $request->interface,
        ]);

        return redirect()->route('equipos.wizard', $equipo->id)
            ->with('success', 'Disco Duro registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
