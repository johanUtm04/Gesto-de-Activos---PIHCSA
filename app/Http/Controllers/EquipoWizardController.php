<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

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
public function monitoresForm(Request $request)
{
    $equipoId = $request->session()->get('equipo_id');

    return view('equipos.wizard-monitores', compact('equipoId'));
}

public function saveMonitor(Request $request)
{
    $request->validate([
        'marca' => 'required|string',
        'modelo' => 'required|string',
        'pulgadas' => 'nullable|integer',
    ]);

    $equipoId = $request->session()->get('equipo_id');

    Monitor::create([
        'marca' => $request->marca,
        'modelo' => $request->modelo,
        'pulgadas' => $request->pulgadas,
        'equipo_id' => $equipoId
    ]);

    return redirect()->route('wizard.discosForm'); // siguiente paso
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
