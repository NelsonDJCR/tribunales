<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Magistrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MagistradosController extends Controller
{
    public function save()
    {


        // use Illuminate\Support\Facades\Validator;
        $rules = [
            'nombre'=>'required|max:30',
            'id_tipo_identificacion'=>'required|',
            'numero_identificacion'=>'required|max:15',
            'dep_id'=>'required|',
            'ciu_id'=>'required|',
            'direccion'=>'required|max:60',
            'correo'=>'required|',
            'telefono'=>'required|max:10',
            'id_banco'=>'required|',
            'id_tipo_cuenta'=>'required|',
            'numero_cuenta'=>'required|max:30',
        ];
        $messages = [
            'nombre.required'=>'El nombre es requerido',
            'id_tipo_identificacion.required'=>'El tipo de identificación es requerido ',
            'numero_identificacion.required'=>'Es número de identificación es requerido ',
            'numero_identificacion.max'=>'El número de identificación no debe tener más de 15 carácteres',
            'dep_id.required'=>'El departamento es requerido ',
            'ciu_id.required'=>'La ciudad es requerida',
            'direccion.required'=>'La dirección es requerida',
            'direccion.max'=>'La dirección no debe tener más de 60 carácteres',
            'correo.required'=>' El correo es requerido',
            'telefono.required'=>'El teléfono es requerido',
            'telefono.max'=>'El teléfono no debe tener más de 10 carácteres',
            'id_banco.required'=>'El banco es requerido',
            'id_tipo_cuenta.required'=>'El tipo de cuenta es requerido',
            'numero_cuenta.required'=>'El número de cuenta es requerido',
            'numero_cuenta.max'=>'El número de cuenta no debe tener más de 30 carácteres',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        if (Magistrado::insert(request()->all())) {
            return response()->json([
                'code' =>'200',
                'msg' => 'Magistrado guardado correctamente'
            ]);
        }
    }

	public function editar(Request $r)
	{
		 DB::table('magistrados')
              ->where('id', $r->id)
              ->update([
                'nombre' => $r->nombre,
                'id_tipo_identificacion' => $r->id_tipo_identificacion,
                'numero_identificacion' => $r->numero_identificacion,
                'dep_id' => $r->dep_id,
                'ciu_id' => $r->ciu_id,
                'direccion' => $r->direccion,
                'correo' => $r->correo,
                'telefono' => $r->telefono,
                'id_banco' => $r->id_banco,
                'id_tipo_cuenta' => $r->id_tipo_cuenta,
                'numero_cuenta' => $r->numero_cuenta,
                'id_tipo_archivo' => $r->id_tipo_archivo,
               ]);
               return response()->json([
                   'code' =>'200',
                   'msg' => 'Datos actualizados correctamente'
               ]);
	}

	public function filtrar(Request $r)
	{
		$post = $r;


        $x = DB::table('magistrados')->select("magistrados.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
            ->leftjoin("departamentos", "departamentos.id", "magistrados.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "magistrados.ciu_id")

            ->where(function ($query) use ($post) {
                if (isset($post['nombre'])) {
                    if (!empty($post['nombre']))
                        $query->orwhere("magistrados.nombre", 'like', "%" . $post['nombre'] . "%"); 
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['dep_id'])) {
                    if (!empty($post['dep_id']))
                        $query->orwhere("magistrados.dep_id", '=' , $post['dep_id'] );
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['numero_identificacion'])) {
                    if (!empty($post['numero_identificacion']))
                    $query->where("magistrados.numero_identificacion", '=', $post['numero_identificacion']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['telefono'])) {
                    if (!empty($post['telefono']))
                    $query->where("magistrados.telefono",  'like', "%" . $post['telefono'] . "%");
                }
            })
            ->get();
        return response()->json([
            'tabla' => $x
        ]);
	}

	public function misActividades()
	{
        return response()->json([
            'table' => Actividad::where('id_magistrado',Auth::user()->id)
            ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento')
            ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->get()
        ]);
	}

	public function verActividad($id)
	{
		return response()->json([
            'data'=>Actividad::where('id_magistrado',Auth::user()->id)
            ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento')
            ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->where('actividades.id',$id)
            ->first()
        ]);
	}

	public function filtrarMisActividades(Request $r)
	{
        return response()->json([
            'tabla'=>Actividad::where('id_magistrado',Auth::user()->id)
            ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento')
            ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->where(function ($query) use ($r) {
                if (isset($r['tema'])) {
                    if (!empty($r['tema']))
                        $query->orwhere("actividades.tema", 'like', "%" . $r['tema'] . "%");
                }
            })
            ->where(function ($query) use ($r) {
                if (isset($r['fecha_inicial'])) {
                    if (!empty($r['fecha_inicial']))
                        $query->orwhere("actividades.fecha", ">=" , $r['fecha_inicial']);
                }
            })
            ->where(function ($query) use ($r) {
                if (isset($r['fecha_final'])) {
                    if (!empty($r['fecha_final']))
                        $query->orwhere("actividades.fecha", "<=" , $r['fecha_final']);
                }
            })
            ->get()
        ]);
	}


}
