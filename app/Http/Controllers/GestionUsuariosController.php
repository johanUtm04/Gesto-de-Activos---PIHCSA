<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class GestionUsuariosController extends Controller
{


    public function index(Request $request)
    {
            $users = User::paginate(10);
            return view('users.index',compact('users'));
    }

    public function create()
    {
        $users = User::all();
        return view('users.create', compact('users'));
    }


    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|string|max:35',
            'departamento' => 'required|string|max:35',
            'estatus' => 'required|string|max:35',
        ]);
        $user->create($request->all());

        return redirect()->route('users.index')->with('succes', 'Usuario agregado correctamente');
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    

    public function update(Request $request,User $user)
    {

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'rol' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'estatus'=> 'nullable|string|max:255',
        ]);

    $user->update($request->all());

        return redirect()->route('users.index')->with('warning', 'Usuario editado correctamente');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('danger', 'Equipo Eliminado correctamente');
    }


}