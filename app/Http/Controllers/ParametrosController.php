<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Estado;
use App\Models\MedioRecepcion;
use App\Models\Prioridad;
use App\Models\TipoArchivo;
use App\Models\TipoCuenta;
use App\Models\TipoEleccion;
use App\Models\TipoIdentificacion;
use App\Models\TipoTramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParametrosController extends Controller
{
    public function indexArchivo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoArchivo::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoArchivo::where($criterio, 'like', '%' . $buscar . '%')
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

    public function indexIdentificacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoIdentificacion::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoIdentificacion::where($criterio, 'like', '%' . $buscar . '%')
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

    public function indexPrioridad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = Prioridad::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = Prioridad::where($criterio, 'like', '%' . $buscar . '%')
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

    public function indexEleccion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoEleccion::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoEleccion::where($criterio, 'like', '%' . $buscar . '%')
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
    public function indexTramite(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoTramite::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoTramite::where($criterio, 'like', '%' . $buscar . '%')
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
    public function indexRecepcion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = MedioRecepcion::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = MedioRecepcion::where($criterio, 'like', '%' . $buscar . '%')
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
    public function indexEstado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = Estado::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = Estado::where($criterio, 'like', '%' . $buscar . '%')
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
    public function indexBanco(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = Banco::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = Banco::where($criterio, 'like', '%' . $buscar . '%')
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

    public function indexTipoCuenta(Request $request)
    
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $departamentos = TipoCuenta::orderBy('id', 'desc')->paginate(10);
        } else {
            $departamentos = TipoCuenta::where($criterio, 'like', '%' . $buscar . '%')
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


    public function estadoInactivar($id, $tabla, $estado)
    {
        DB::table($tabla)->where('id', $id)->update(['estado' => $estado]);
    }

	public function actualizar($id,$tabla,$data)
	{
		DB::table($tabla)->where('id', $id)->update(['nombre' => $data,]);
	}

	public function nuevo(Request $r)
	{
		 DB::table($r->tabla)->insert(['nombre' => $r->nombre,'estado' => '1', 'idAsesorRegistra'=>Auth::user()->id]);
	}
}
