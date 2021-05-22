<?php

namespace App\Http\Controllers;

use App\Models\Magistrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MagistradosController extends Controller
{
    public function save()
    {
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
                        $query->orwhere("magistrados.dep_id", 'like', "%" . $post['dep_id'] . "%");
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
}
