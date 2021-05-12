<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Documento;
use App\Models\CabildoAbierto;
use App\Models\CabildoSoporte;
use App\Models\Ciudad;
use Illuminate\Support\Facades\Validator;

class CabildosController extends Controller
{
    public function getIndex()
    {
        return view('sessions.new-sesion');
    }
    public function dataGetIndex()
    {
        $tipoDocumento = TipoDocumento::all();
        return response()->json([
            'tipo' => $tipoDocumento,
            'municipios' => Ciudad::where('estado', 1)->get(),
            'departament' => Departamento::where('estado', 1)->get()
        ]);
    }

    public function save(Request $r)
    {
        
        $rules = [
            'theme' => 'required',
            'description' => 'required',
            'department' => 'required|numeric',
            'municipality' => 'required|numeric',
            'date' => 'required|after:today',
            'radicado_CNE' => 'required',
            'type_file' => 'required|numeric',
        ];
        $messages = [
            'theme.required' => 'El tema es requerido',
            'description.required' => 'La descripción es requerida',
            'department.required' => 'El departamento es requerido',
            'municipality.required' => 'La ciudad es requerida',
            'date.required' => 'La fecha es requerida',
            'date.after' => 'Ingrese una fecha mayor a hoy',
            'radicado_CNE.required' => 'El radicado CNE es requerido',
            'type_file.required' => 'El tipo de documento es requerido',
        ];
        $validator = Validator::make($r->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        } else {
            $e = new CabildoAbierto();
            $e->dep_id = $r->department;
            $e->ciu_id = $r->municipality;
            $e->radicado_CNE = $r->radicado_CNE;
            $e->nombre_tema = $r->theme;
            $e->description = $r->description;
            $e->fecha_realizacion = $r->date;
            if ($e->save()) {
                return response()->json([
                    'msg' => 'Datos guardados correctamente',
                    'code' => 200,
                ]);
            }
            
        }
        




        // if (!isset($r->file)) {
        //     return response()->json([
        //         'msg' => 'Debe ingresar al menos un documento'
        //     ]);
        // }
        
        
        // $type =  $r->type_file;
        // foreach ($r->file as $i) {
        // $path =  $r->file('file')->store('uploads', 'public');
        // $doc = new Documento();
        // $doc->nombre = "x";
        // $doc->ruta = $path;
        // $doc->id_tipo_documento = $type;
        // $doc->save();

        // $x = new CabildoSoporte();
        // $x->id_cabildo = $e->id;
        // $x->id_documento = $doc->id;

        // }
        // if ($x->save()) {
        // return response()->json([
        //     'msg' => 'Datos guardados correctamente',
        //     'code' => 200,
        // ]);
        // }

        
    }

