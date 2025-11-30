<?php

namespace App\Http\Controllers;

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

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        //Al pasar al menu de wizrd le pasamos la variable equipo 
        return view('equipos.wizard', compact('equipo'));
    }

//Ubicacion---------------------------------------
    public function ubicacionForm(Equipo $equipo)
    {
        return view('equipos.wizard-ubicacion', compact('equipo'));
    }

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

//Monitores------------------
    public function monitoresForm(Equipo $equipo)
    {

         return view('equipos.wizard-monitores', compact('equipo'));
    }

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
            ->with('success', 'Ubicación registrada');
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
