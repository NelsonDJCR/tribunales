<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Ciudad;
use App\Models\Departamentos;
use App\Models\Documento;
use App\Models\Magistrado;
use App\Models\MagistradoSoporte;
use App\Models\TipoActividad;
use App\Models\TipoArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MagistradosController extends Controller
{
    public function save(Request $request)
    {
        // return $request->all();
        // use Illuminate\Support\Facades\Validator;
        $rules = [
            'nombre' => 'required|max:30',
            'id_tipo_identificacion' => 'required|',
            'cargo' => 'required|',
            'numero_identificacion' => 'required|max:15',
            'dep_id' => 'required|',
            'ciu_id' => 'required|',
            'direccion' => 'required|max:60',
            'correo' => 'required|email',
            'telefono' => 'required|max:10',
            'id_banco' => 'required|',
            'id_tipo_cuenta' => 'required|',
            'numero_cuenta' => 'required|max:30',
            'tribunal_id' => 'required|integer',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'id_tipo_identificacion.required' => 'El tipo de identificación es requerido ',
            'cargo.required' => 'El cargo es requerido ',
            'numero_identificacion.required' => 'Es número de identificación es requerido ',
            'numero_identificacion.max' => 'El número de identificación no debe tener más de 15 carácteres',
            'dep_id.required' => 'El departamento es requerido ',
            'ciu_id.required' => 'La ciudad es requerida',
            'direccion.required' => 'La dirección es requerida',
            'direccion.max' => 'La dirección no debe tener más de 60 carácteres',
            'correo.required' => ' El correo es requerido',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.max' => 'El teléfono no debe tener más de 10 carácteres',
            'id_banco.required' => 'El banco es requerido',
            'id_tipo_cuenta.required' => 'El tipo de cuenta es requerido',
            'numero_cuenta.required' => 'El número de cuenta es requerido',
            'numero_cuenta.max' => 'El número de cuenta no debe tener más de 30 carácteres',
            'correo.email' => 'Verifica el formato de tu correo electrónico',
            'tribunal_id.required' => 'El campo tribunal es requerido',
            'tribunal_id.integer' => 'El campo tribunal debe ser númerico',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }

        $magistrado = new Magistrado();
        $magistrado->cargo = $request->cargo;
        $magistrado->ciu_id = $request->ciu_id;
        $magistrado->correo = $request->correo;
        $magistrado->dep_id = $request->dep_id;
        $magistrado->direccion = $request->direccion;
        $magistrado->id_banco = $request->id_banco;
        $magistrado->id_tipo_cuenta = $request->id_tipo_cuenta;
        $magistrado->id_tipo_identificacion = $request->id_tipo_identificacion;
        $magistrado->nombre = $request->nombre;
        $magistrado->numero_cuenta = $request->numero_cuenta;
        $magistrado->numero_identificacion = $request->numero_identificacion;
        $magistrado->telefono = $request->telefono;
        // Especial
        $magistrado->tribunal_id = $request->tribunal_id;
        // Fin especial
        $magistrado->save();

        for ($x = 0; $x < $request->cantidad; $x++) {
            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->estado = 1;
                $documento->save();

                $soporte = new MagistradoSoporte();
                $soporte->id_magistrado = $magistrado->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();
                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }

        return response()->json([
            'status' => '200',
            'msg' => 'Magistrado guardado correctamente'
        ]);

        // if (Magistrado::insert(request()->all())) {
        //     return response()->json([
        //         'status' =>'200',
        //         'msg' => 'Magistrado guardado correctamente'
        //     ]);
        // }
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
            'nombre' => 'required|max:30',
            'id_tipo_identificacion' => 'required|',
            'cargo' => 'required|',
            'numero_identificacion' => 'required|max:15',
            'dep_id' => 'required|',
            'ciu_id' => 'required|',
            'direccion' => 'required|max:60',
            'correo' => 'required|',
            'telefono' => 'required|max:10',
            'id_banco' => 'required|',
            'id_tipo_cuenta' => 'required|',
            'numero_cuenta' => 'required|max:30',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'id_tipo_identificacion.required' => 'El tipo de identificación es requerido ',
            'cargo.required' => 'El cargo es requerido ',
            'numero_identificacion.required' => 'Es número de identificación es requerido ',
            'numero_identificacion.max' => 'El número de identificación no debe tener más de 15 carácteres',
            'dep_id.required' => 'El departamento es requerido ',
            'ciu_id.required' => 'La ciudad es requerida',
            'direccion.required' => 'La dirección es requerida',
            'direccion.max' => 'La dirección no debe tener más de 60 carácteres',
            'correo.required' => ' El correo es requerido',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.max' => 'El teléfono no debe tener más de 10 carácteres',
            'id_banco.required' => 'El banco es requerido',
            'id_tipo_cuenta.required' => 'El tipo de cuenta es requerido',
            'numero_cuenta.required' => 'El número de cuenta es requerido',
            'numero_cuenta.max' => 'El número de cuenta no debe tener más de 30 carácteres',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }
        // return $request->all();
        $magistrado = Magistrado::find($request->id);
        // $magistrado->cargo = $request->cargo;
        $magistrado->ciu_id = $request->ciu_id;
        $magistrado->correo = $request->correo;
        $magistrado->dep_id = $request->dep_id;
        $magistrado->direccion = $request->direccion;
        $magistrado->id_banco = $request->id_banco;
        $magistrado->id_tipo_cuenta = $request->id_tipo_cuenta;
        $magistrado->id_tipo_identificacion = $request->id_tipo_identificacion;
        $magistrado->nombre = $request->nombre;
        $magistrado->numero_cuenta = $request->numero_cuenta;
        $magistrado->numero_identificacion = $request->numero_identificacion;
        $magistrado->telefono = $request->telefono;
        // Especial
        $magistrado->tribunal_id = $request->tribunal_id;
        // Fin especial
        $magistrado->save();


        for ($x = 0; $x < $request->cantidad; $x++) {
            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->estado = 1;
                $documento->save();

                $soporte = new MagistradoSoporte();
                $soporte->id_magistrado = $magistrado->id;
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
                        $query->orwhere("magistrados.dep_id", '=', $post['dep_id']);
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
            ->orderBy('magistrados.id', 'DESC')
            ->get();
        return response()->json([
            'tabla' => $x
        ]);
    }

    public function misActividades()
    {
        $actividades = Actividad::where('id_magistrado', Auth::user()->id)
            ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento', 'tipo_actividad.nombre as tipo_nombre')
            ->join('tipo_actividad', 'tipo_actividad.id', 'actividades.id_tipo_actividad')
            ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
            ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
            ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
            ->orderBy('actividades.id','DESC')
            ->get();
        return response()->json([
            'table' => $actividades,
            'maximo' => $actividades->max("fecha"),
            'minimo' => $actividades->min('fecha'),
            'actividades' => TipoActividad::where('estado',1)->get(),
            'departamentos' => Departamentos::where('estado',1)->get(),
            'ciudades' => Ciudad::where('estado',1)->get(),
        ]);
    }

    public function verActividad($id)
    {
        $documentos = DB::table('actividades_soporte')
            ->select(
                'documento.*',
            )->join('documento', 'documento.id', 'actividades_soporte.id_documento')
            ->where('documento.estado', '1')
            ->where('actividades_soporte.id_actividad', $id)
            ->get();
        return response()->json([
            'documentos' => $documentos,
            'tipo_archivo' => TipoArchivo::where('estado', 1)->get(),
            'data' => Actividad::where('id_magistrado', Auth::user()->id)
                ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento')
                ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
                ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
                ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
                ->where('actividades.id', $id)
                ->first()
        ]);
    }

    public function filtrarMisActividades(Request $r)
    {
        // return $r->all();
        return response()->json([
            'tabla' => Actividad::where('id_magistrado', Auth::user()->id)
                ->select('actividades.*', 'ciudades.nombre AS ciudad', 'departamentos.nombre AS departamento', 'tipo_actividad.nombre as tipo_nombre')
                ->join('tipo_actividad', 'tipo_actividad.id', 'actividades.id_tipo_actividad')
                ->leftjoin("magistrados", "magistrados.id", "actividades.id_magistrado")
                ->leftjoin("ciudades", "ciudades.id", "actividades.ciu_id")
                ->leftjoin("departamentos", "departamentos.id", "actividades.dep_id")
                ->orderBy('actividades.id','DESC')
                ->where(function ($query) use ($r) {
                    if (isset($r['tema'])) {
                        if (!empty($r['tema']))
                            $query->orwhere("actividades.tema", 'like', "%" . $r['tema'] . "%");
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['fecha_inicial'])) {
                        if (!empty($r['fecha_inicial']))
                            $query->orwhere("actividades.fecha", ">=", $r['fecha_inicial']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['fecha_final'])) {
                        if (!empty($r['fecha_final']))
                            $query->orwhere("actividades.fecha", "<=", $r['fecha_final']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['id_tipo_actividad'])) {
                        if (!empty($r['id_tipo_actividad']))
                            $query->orwhere("actividades.id_tipo_actividad", $r['id_tipo_actividad']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['dep_id'])) {
                        if (!empty($r['dep_id']))
                            $query->orwhere("actividades.dep_id", $r['dep_id']);
                    }
                })
                ->where(function ($query) use ($r) {
                    if (isset($r['ciu_id'])) {
                        if (!empty($r['ciu_id']))
                            $query->orwhere("actividades.ciu_id", $r['ciu_id']);
                    }
                })
                ->get()
        ]);
    }
}