    public function list(Request $r)
    {
        // $post = $r;
        // ->where(function ($query) use ($post) {
        //     if (isset($post['nombre_tema'])) {
        //         if (!empty($post['nombre_tema']))
        //             $query->orwhere('cabildo_abierto.nombre_tema', 'like', "%" . $post['nombre_tema'] . "%");
        //     }
        // })
        // ->where(function ($query) use ($post) {
        //     if (isset($post['dep_id'])) {
        //         if (!empty($post['dep_id']))
        //             $query->orwhere('cabildo_abierto.dep_id', 'like', "%" . $post['dep_id'] . "%");
        //     }
        // })
        // ->where(function ($query) use ($post) {
        //     if (isset($post['fecha_realizacion'])) {
        //         if (!empty($post['fecha_realizacion']))
        //             $query->orwhere('cabildo_abierto.fecha_realizacion', 'like', "%" . $post['fecha_realizacion'] . "%");
        //     }
        // })
        // ->get();
        return view('sessions.list');
    }
    public function filter(Request $r)
    {
        $post = $r;
        $cabildos = CabildoAbierto::select('cabildo_abierto.*', 'departamentos.nombre AS nombre_dep', 'ciudades.nombre AS nombre_ciu')
            ->leftjoin("departamentos", "departamentos.id", "cabildo_abierto.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "cabildo_abierto.ciu_id")
            ->where('cabildo_abierto.estado', 1)

            ->where(function ($query) use ($post) {
                if (isset($post['nombre_tema'])) {
                    if (!empty($post['nombre_tema']))
                        $query->orwhere('cabildo_abierto.nombre_tema', 'like', "%" . $post['nombre_tema'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['dep_id'])) {
                    if (!empty($post['dep_id']))
                        $query->orwhere('cabildo_abierto.dep_id', 'like', "%" . $post['dep_id'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_realizacion'])) {
                    if (!empty($post['fecha_realizacion']))
                    $query->where('cabildo_abierto.fecha_realizacion', '>=', $post['fecha_realizacion']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_end'])) {
                    if (!empty($post['fecha_end']))
                    $query->where('cabildo_abierto.fecha_realizacion', '<=', $post['fecha_end']);
                }
            })
            ->get();
        return response()->json([
            'cabildos' => $cabildos
        ]);
    }
    public function getList()
    {
        $cabildos = CabildoAbierto::select('cabildo_abierto.*', 'departamentos.nombre AS nombre_dep', 'ciudades.nombre AS nombre_ciu')
            ->leftjoin("departamentos", "departamentos.id", "cabildo_abierto.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "cabildo_abierto.ciu_id")
            ->where('cabildo_abierto.estado', 1)
            ->get();
        return response()->json([
            // 'municipios' =>  Ciudad::all(),
            'departments' =>  Departamento::all(),
            'cabildos' =>  $cabildos
        ]);
    }

    public function edit($id)
    {
        // $documents = Documento::select('documento.*')
        //     ->leftjoin("cabildo_soporte", "cabildo_soporte.id_documento", "documento.id")
        //     ->where('cabildo_soporte.id_cabildo', $id)
        //     ->where('documento.estado', 1)
        //     ->get();

        // $type_document = Documento::select('documento.id_tipo_documento', 'tipo_documento.nombre')
        //     ->leftjoin("cabildo_soporte", "cabildo_soporte.id_documento", "documento.id")
        //     ->leftjoin("tipo_documento", "tipo_documento.id", "documento.id_tipo_documento")
        //     ->where('cabildo_soporte.id_cabildo', $id)
        //     ->where('documento.estado', 1)
        //     ->first();

        // return view('sessions.edit-sesion')
        // ->with('type_file', TipoDocumento::all())
        // ->with('municipios', Ciudad::all())
        // ->with('documents', $documents)
        // ->with('type_document', $type_document)
        // ->with('departament', Departamento::all())
        // ->with('data', CabildoAbierto::find($id));

        



        return response()->json([
            'type_file' => TipoDocumento::all(),
            'ciudades' => Ciudad::all(),
            'departament' => Departamento::all(),
            'datos' => CabildoAbierto::find($id)
        ]);
    }

    public function editDocument(Request $r)
    {
        $e = Documento::find($r->id);
        $e->estado = 3;
        $e->save();
    }

    public function editSesion(Request $r)
    {
        $rules = [
            'nombre_tema' => 'required',
            'description' => 'required',
            'dep_id' => 'required|numeric',
            'ciu_id' => 'required|numeric',
            'fecha_realizacion' => 'required|after:today',
            'radicado_CNE' => 'required',
            // 'type_file' => 'required|numeric',
        ];
        $messages = [
            'nombre_tema.required' => 'El tema es requerido',
            'description.required' => 'La descripción es requerida',
            'dep_id.required' => 'El departamento es requerido',
            'ciu_id.required' => 'La ciudad es requerida',
            'fecha_realizacion.required' => 'La fecha es requerida',
            'fecha_realizacion.after' => 'Ingrese una fecha mayor a hoy',
            'radicado_CNE.required' => 'El radicado CNE es requerido',
            // 'type_file.required' => 'El tipo de documento es requerido',
        ];
        $validator = Validator::make($r->all(), $rules, $messages);
        // $validator = Validator::make($r->all(), $rules, $messages);
        // return request()->all();

        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        } else {

            $e = CabildoAbierto::find($r->id);
            $e->dep_id = $r->dep_id;
            $e->ciu_id = $r->ciu_id;
            $e->radicado_CNE = $r->radicado_CNE;
            $e->nombre_tema = $r->nombre_tema;
            $e->description = $r->description ;
            $e->fecha_realizacion = $r->fecha_realizacion;
            if ($e->save()) {
                $table =CabildoAbierto::select('cabildo_abierto.*', 'departamentos.nombre AS nombre_dep', 'ciudades.nombre AS nombre_ciu')
                ->leftjoin("departamentos", "departamentos.id", "cabildo_abierto.dep_id")
                ->leftjoin("ciudades", "ciudades.id", "cabildo_abierto.ciu_id")
                ->where('cabildo_abierto.estado', 1)
                ->get();
                return response()->json([
                    'msg' => 'Datos guardados correctamente',
                    'status' => 200,
                    'table' => $table
                ]);
            }
            
        }



        
        
        // $type =  $r->type_file;
        // $record = $r->id_record;

        // if (isset($r->file)) {
        //     foreach ($r->file as $i) {
        //         $path =  $i->store('uploads', 'public');
        //         $doc = new Documento();
        //         $doc->nombre = $i->getClientOriginalName();
        //         $doc->ruta = $path;
        //         $doc->id_tipo_documento = $type;
        //         $doc->save();

        //         $x = new CabildoSoporte();
        //         $x->id_cabildo = $e->id;
        //         $x->id_documento = $doc->id;
        //         $x->save();
        //     }
        // }
        // if ($validator->fails()) {
        // return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        // } else {
        // }
    }

    public function deleteSesion($id)
    {

        $e = CabildoAbierto::find($id);
        $e->estado = 0;
        $e->save();
        $cabildos = CabildoAbierto::select('cabildo_abierto.*', 'departamentos.nombre AS nombre_dep', 'ciudades.nombre AS nombre_ciu')
            ->leftjoin("departamentos", "departamentos.id", "cabildo_abierto.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "cabildo_abierto.ciu_id")
            ->where('cabildo_abierto.estado', 1)
            ->get();
        return response()->json([
            'cabildos' => $cabildos
        ]);
    }

    public function viewDocuments(Request $r)
    {
        $documents = Documento::select('documento.*')
            ->leftjoin("cabildo_soporte", "cabildo_soporte.id_documento", "documento.id")
            ->where('cabildo_soporte.id_cabildo', $r->id)
            ->where('documento.estado', 1)
            ->get();

        return response()->json([
            'data' => $documents
        ]);
    }

    public function downloadFile($file)
    {
        return response()->download(storage_path("app/public/uploads/$file"));
    }

    public function reportSessions(Request $r)
    {

        $post = $r;
        $cabildo = CabildoAbierto::where('estado', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['nombre_tema'])) {
                    if (!empty($post['nombre_tema']))
                        $query->orwhere('cabildo_abierto.nombre_tema', 'like', "%" . $post['nombre_tema'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['dep_id'])) {
                    if (!empty($post['dep_id']))
                        $query->orwhere('cabildo_abierto.dep_id', 'like', "%" . $post['dep_id'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['mun_id'])) {
                    if (!empty($post['mun_id']))
                        $query->orwhere('cabildo_abierto.mun_id', 'like', "%" . $post['mun_id'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_realizacion'])) {
                    if (!empty($post['fecha_realizacion']))
                        $query->orwhere('cabildo_abierto.fecha_realizacion', 'like', "%" . $post['fecha_realizacion'] . "%");
                }
            })
            ->get();
        return view('sessions.report')
            ->with('departments', Departamento::all())
            ->with('municipios', Ciudad::all())
            ->with('cabildos', $cabildo)
            ->with('post', $r);
    }

	public function changeCity(Request $r)
	{
		return Ciudad::where('id_departamento',$r->id)->get();
	}
}
