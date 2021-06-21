<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Departamentos;
use App\Models\Magistrado;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index()
    {
        $tabla = DB::table('magistrados')
            ->select(
                'magistrados.nombre',
                'magistrados.correo',
                'magistrados.telefono',
                'tribunal.nombre as nom_tribunal',
                'departamentos.nombre as dep_nombre',
                'ciudades.nombre as ciu_nombre',
            )->join('tribunal', 'tribunal.id', 'magistrados.tribunal_id')
            ->join('departamentos', 'departamentos.id', 'magistrados.dep_id')
            ->join('ciudades', 'ciudades.id', 'tribunal.ciu_id')
            ->get();

        return response()->json([
            'tabla' => $tabla,
            'tribunales' => Tribunal::where('estado', 1)->get(),
            'magistristrados' => Magistrado::where('estado', 1)->get(),
            'departamentos' => Departamentos::where('estado', 1)->get(),
            'ciudades' => Ciudad::where('estado', 1)->get(),
        ]);
    }

    public function filtrar(Request $request)
    {
        $tabla = DB::table('magistrados')
            ->select(
                'magistrados.nombre',
                'magistrados.correo',
                'magistrados.telefono',
                'tribunal.nombre as nom_tribunal',
                'departamentos.nombre as dep_nombre',
                'ciudades.nombre as ciu_nombre',
            )->join('tribunal', 'tribunal.id', 'magistrados.tribunal_id')
            ->join('departamentos', 'departamentos.id', 'magistrados.dep_id')
            ->join('ciudades', 'ciudades.id', 'tribunal.ciu_id')
            ->where(function ($query) use ($request) {
                if (isset($request['tribunal'])) {
                    if (!empty($request['tribunal']))
                        $query->orwhere("magistrados.tribunal_id", $request['tribunal']);
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request['magistrado'])) {
                    if (!empty($request['magistrado']))
                        $query->orwhere("magistrados.id", $request['magistrado']);
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request['departamento'])) {
                    if (!empty($request['departamento']))
                        $query->orwhere("departamentos.id", $request['departamento']);
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request['ciudad'])) {
                    if (!empty($request['ciudad']))
                        $query->orwhere("ciudades.id", $request['ciudad']);
                }
            })
            ->get();

        return response()->json([
            'tabla' => $tabla
        ]);
    }

    public function descargar(Request $request)
    {
        $tabla = Magistrado::where(function ($query) use ($request) {
            if (isset($request['tribunal'])) {
                if (!empty($request['tribunal']))
                    $query->orwhere("magistrados.tribunal_id", $request['tribunal']);
            }
        })
            ->where(function ($query) use ($request) {
                if (isset($request['magistrado'])) {
                    if (!empty($request['magistrado']))
                        $query->orwhere("magistrados.id", $request['magistrado']);
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request['departamento'])) {
                    if (!empty($request['departamento']))
                        $query->orwhere("magistrados.dep_id", $request['departamento']);
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request['ciudad'])) {
                    if (!empty($request['ciudad']))
                        $query->orwhere("magistrados.ciu_id", $request['ciudad']);
                }
            })
            ->get();
        // ->where('dep_id', $request->departamento)
        // ->where('ciu_id', $request->ciudad)
        // ->where('id', $request->magistrado)->get();

        return view('reporte_general')
            ->with('data', $tabla);
    }
}
