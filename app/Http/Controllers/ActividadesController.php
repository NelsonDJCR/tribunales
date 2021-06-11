<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\ActividadSoporte;
use App\Models\Documento;
use App\Models\Magistrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
    public function save(Request $request)
    {
        // return $request->all();
        $data =  request()->all();
        if (isset($data['id_magistrado'])) {
            $data['id_magistrado'] = $data['id_magistrado'];
        }else {
            $data['id_magistrado'] = Auth::user()->id;
        }
        $rules = [
            'fecha'=>'required|after:today',
            'tema'=>'required|',
            'descripcion'=>'required|',
            'dep_id'=>'required|',
            'ciu_id'=>'required|',
            'tribunal_id'=>'required|',
        ];
        $messages = [
            'fecha.required'=>'La fecha es requerida',
            'fecha.after'=>'La fecha debe ser mayor a hoy',
            'tema.required'=>'El tema es requerido',
            'descripcion.required'=>'La descripción es requerida',
            'dep_id.required'=>'El departamento es requerido',
            'ciu_id.required'=>'La ciudad es requerida',
            'id_magistrado.required'=>'El magistrado es requerido',
            'tribunal_id.required'=>'El tribunal es requerido',
        ];

        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }
        $actividad = new Actividad();
        $actividad->fecha = $request->fecha;
        $actividad->tema = $request->tema;
        $actividad->descripcion = $request->descripcion;
        $actividad->dep_id = $request->dep_id;
        $actividad->ciu_id = $request->ciu_id;
        $actividad->id_magistrado = $request->id_magistrado;
        $actividad->estado = 1;
        $actividad->save();

        for ($x=0; $x < $request->cantidad; $x++) {

            if($request->hasFile("archivo$x")):
                $file = $request->file("archivo$x");
                $fileName = time().'_'.$file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/'.$fileName;
                $documento->save();

                $soporte = new ActividadSoporte();
                $soporte->id_actividad = $actividad->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'),$fileName);
            endif;
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Actividad registrada con éxito',
        ]);
    }

	public function editar(Request $r)
	{
        $rules = [
            'fecha'=>'required|after:today',
            'tema'=>'required|',
            'descripcion'=>'required|',
            'dep_id'=>'required|',
            'ciu_id'=>'required|',
            'id_magistrado'=>'required|',
        ];
        $messages = [
            'fecha.required'=>'La fecha es requerida',
            'fecha.after'=>'La fecha debe ser mayor a hoy',
            'tema.required'=>'El tema es requerido',
            'descripcion.required'=>'La descripción es requerida',
            'dep_id.required'=>'El departamento es requerido',
            'ciu_id.required'=>'La ciudad es requerida',
            'id_magistrado.required'=>'El magistrado es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }


        $x = Actividad::find($r->id);
        $x->fecha = $r->fecha;
        $x->tema = $r->tema;
        $x->descripcion = $r->descripcion;
        $x->dep_id = $r->dep_id;
        $x->ciu_id = $r->ciu_id;
        $x->id_magistrado = $r->id_magistrado;
        $x->id_tipo_archivo = $r->id_tipo_archivo;
        if ($x->save()){
            return response()->json([
                'code' =>'200',
                'msg' => 'Datos actualizados correctamente'
            ]);
        }
	}

	public function filtrar(Request $r)
	{
		$post = $r;
        $x = DB::table('actividades')->select("actividades.*", 'departamentos.nombre AS departamento', 'magistrados.nombre AS magistrado', 'ciudades.nombre AS ciudad')
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->join("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->where(function ($query) use ($post) {
                if (isset($post['tema'])) {
                    if (!empty($post['tema']))
                        $query->orwhere("actividades.tema", 'like', "%" . $post['tema'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['magistrado'])) {
                    if (!empty($post['magistrado']))
                        $query->orwhere("magistrados.nombre", 'like', "%" . $post['magistrado'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_inicial'])) {
                    if (!empty($post['fecha_inicial']))
                    $query->where("actividades.fecha", '>=', $post['fecha_inicial']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_final'])) {
                    if (!empty($post['fecha_final']))
                    $query->where("actividades.fecha",   '<=',  $post['fecha_final']);
                }
            })
            ->orderBy('actividades.id','DESC')
            ->get();
        return response()->json([
            'tabla' => $x
        ]);
	}
	public function reporteExcel(Request $r)
	{
		$post = $r;
        $x = DB::table('actividades')->select("actividades.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad', 'magistrados.nombre AS magistrado')
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->join("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->where(function ($query) use ($post) {
                if (isset($post['tema'])) {
                    if (!empty($post['tema']))
                        $query->orwhere("actividades.tema", 'like', "%" . $post['tema'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['magistrado'])) {
                    if (!empty($post['magistrado']))
                    $query->orwhere("magistrados.nombre", 'like', "%" . $post['magistrado'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_inicial'])) {
                    if (!empty($post['fecha_inicial']))
                    $query->where("actividades.fecha", '>=', $post['fecha_inicial']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_final'])) {
                    if (!empty($post['fecha_final']))
                    $query->where("actividades.fecha",   '<=',  $post['fecha_final']);
                }
            })
            ->get();
            return view('sessions.report')
            ->with('data', $x);
	}
}
