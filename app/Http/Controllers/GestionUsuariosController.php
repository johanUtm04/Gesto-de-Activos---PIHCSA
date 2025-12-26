<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Equipo;

class GestionUsuariosController extends Controller
{


    public function index(Request $request, Equipo $equipo)
    {
            $users = User::paginate(10);
            return view('users.index',compact('users'));
    }

    public function create()
    {
        $users = User::all();
        return view('users.create', compact('users'));
    }


    public function store(Request $request,)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|string|max:35',
            'departamento' => 'required|string|max:35',
            'estatus' => 'required|string|max:35',
        ]);

       $user = User::create($request->all());

        //1.-Cuantos usuarios mostramos por pagina ??
        $perPage = 10;


        //2.-Cuants hay por detras?
        $position = User::where('id', '<=', $user->id)->count();

        //3.-Descubrir en que pagina va?
        $page = ceil($position/$perPage);

        return redirect()->route('users.index', ['page' => $page])
        ->with('new_id', $user->id)
        ->with('success', 'Usuario agregado correctamente');
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


        //1.-Cuantos usuarios mostramos por pagina ??
        $perPage = 10;


        //2.-Cuants hay por detras?
        $position = User::where('id', '<=', $user->id)->count();

        //3.-Descubrir en que pagina va?
        $page = ceil($position/$perPage);

        return redirect()->route('users.index', ['page' => $page])
        ->with('actualizado->id', $user->id)
        ->with('warning', 'Usuario editado correctamente');
    }



    public function destroy(User $user)
    {
        $user->delete();
        //Cuantos registros cargamos por pagina
        $perPage = 10;

        //cuantos hay detras ??
        $position = User::where('id', '<=', $user->id)->count();

        $page = ceil($position/$perPage);


        return redirect()->route('users.index', ['page' => $page])
        ->with('danger', 'Equipo Eliminado correctamente');
    }


}