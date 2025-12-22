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

        return redirect()->route('users.index')->with('warning', 'Equipo editado correctamente');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('danger', 'Equipo Eliminado correctamente');
    }


}