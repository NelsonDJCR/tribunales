<?php

namespace App\Http\Controllers;

use App\Models\Magistrado;
use App\Models\Sorteo;
use App\Models\TipoEleccion;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SorteoController extends Controller
{
    public function listarSorteos()
    {
        $tabla = DB::table('sorteo')
            ->select("sorteo.*", 'magistrados.nombre AS magistrado', 'tribunal.nombre AS tribunal', 'tipo_eleccion.nombre AS tipo_eleccion')
            ->leftjoin("tribunal", "tribunal.id", "sorteo.id_tribunal")
            ->leftjoin("magistrados", "magistrados.id", "sorteo.id_magistrado")
            ->leftjoin("tipo_eleccion", "tipo_eleccion.id", "sorteo.id_tipo_eleccion")
            ->get();
        return response()->json([
            'tabla' => $tabla,
            'tipo_eleccion' => TipoEleccion::all()->where('estado',1),
        ]);
    }
    public function filtroSorteo(Request $r)
    {
        return response()->json([
            'tabla'=>DB::table('sorteo')
            ->select("sorteo.*", 'magistrados.nombre AS magistrado', 'tribunal.nombre AS tribunal', 'tipo_eleccion.nombre AS tipo_eleccion')
            ->leftjoin("tribunal", "tribunal.id", "sorteo.id_tribunal")
            ->leftjoin("magistrados", "magistrados.id", "sorteo.id_magistrado")
            ->leftjoin("tipo_eleccion", "tipo_eleccion.id", "sorteo.id_tipo_eleccion")
            ->where(function ($query) use ($r) {
                if (isset($r['sorteo'])) {
                    if (!empty($r['sorteo']))
                        $query->orwhere("sorteo.nombre", "like", "%".$r['sorteo']."%");
                }
            })
            ->where(function ($query) use ($r) {
                if (isset($r['magistrado'])) {
                    if (!empty($r['magistrado']))
                        $query->orwhere("magistrados.nombre", "like", "%".$r['magistrado']."%");
                }
            })
            ->where(function ($query) use ($r) {
                if (isset($r['tribunal'])) {
                    if (!empty($r['tribunal']))
                        $query->orwhere("tribunal.nombre", "like", "%".$r['tribunal']."%");
                }
            })
            ->where(function ($query) use ($r) {
                if (isset($r['id_tipo_eleccion'])) {
                    if (!empty($r['id_tipo_eleccion']))
                        $query->orwhere("tipo_eleccion.id", "=" , $r['id_tipo_eleccion']);
                }
            })
            ->get()
        ]);
    }

    public function nuevoSorteo(Request $r)
    {

        // use Illuminate\Support\Facades\Validator;
        $rules = [
            'nombre'=>'required|',
            'id_tipo_eleccion'=>'required|',
        ];
        $messages = [
            'nombre.required'=>'El nombre es requerido',
            'id_tipo_eleccion.required'=>'El tipo de elección es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }

     
        $limite_asignados = intval( count(Magistrado::all()->where('estado',1)) / count(Tribunal::all()->where('estado',1)));
        if (count(Magistrado::all()->where('estado',1)->where('asignado',0)) == 0) {
            return response()->json([
                'code' =>407,
                'msg' => 'No hay magistrados para sortear'
            ]);
        }elseif(count(Tribunal::all()->where('estado',1)->where('asignados','<',$limite_asignados)) == 0) {
            $limite_asignados = $limite_asignados + 1;
            $tribunal = Tribunal::all()->where('estado',1)->where('asignados','<',$limite_asignados)->random();
        }
        
        $tribunal = Tribunal::all()->where('estado',1)->where('asignados','<',$limite_asignados)->random();
        $magistrado = Magistrado::all()->where('estado',1)->where('asignado',0)->random();

        $x = Tribunal::find($tribunal->id);
        $x->asignados = $x->asignados + 1;
        $x->save();
        $x = Magistrado::find($magistrado->id);
        $x->asignado = 1;
        $x->save();

        $x = new Sorteo;
        $x->nombre = $r->nombre;
        $x->id_magistrado = $magistrado->id;
        $x->id_tribunal = $tribunal->id;
        $x->id_tipo_eleccion = $r->id_tipo_eleccion;
        $x->fecha = date('Y-m-d');
        if ($x->save()) {
            return response()->json([
                'code' =>200,
                'msg' => 'El sorteo se ha realizado satisfactoriamente'
            ]);
        }

        


    }


}
