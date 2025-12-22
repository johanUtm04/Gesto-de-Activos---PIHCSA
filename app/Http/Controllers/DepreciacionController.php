<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepreciacionController extends Controller
{


public function index(Request $request)
{
        return view('depreciacion.index', [
            'user' => $request->user(),
        ]);
    }
    
}
