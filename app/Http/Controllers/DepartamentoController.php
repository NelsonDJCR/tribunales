<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use App\Models\Estado;
use App\Models\MedioRecepcion;
use App\Models\Prioridad;
use App\Models\TipoArchivo;
use App\Models\TipoCuenta;
use App\Models\TipoEleccion;
use App\Models\TipoIdentificacion;
use App\Models\TipoTramite;
use Illuminate\Support\Facades\Session;


class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $departamentos = Departamentos::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $departamentos = Departamentos::where($criterio, 'like', '%'. $buscar . '%')
                                            ->orderBy('id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'        => $departamentos->total(),
                'current_page' => $departamentos->currentPage(),
                'per_page'     => $departamentos->perPage(),
                'last_page'    => $departamentos->lastPage(),
                'from'         => $departamentos->firstItem(),
                'to'           => $departamentos->lastItem(),
            ],
            'departamentos' => $departamentos
        ];
    }

    public function selectDepartamento(Request $request){
        if (!$request->ajax()) return redirect('/');
        $departamentos = Departamentos::select('id','nombre as nom_departamento')
                        ->where('nombre',Session::get('conexion'))
                        ->orderBy('nombre', 'asc')->get()->toArray();
       
        return ['departamentos' => $departamentos];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = new Departamentos();
        $departamento->nombre = $request->nombre;
        $departamento->estado = '1';
        $departamento->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = Departamentos::findOrFail($request->id);
        $departamento->nombre = $request->nombre;
        $departamento->estado = '1';
        $departamento->save();
    }

    public function seleccioneDepartamento( Request $request){
        
        if (!$request->ajax()) return redirect('/');

            $departamentos = Departamentos::where('estado','=','1')
            ->select('id','nombre')->orderBy('nombre', 'asc')->get();

        return ['departamentos' => $departamentos];

    }

    public function inactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = Departamentos::findOrFail($request->id);
        $departamento->estado = '0';
        $departamento->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $departamento = Departamentos::findOrFail($request->id);
        $departamento->estado = '1';
        $departamento->save();
    }

	
}
