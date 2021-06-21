<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Models\Magistrado;
use App\Models\PersonaCentralizado;
use App\Models\Sorteo;
use App\Models\SorteoDepartamento;
use App\Models\TipoEleccion;
use App\Models\Tribunal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class SorteoController extends Controller
{
    public function listarSorteos()
    {

        $tabla = DB::table('sorteo')
            ->select('sorteo.*', 'tipo_eleccion.nombre as nom_eleccion')
            ->join('tipo_eleccion', 'tipo_eleccion.id', 'sorteo.id_tipo_eleccion')
            ->orderByDesc('sorteo.id')
            ->get();

        // $tabla = DB::table('sorteo')
        //     ->select("sorteo.*", 'magistrados.nombre AS magistrado', 'tribunal.nombre AS tribunal', 'tipo_eleccion.nombre AS tipo_eleccion')
        //     ->leftjoin("tribunal", "tribunal.id", "sorteo.id_tribunal")
        //     ->leftjoin("magistrados", "magistrados.id", "sorteo.id_magistrado")
        //     ->leftjoin("tipo_eleccion", "tipo_eleccion.id", "sorteo.id_tipo_eleccion")
        //     ->get();
        return response()->json([
            'tabla' => $tabla,
            'tipo_eleccion' => TipoEleccion::all()->where('estado', 1),
            'usuarios' => PersonaCentralizado::all(),
        ]);
    }
    public function filtroSorteo(Request $r)
    {
        // return $r->all();
        return response()->json([
            'tabla' => DB::table('sorteo')
                ->select("sorteo.*", 'tipo_eleccion.nombre AS nom_eleccion')
                ->join("tipo_eleccion", "tipo_eleccion.id", "sorteo.id_tipo_eleccion")
                ->where(function ($query) use ($r) {
                    if (isset($r['sorteo'])) {
                        if (!empty($r['sorteo']))
                            $query->orwhere("sorteo.nombre", "like", "%" . $r['sorteo'] . "%");
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['fecha_inicio'])) {
                        if (!empty($r['fecha_inicio']))
                            $query->orwhere("sorteo.fecha", '>', $r['fecha_inicio']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['fecha_fin'])) {
                        if (!empty($r['fecha_fin']))
                            $query->orwhere("sorteo.fecha", '<', $r['fecha_fin']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['id_tipo_eleccion'])) {
                        if (!empty($r['id_tipo_eleccion']))
                            $query->orwhere("tipo_eleccion.id", "=", $r['id_tipo_eleccion']);
                    }
                })
                ->get()
        ]);
    }

    public function nuevoSorteo(Request $r)
    {
        $rules = [
            'nombre' => 'required|',
            'id_tipo_eleccion' => 'required|',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'id_tipo_eleccion.required' => 'El tipo de elección es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }

        $limite_asignados = intval(count(Magistrado::all()->where('estado', 1)->where('cargo', 'Magistrado')) / count(Tribunal::all()->where('estado', 1)));
        if (count(Magistrado::all()->where('estado', 1)->where('asignado', 0)->where('cargo', 'Magistrado')) == 0) {
            return response()->json([
                'code' => 407,
                'msg' => 'No hay magistrados para sortear'
            ]);
        } elseif (count(Tribunal::all()->where('estado', 1)->where('asignados', '<', $limite_asignados)) == 0) {
            $limite_asignados = $limite_asignados + 1;
            $tribunal = Tribunal::all()->where('estado', 1)->where('asignados', '<', $limite_asignados)->random();
        }
        $sorteo =  count(Magistrado::all()->where('estado', 1)->where('asignado', 0)->where('cargo', 'Magistrado'));
        for ($i = 0; $i < $sorteo; $i++) {
            $tribunal = Tribunal::all()->where('estado', 1)->where('asignados', '<', $limite_asignados)->random();
            $magistrado = Magistrado::all()->where('estado', 1)->where('asignado', 0)->where('cargo', 'Magistrado')->random();
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
            $x->save();
        }
        return response()->json([
            'code' => 200,
            'msg' => 'El sorteo se ha realizado satisfactoriamente'
        ]);
    }

    public function departamentos_sorteo()
    {
        $departamentos = Departamentos::where('estado', '1')->get();
        $tipo_eleccion = TipoEleccion::where('estado', '1')->get();
        return response()->json([
            'departamentos' => $departamentos,
            'tipo_eleccion' => $tipo_eleccion,
        ]);
    }


    public function sortear(Request $request)
    {
        // return $request->all();
        // $num = 0;
        // for ($i=0; $i < $request->cantidad; $i++) {

        // }

        $rules = [
            'nombre' => 'required|max:255',
            'id_tipo_eleccion' => 'required|integer',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre debe tener máximo 255 caracteres',
            'id_tipo_eleccion.required' => 'El tipo de elección es requerido',
            'id_tipo_eleccion.integer' => 'Usa la lista de tipo de elección',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return response()->json([
                'status' => 406,
                'msg' => $validator->errors()->first(),
            ]);
        endif;

        $sor = new Sorteo();
        $sor->nombre = $request->nombre;
        $sor->id_tipo_eleccion = $request->id_tipo_eleccion;
        $sor->usuario = Auth::user()->id_persona;
        $sor->fecha = date('Y-m-d');
        $sor->save();

        $departamentos = [];
        $cantidad = [];
        for ($x = 0; $x < $request->cantidad; $x++) {
            $departamentos[$x] = $request["dep$x"];
            $cantidad[$x] = $request["cant$x"];
        }

        $magistrados = Magistrado::where('estado', 1)->where('cargo', 'Magistrado')->get();
        $asignados = [];
        $copia_asignados = [];
        for ($i = 0; $i < sizeof($magistrados); $i++) {
            $asignados[$i] = $i;
        }



        $copia_asignados = $asignados;
        for ($x = 0; $x < sizeof($cantidad); $x++) {
            $dep_id = $departamentos[$x];
            $asignados = $copia_asignados;
            // return $asignados;
            for ($z = 0; $z < $cantidad[$x]; $z++) {
                $numero = array_rand($asignados, 1);
                unset($asignados[$numero]);
                $mag_id = $magistrados[$numero]->id;
                $sorteo = new SorteoDepartamento();
                $sorteo->departamentos_id = $dep_id;
                $sorteo->magistrado_id = $mag_id;
                $sorteo->sorteo_id = $sor->id;
                $sorteo->estado = 1;
                $sorteo->save();
            }
        }

        return response()->json([
            'status' => 200,
            'msg' => 'El sorteo fue un éxito',
        ]);
    }

    public function update(Request $request){
        // return $request->all();
        // return sizeof($request->all());
        $data = $request->all();
        for ($x=0; $x < sizeof($request->all()); $x++) {
            // return $data[$x];
            if(!empty($data[$x]['e_id'])){
                // return '1';
                $id = $data[$x]['e_id'];
                // return '1 --> '.$id;
                $sorteo = SorteoDepartamento::find($id);
                $sorteo->estado = 0;
                $sorteo->save();
            }
            if(!empty($data[$x]['n_id'])):
                $sorteo = new SorteoDepartamento();
                $sorteo->departamentos_id = $data[$x]['dep_id'];
                $sorteo->magistrado_id = $data[$x]['mag_id'];
                $sorteo->sorteo_id = $data[$x]['sorteo_id'];
                $sorteo->estado = 1;
                $sorteo->save();
            endif;

        }
        return response()->json([
            'status' => 200,
            'msg' => 'Datos editados con éxito',
        ]);
    }

    public function show($id)
    {
        $sorteo = DB::table('sorteo_departamentos')
            ->select(
                'sorteo_departamentos.*',
                'departamentos.nombre as dep_nombre',
                'magistrados.nombre as mag_nombre',
                'magistrados.id as mag_id',
                'departamentos.id as dep_id',
                // 'sorteo_departamentos.estado'
                // DB::raw("count('sorteo_departamentos.magistrado_id') as cantidad")
            )
            ->join('departamentos', 'departamentos.id', 'sorteo_departamentos.departamentos_id')
            ->join('magistrados', 'magistrados.id', 'sorteo_departamentos.magistrado_id')
            ->where('sorteo_id', $id)
            ->groupBy('mag_id')
            ->get();

        $sor = Sorteo::find($id);

        $eleccion = Sorteo::find($id)->eleccion;
        // return $eleccion;

        return response()->json([
            'sorteo' => $sorteo,
            'sor' => $sor,
            'eleccion' => $eleccion,
            'magistrados' => Magistrado::where('estado', 1)->get(),
        ]);
    }
}
