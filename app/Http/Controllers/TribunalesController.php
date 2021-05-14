<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Ciudades;
use App\Models\DepartamentoCentralizado;
use App\Models\Departamentos;
use App\Models\DepartamentoUsuario;
use App\Models\Estado;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TribunalesController extends Controller
{ 
    public function store(Request $request)
    {
        return request()->all();
    }

	public function data()
	{  
		return response()->json([
            'departamentos' => Departamentos::all()->where('estado',1),
            'ciudades' => Ciudades::all()->where('estado',1),
            'tipo_documento' => TipoDocumento::all()->where('estado',1),
            'estado' => Estado::all()->where('estado',1),
        ]);
	}
}
