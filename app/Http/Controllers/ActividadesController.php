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
        } else {
            $data['id_magistrado'] = Auth::user()->id;
        }
        $rules = [
            'fecha' => 'required',
            'tema' => 'required|',
            'descripcion' => 'required|',
            'dep_id' => 'required|',
            'ciu_id' => 'required|',
            'tribunal_id' => 'required|',
            'id_tipo_actividad' => 'required|integer',
        ];
        $messages = [
            'fecha.required' => 'La fecha es requerida',
            // 'fecha.after' => 'La fecha debe ser mayor a hoy',
            'tema.required' => 'El tema es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'dep_id.required' => 'El departamento es requerido',
            'ciu_id.required' => 'La ciudad es requerida',
            'id_magistrado.required' => 'El magistrado es requerido',
            'tribunal_id.required' => 'El tribunal es requerido',
            'id_tipo_actividad.required' => 'El tipo de actividad es requerido',
            'id_tipo_actividad.integer' => 'El tipo de actividad debe ser numérico',
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
        $actividad->id_tipo_actividad = $request->id_tipo_actividad;
        $actividad->estado = 1;
        $actividad->save();

        for ($x = 0; $x < $request->cantidad; $x++) {

            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->save();

                $soporte = new ActividadSoporte();
                $soporte->id_actividad = $actividad->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Actividad registrada con éxito',
        ]);
    }

    public function editar(Request $request)
    {

        // return $request->all();

        for ($x = 0; $x < $request->cantidad_eliminados; $x++) {
            $documento = Documento::find($request["e_id$x"]);
            $documento->estado = '0';
            $documento->save();
        }

        // return '1';

        $rules = [
            'fecha' => 'required',
            'tema' => 'required|',
            'descripcion' => 'required|',
            'dep_id' => 'required|',
            'ciu_id' => 'required|',
            'id_magistrado' => 'required|',
        ];
        $messages = [
            'fecha.required' => 'La fecha es requerida',
            // 'fecha.after' => 'La fecha debe ser mayor a hoy',
            'tema.required' => 'El tema es requerido',
            'descripcion.required' => 'La descripción es requerida',
            'dep_id.required' => 'El departamento es requerido',
            'ciu_id.required' => 'La ciudad es requerida',
            'id_magistrado.required' => 'El magistrado es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }

        $actividad = Actividad::find($request->id);
        $actividad->fecha = $request->fecha;
        $actividad->tema = $request->tema;
        $actividad->descripcion = $request->descripcion;
        $actividad->dep_id = $request->dep_id;
        $actividad->ciu_id = $request->ciu_id;
        $actividad->id_magistrado = $request->id_magistrado;
        $actividad->id_tipo_archivo = $request->id_tipo_archivo;
        $actividad->id_tipo_actividad = $request->id_tipo_actividad;
        $actividad->save();

        for ($x = 0; $x < $request->cantidad; $x++) {

            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->save();

                $soporte = new ActividadSoporte();
                $soporte->id_actividad = $actividad->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }

        return response()->json([
            'status' => '200',
            'msg' => 'Datos actualizados correctamente'
        ]);
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
            ->orderBy('actividades.id', 'DESC')
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

    public function magistradosxtribunal($id)
    {
        $magistrados = Magistrado::where('estado',1)->where('tribunal_id',$id)->get();
        return response()->json([
            'funcionarios' => $magistrados,
        ]);
    }
}
