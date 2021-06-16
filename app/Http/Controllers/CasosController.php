<?php

namespace App\Http\Controllers;

use App\Http\Requests\CasoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Caso;
use App\Models\CasoSeguimiento;
use App\Models\Ciudad;
use App\Models\Ciudades;
use App\Models\Departamentos;
use App\Models\Documento;
use App\Models\Estado;
use App\Models\Magistrado;
use App\Models\MedioRecepcion;
use App\Models\PersonaCentralizado;
use App\Models\Prioridad;
use App\Models\Soporte;
use App\Models\TipoArchivo;
use App\Models\TipoEleccion;
use App\Models\TipoIdentificacion;
use App\Models\TipoTramite;
use App\Models\Tribunal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\ValidationException;
//use Validator;
////use Illuminate\Support\Facades\DB;
//use Log;

class CasosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;

        if ($buscar !== null && $buscar !== 0) {

            $casos = new Caso();
            $buscarFiltro = array();

            if($request->tramite_id){
                $buscarFiltro['id_tramite'] = $request->tramite_id;
            }
            if($request->fecha_recibido){
                $buscarFiltro['fecha_recibido'] = $request->fecha_recibido;
            }
            if($request->departamento_id){
                $buscarFiltro['id_departamento'] = $request->departamento_id;
            }
            if($request->estado_id){
                $buscarFiltro['id_estado'] = $request->estado_id;
            }

            //$casos = Caso::with('caso')->orderBy('id', 'desc')->paginate(10);
            //Log::info($casos);
            //$buscarFiltro = ['id_tramite','fecha_recibido','id_departamento', 'id_estado'];
            //$filtro = [ $request->tramite_id, $request->fecha_recibido, $request->departamento_id, $request->estado_id ];

            $casos = $casos->searchListOfCasos($buscarFiltro);

            // $casos = Caso::join('casos_seguimientos', 'casos_seguimientos.id_caso','=','casos.id')
            // ->select('casos.*','casos_seguimientos.id_caso')
            // ->where('casos.id_departamento', 'departamentos.id')
            // ->orderBy('id', 'desc')->paginate(10);
            // var_dump("sin buscando");
            // print_r($buscar);

        }else{
            $imMagister = false; //TODO set with user rol
            $casos = new Caso();

            /*::::::::::::::::::TODO Validate MAGISTRADOs USERs*/

            if($imMagister == true ){

                    /*::::::::::::::::::TODO get user id*/
                    //$condicion = Auth::user()->can($permiso['permiso']);
                    //$condicion = true;
                    $idUser = 2;
                    $casos = $casos->getListOfCasos($idUser);

                }else if( /*Session('conexion') != 'centralizado' &&*/ Auth::user()->super_administrador == 1/* or $centralizado*/ ){

                    $casos = $casos->getListOfCasos();
            };
        };

        return response()->json([
            'pagination' => [
                'total'        => $casos->total(),
                'current_page' => $casos->currentPage(),
                'per_page'     => $casos->perPage(),
                'last_page'    => $casos->lastPage(),
                'from'         => $casos->firstItem(),
                'to'           => $casos->lastItem(),
            ],
            'casos' => $casos,
            'departamentos' => Departamentos::all()->where('estado',1),
            'ciudades'=> Ciudades::all()->where('estado',1),
            'estado' => Estado::all()->where('estado',1),
            'status' => 200,
            'success'=> true
        ]);

        /*$casos->map(function($caso) {
            $data = collect($caso);
            //$data->put('owner', $caso->user);
            return $data->all();
        });*/

        // $result = array('success'=>true,'casos'=>$casos);
        // return Response()->json($result);
    }

    public function listadoCasoData()
    {
        $casos = $this->tabla();
        $tramite = TipoTramite::all();
        $usuarios = PersonaCentralizado::where('estado', 1)->get();
        $departamento = Departamentos::all();
        $estado = Estado::all();
        $tipoArchivo = TipoArchivo::all();
        $tribunales = Tribunal::where('estado',1)->get();
        $estado1 = Estado::where('estado', 1)
            ->where('id', '<>', 1)->get();

        return response()->json([
            'tipoArchivo' => $tipoArchivo,
            'tramite' => $tramite,
            'departamento' => $departamento,
            'estado' => $estado,
            'casos' => $casos,
            'usuarios' => $usuarios,
            'estado1' => $estado1,
            'tribunales' => $tribunales,
        ]);
    }

    public function tabla()
    {
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            ->orderBy("casos.fecha_recibido")
            ->where('id_estado', 1)->get();
        return $casos;
    }

    public function verCasoData($id)
    {
        $caso = DB::table('casos')
        ->select(
            'casos.*',
            'departamentos.nombre as dep_nombre',
            'ciudades.nombre as ciu_nombre',
            'estado.nombre as estado_nombre',
            'tipo_tramite.nombre as tramite_nombre',
            'prioridad.nombre as prioridad_nombre',
            'tipo_eleccion.nombre as eleccion_nombre',
            'medio_recepcion.nombre as recepcion_nombre',
            'dep.nombre as dep_nombre_residencia',
            'ciu.nombre as ciu_nombre_residencia',
        )->join('departamentos','departamentos.id', 'casos.id_departamento')
        ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
        ->join('estado', 'estado.id', 'casos.id_estado')
        ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
        ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
        ->join('tipo_eleccion', 'tipo_eleccion.id', 'casos.id_eleccion')
        ->join('medio_recepcion', 'medio_recepcion.id', 'casos.id_recepcion')
        ->join('departamentos AS dep', 'dep.id', 'casos.id_departamento_residencia')
        ->join('ciudades AS ciu', 'ciu.id', 'casos.id_municipio_residencia')
        ->where('casos.id',$id)->get();
        // return $caso;

        // $caso = DB::table('casos')
        //     ->select(
        //         'casos.*',
        //         DB::raw('departamentos.nombre as dep_nombre'),
        //         DB::raw('ciudades.nombre as ciu_nombre'),
        //         DB::raw('estado.nombre as estado_nombre'),
        //         DB::raw('tipo_tramite.nombre as tramite_nombre'),
        //         DB::raw('prioridad.nombre as prioridad_nombre'),
        //         DB::raw('tipo_eleccion.nombre as eleccion_nombre'),
        //         DB::raw('medio_recepcion.nombre as recepcion_nombre'),
        //         DB::raw('dep.nombre as dep_nombre_residencia'),
        //         DB::raw('tipo_identificacion.nombre as tipo_identificacion_nombre'),
        //         DB::raw('ciu.nombre as ciu_nombre_residencia'),
        //     )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
        //     ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
        //     ->join('estado', 'estado.id', 'casos.id_estado')
        //     ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
        //     ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
        //     ->join('tipo_eleccion', 'tipo_eleccion.id', 'casos.id_eleccion')
        //     ->join('medio_recepcion', 'medio_recepcion.id', 'casos.id_recepcion')
        //     ->join('tipo_identificacion', 'tipo_identificacion.id', 'casos.id_identificacion')
        //     ->join('departamentos AS dep', 'dep.id', 'casos.id_departamento_residencia')
        //     ->join('ciudades AS ciu', 'ciu.id', 'casos.id_municipio_residencia')
        //     ->where('casos.id', $id)->get();

        $trazabilidad = DB::table('casos_seguimientos')
            ->select(
                'casos_seguimientos.*',
                'estado.nombre as estado_nombre'
            )
            ->join('casos', 'casos.id', 'casos_seguimientos.id_caso')
            ->join('estado', 'estado.id', 'casos_seguimientos.id_estado')
            ->where('id_caso', $id)
            ->orderByDesc('casos_seguimientos.fecha_gestion')
            ->get();

        return response()->json(['caso' =>  $caso, 'trazabilidad' => $trazabilidad]);
    }

    public function asignarCaso(Request $request)
    {
        // $caso = DB::table("casos")->where("id",$request->id)->get();
        $caso = Caso::find($request->id);

        // echo "<pre>";
        // var_dump($caso);die;

        // $caso->id_asesor_asignado = $request->asesor;
        $caso->id_magistrado = $request->magistrado;
        $caso->id_tribunal = $request->tribunal;
        $caso->id_estado = 2;
        $caso->observacion_asignacion = $request->observacion;
        $caso->fecha_gestion = date('Y-m-d');
        $caso->save();
        $seguimiento = new CasoSeguimiento();
        $seguimiento->gestion = 'Caso asignado';
        $seguimiento->fecha_gestion = date('Y-m-d');
        $seguimiento->id_asesor_asignado = $request->asesor;
        $seguimiento->id_estado = 2;
        $seguimiento->id_caso = $caso->id;
        $seguimiento->save();
        // $casos = $this->tabla();
        return response()->json(['status' => 200, 'msg' => 'Caso asignado con éxito']);
    }

    public function listadoCasosAsignadosData()
    {
        $casos = $this->tablaasignados();
        $tramite = TipoTramite::all();
        $departamento = Departamentos::all();
        $estado = Estado::all();
        $tipoArchivo = TipoArchivo::where('estado', 1)->get();
        $estado1 = Estado::where('estado', 1)
            ->where('id', '<>', 1)->get();

        return response()->json([
            'tramite' => $tramite,
            'departamento' => $departamento,
            'estado' => $estado,
            'casos' => $casos,
            'estado1' => $estado1,
            'tipoArchivo' => $tipoArchivo,
        ]);
    }

    public function tablaasignados()
    {
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
                // DB::raw('centralizado_cne.nombre as nom_persona'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            // ->join('centralizado_cne.personas','centralizado_cne.personas.id','casos.id_asesor_asignado')
            ->orderBy("casos.fecha_recibido")
            ->where('id_asesor_asignado', Auth::user()->id)
            ->where('casos.id_estado', '<>', 1)
            ->where('casos.id_estado', '<>', 4)->get();
        return $casos;
    }

    public function gestion_en_tramite(Request $request)
    {
        // return $request->all();
        $caso = Caso::find($request->id);
        $caso->id_estado = 3;
        // $caso->save();
        $caso->observacion_asignacion = $request->observacion;
        // $caso->id_asesor_asignado = $request->asesor;
        // $caso->fecha_respuesta = date('Y-m-d');

        $seguimiento = new CasoSeguimiento();
        $seguimiento->gestion = $request->observacion;
        $seguimiento->fecha_gestion = date('Y-m-d');
        $seguimiento->id_asesor_asignado = $request->asesor;
        $seguimiento->id_caso = $caso->id;
        $seguimiento->id_estado = 3;
        $seguimiento->save();


        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = time() . '_' . $file->getClientOriginalname();

            $documento = new Documento();
            $documento->nombre = $fileName;
            $documento->ruta = 'uploads/' . $fileName;
            $documento->estado = 1;
            $documento->id_subserie = 1;
            $documento->id_tipo_documento = $request->tipo_archivo;
            $documento->save();

            $soporte = new Soporte();
            // $soporte->estado = 1;
            $soporte->id_caso = $caso->id;
            $soporte->id_documento = $documento->id;
            $soporte->save();
            $request->archivo->move(public_path('uploads'), $fileName);
        }
        if ($caso->save()) {
            $casos = $this->tablaasignados();
            return response()->json(['status' => 200, 'msg' => 'Datos actualizados con éxito', 'casos' => $casos]);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Error en la actualización']);
        }
    }

    public function gestion_en_finalizado(Request $request)
    {
        // return $request->all();
        $caso = Caso::find($request->id);
        $caso->id_estado = 4;
        $caso->respuesta = $request->respuesta;
        // $caso->id_asesor_asignado = $request->asesor;
        $caso->fecha_respuesta = date('Y-m-d');

        $seguimiento = new CasoSeguimiento();
        $seguimiento->gestion = $request->respuesta;
        $seguimiento->fecha_gestion = date('Y-m-d');
        $seguimiento->id_asesor_asignado = $request->asesor;
        $seguimiento->id_caso = $caso->id;
        $seguimiento->id_estado = 4;
        $seguimiento->save();

        $file = $request->file('archivo');
        if ($request->hasFile('archivo')) {
            $fileName = time() . '_' . $file->getClientOriginalname();
        }
        $documento = new Documento();
        $documento->nombre = $fileName;
        $documento->ruta = 'uploads/' . $fileName;
        $documento->estado = 1;
        $documento->id_subserie = 1;
        $documento->id_tipo_documento = $request->tipo_archivo;
        $documento->save();

        $soporte = new Soporte();
        // $soporte->estado = 1;
        $soporte->id_caso = $caso->id;
        $soporte->id_documento = $documento->id;
        $soporte->save();

        $request->archivo->move(public_path('uploads'), $fileName);

        if ($caso->save()) {
            $casos = $this->tabla();
            return response()->json(['status' => 200, 'msg' => 'Datos actualizados con éxito', 'casos' => $casos]);
        } else {
            return response()->json(['status' => 500, 'msg' => 'Error en la actualización']);
        }
    }

    public function listado_historico_casos_data()
    {
        $casos = $this->tabla_historico();
        $tramite = TipoTramite::all();
        $departamento = Departamentos::all();
        $estado = Estado::all();
        $tipoArchivo = TipoArchivo::all();
        $tribunales = Tribunal::where('estado',1)->get();
        $magistrados = Magistrado::where('estado',1)->get();
        $estado1 = Estado::where('estado', 1)
            ->where('id', '<>', 1)->get();

        return response()->json([
            'tipoArchivo' => $tipoArchivo,
            'tramite' => $tramite,
            'departamento' => $departamento,
            'estado' => $estado,
            'casos' => $casos,
            'estado1' => $estado1,
            'tribunales' => $tribunales,
            'magistrados' => $magistrados,
        ]);
    }

    public function tabla_historico()
    {
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            ->orderBy("casos.fecha_recibido")
            ->where('id_estado', '<>', 1)->get();
        return $casos;
    }

    public function gestion_caso_admin(Request $request)
    {
        // return $request->all();
        $estado = $request->estado;
        switch ($estado) {
            case 1:
                $caso = Caso::find($request->id);
                $caso->gestion = $request->observacion;
                $caso->id_estado = $request->estado;
                $caso->save();
                $seguimiento = CasoSeguimiento::find($request->id);
                $seguimiento->gestion = $request->observacion;
                $seguimiento->fecha_gestion = date('Y-m-d');
                $seguimiento->id_asesor_asignado = $request->asesor;
                $seguimiento->id_caso = $caso->id;
                $seguimiento->id_estado = $request->estado;
                $seguimiento->save();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Datos actualizados con éxito',
                    'caso' => $caso,
                ]);
                break;
            case '2':
                $caso = Caso::find($request->id);
                $caso->gestion = $request->observacion;
                $caso->id_asesor_asignado = $request->magistrado;
                $caso->id_tribunal = $request->tribunal;
                $caso->id_magistrado = $request->magistrado;
                $caso->id_estado = $request->estado;
                $caso->save();
                $seguimiento = CasoSeguimiento::find($request->id);
                $seguimiento->gestion = $request->observacion;
                $seguimiento->fecha_gestion = date('Y-m-d');
                $seguimiento->id_asesor_asignado = $request->asesor;
                $seguimiento->id_caso = $caso->id;
                $seguimiento->id_estado = $request->estado;
                $seguimiento->save();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Datos actualizados con éxito',
                    'caso' => $caso,
                ]);
                break;
            case '3':
                $caso = Caso::find($request->id);
                $caso->id_estado = 3;
                $caso->observacion_asignacion = $request->observacion;
                // $caso->id_asesor_asignado = Auth::user()->id;
                $caso->save();
                // $caso->fecha_respuesta = date('Y-m-d');

                $seguimiento = new CasoSeguimiento();
                $seguimiento->gestion = $request->observacion;
                $seguimiento->fecha_gestion = date('Y-m-d');
                // $seguimiento->id_asesor_asignado = Auth::user()->id;
                $seguimiento->id_caso = $caso->id;
                $seguimiento->id_estado = 3;
                $seguimiento->save();

                if ($request->hasFile('archivo')) {
                    $file = $request->file('archivo');
                    $fileName = time() . '_' . $file->getClientOriginalname();

                    $documento = new Documento();
                    $documento->nombre = $fileName;
                    $documento->ruta = 'uploads/' . $fileName;
                    $documento->estado = 1;
                    $documento->id_subserie = 1;
                    $documento->id_tipo_documento = $request->tipoArchivo;
                    $documento->save();

                    $soporte = new Soporte();
                    // $soporte->estado = 1;
                    $soporte->id_caso = $caso->id;
                    $soporte->id_documento = $documento->id;
                    $soporte->save();
                    $request->archivo->move(public_path('uploads'), $fileName);
                }
                return response()->json([
                    'status' => 200,
                    'msg' => 'Datos actualizados con éxito',
                    'caso' => $caso,
                ]);
                break;
            case '4':
                $caso = Caso::find($request->id);
                $caso->id_estado = 4;
                $caso->respuesta = $request->respuesta;
                // $caso->id_asesor_asignado = $request->asesor;
                $caso->fecha_respuesta = date('Y-m-d');
                $caso->save();

                $seguimiento = new CasoSeguimiento();
                $seguimiento->gestion = $request->observacion;
                $seguimiento->fecha_gestion = date('Y-m-d');
                // $seguimiento->idAsesorGestion = $request->asesor;
                $seguimiento->id_caso = $caso->id;
                $seguimiento->id_estado = 4;
                $seguimiento->save();

                $file = $request->file('archivo');
                if ($request->hasFile('archivo')) {
                    $fileName = time() . '_' . $file->getClientOriginalname();
                }
                $documento = new Documento();
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->estado = 1;
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request->tipoArchivo;
                $documento->save();

                $soporte = new Soporte();
                // $soporte->estado = 1;
                $soporte->id_caso = $caso->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request->archivo->move(public_path('uploads'), $fileName);
                return response()->json([
                    'status' => 200,
                    'msg' => 'Datos actualizados con éxito',
                    'caso' => $caso,
                ]);
                break;
        }
    }

    public function filtrar_listado_casos(Request $request)
    {
        $post = $request;
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            ->orderBy("casos.fecha_recibido")
            ->where('id_estado', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['tramite'])) {
                    if (!empty($post['tramite']))
                        $query->orwhere('casos.id_tramite', $post['tramite']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_realizacion'])) {
                    if (!empty($post['fecha_realizacion']))
                        $query->orwhere('casos.fecha_recibido', $post['fecha_realizacion']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['departamento'])) {
                    if (!empty($post['departamento']))
                        $query->orwhere('casos.id_departamento', $post['departamento']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['estado'])) {
                    if (!empty($post['estado']))
                        $query->orwhere('casos.id_estado', $post['estado']);
                }
            })->get();

        return $casos;
        return response()->json([
            'casos' => $casos,
        ]);
    }

    public function documentoxcaso($id)
    {
        $soporte = Caso::find($id)->soportes;
        $documentos = [];
        $x = 0;
        foreach ($soporte as $row) {
            $documentos[$x] = $row->documento;
            $x++;
        }
        return $documentos;
    }

    public function filtrar_listado_casos_asignados(Request $request)
    {
        $post = $request;
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            ->orderBy("casos.fecha_recibido")
            // ->where('id_asesor_asignado', Auth::user()->id)
            ->where('casos.id_estado', '<>', 1)
            ->where('casos.id_estado', '<>', 4)
            // ->where('casos.estado_pro', 1)
            ->orderBy("casos.fecha_recibido")
            // ->where('id_asesor_asignado', Auth::user()->id)
            // ->where('casos.id_estado', '<>', 1)
            // ->where('casos.estado_pro', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['tramite'])) {
                    if (!empty($post['tramite']))
                        $query->orwhere('casos.id_tramite', $post['tramite']);
                }
            })
            // ->where('id_asesor_asignado', Auth::user()->id)
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_realizacion'])) {
                    if (!empty($post['fecha_realizacion']))
                        $query->orwhere('casos.fecha_recibido', $post['fecha_realizacion']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['departamento'])) {
                    if (!empty($post['departamento']))
                        $query->orwhere('casos.id_departamento', $post['departamento']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['estado'])) {
                    if (!empty($post['estado']))
                        $query->orwhere('casos.id_estado', $post['estado']);
                }
            })->get();
        return $casos;
        return response()->json([
            'casos' => $casos,
        ]);
    }

    public function filtros_historico_casos(Request $request)
    {
        // return $request->all();
        $post = $request->all();
        $casos = DB::table('casos')
            ->select(
                'casos.*',
                DB::raw('departamentos.nombre as dep_nombre'),
                DB::raw('ciudades.nombre as ciu_nombre'),
                DB::raw('estado.nombre as estado_nombre'),
                DB::raw('tipo_tramite.nombre as tramite_nombre'),
                DB::raw('prioridad.nombre as prioridad_nombre'),
            )->join('departamentos', 'departamentos.id', 'casos.id_departamento')
            ->join('ciudades', 'ciudades.id', 'casos.id_municipio')
            ->join('estado', 'estado.id', 'casos.id_estado')
            ->join('tipo_tramite', 'tipo_tramite.id', 'casos.id_tramite')
            ->join('prioridad', 'prioridad.id', 'casos.id_prioridad')
            ->orderBy("casos.fecha_recibido")
            ->where('id_estado', '<>', 1)
            ->where(function ($query) use ($post) {
                if (isset($post['tramite'])) {
                    if (!empty($post['tramite']))
                        $query->orwhere('tipo_tramite.id', $post['tramite']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_recibido'])) {
                    if (!empty($post['fecha_recibido']))
                        $query->orwhere('casos.fecha_recibido', $post['fecha_recibido']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['departamento'])) {
                    if (!empty($post['departamento']))
                        $query->orwhere('departamentos.id', $post['departamento']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['estado'])) {
                    if (!empty($post['estado']))
                        $query->orwhere('casos.id_estado', $post['estado']);
                }
            })
            // ->where('estado_pro', 1)
            ->get();
        return $casos;
    }


    /**
     * Store a new assignement request for creating a new casos log.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {

        $rules = [
            'caso' => 'required|numeric',
            'estado_caso' => 'required|numeric',
            'asesor_asignado' => 'required|numeric'
        ];
        $messages = [
            'caso.required' => 'El nùmero de caso es requerido.',
            'estado_caso.required' => 'No hay estado asignado.',
            'asesor_asignado.required' => 'Se requiere asignar un usuario al caso',
            'asesor_asignado.numeric' => 'Se requiere el id del usuario para asignar al caso',
        ];

        /*if (!isset($r->file)) {
            return response()->json([
                'msg' => 'Debe ingresar al menos un documento'
            ]);
        }*/

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        } else {

            //
            $step_estado_caso = 0;
            $valuesToUpdate = array();
            $msgjson = '';

            $case = new CasoSeguimiento();
            $case->id_caso = $request->caso;
            $case->id_estado = $request->estado_caso;
            $case->fecha_gestion = Carbon::now()->toDateString();

            switch($request->estado_caso){
                case 1:
                    $step_estado_caso = 2;
                    //$case->gestion = $request->gestion;
                    $case_gestion = 'Caso asignado correctamente';
                    $valuesToUpdate = array(
                        'id_estado' => $step_estado_caso,
                        'fecha_gestion' => $case->fecha_gestion,
                        'id_asesor_asignado' => $request->asesor_asignado,
                        'gestion' => $case_gestion,
                    );
                    $msgjson = 'Caso asignado correctamente';
                break;
                case 2:
                    $step_estado_caso = 3;
                    $case_gestion = $request->gestion;
                    $fecha_eleccion = Carbon::now()->toDateString();
                    $valuesToUpdate = array(
                        'id_estado' => $step_estado_caso,
                        'fecha_gestion' => $case->fecha_gestion,
                        'id_asesor_asignado' => $request->asesor_asignado,
                        'fecha_eleccion' => $fecha_eleccion,
                        'gestion' => $case_gestion,
                    );
                    $msgjson = 'Caso gestionado correctamente';
                break;
                case 3:
                    $step_estado_caso = $request->estado_caso;
                    $case_gestion = $request->gestion;
                    $valuesToUpdate = array(
                        'id_estado' => $request->estado_caso,
                        'fecha_gestion' => $case->fecha_gestion,
                        'id_asesor_asignado' => $request->asesor_asignado,
                        'gestion' => $case_gestion,
                    );
                    $msgjson = 'Caso en trámite actualizado';
                    return;
                case 4:
                    $step_estado_caso = $request->estado_caso;
                    $case_gestion = $request->detailsReply;
                    $fecha_fin = Carbon::now()->toDateString();
                    $valuesToUpdate = array(
                        'id_estado' => $request->estado_caso,
                        'fecha_gestion' => $case->fecha_gestion,
                        'id_asesor_asignado' => $request->asesor_asignado,
                        'fecha_fin' => $fecha_fin,
                        'gestion' => $case_gestion,
                    );
                    $msgjson = 'Caso finalizado correctamente';
                break;
            }

            $case->id_estado = $step_estado_caso;

            $case->gestion = $case_gestion;
            $case->fecha_gestion = Carbon::now()->toDateString();
            $case->id_asesor_asignado = $request->asesor_asignado;

            $case->save();

            Caso::whereId($case->id_caso)
                //->update($request->all());
                ->update($valuesToUpdate);
                //return response()->json('Caso actaulizado');

            return response()->json([
                'msg' => $msgjson,
                'code' => 200,
            ]);
        }

        /*try {
            $this->validate(request(),[
                'caso' => 'required',
                'estado_caso' => 'required',
                'asesor_asignado' => 'required'
            ]);
          }
          catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'message'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }*/

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $caso = new Caso();
        $casos = $caso->getWithLogOfCasos($id);
        //$casos = $this->caso->getWithLogOfCasos($id);

        /*$casos->makeHidden(['id','id_estado','id_tramite', 'id_asesor_asignado', 'id_departamento', 'id_departamento_residencia', 'id_eleccion', 'id_identificacion', 'id_municipio', 'id_municipio_residencia', 'id_prioridad', 'id_recepcion', 'id_tribunal', 'identificacion','created_at','updated_at' ]);*/

        return response()->json([
            'data'=>$casos,
            'status' => 200
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        /*return response()->json([
            'info' =>DB::table('casos')->where('id', $id)->first(),
            'departamentos'=>Departamentos::all()->where('estado',1),
            'ciudades'=>Ciudades::all()->where('estado',1),
            'tipo_identificacion' => TipoIdentificacion::all()->where('estado',1),
        ]);*/
    }

    public function filtro_detalles_trazabilidad(Request $request)
    {
        if ($request->n_casos == '') :
            $casos = DB::select(
                " select
                id
                , psp.id_estado
                ,(
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 1
                ) as recibido,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 2
                ) as asignado,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 3
                ) as tramite,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 4
                ) as finalizado
            from casos as psp
            order by id asc"
            );
        else :
            $casos = DB::select(
                " select
                id
                , psp.id_estado
                ,(
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 1
                ) as recibido,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 2
                ) as asignado,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 3
                ) as tramite,
                (
                    select  MAX(`fecha_gestion`) as fecha
                    from `casos_seguimientos` ps1
                    where ps1.id_caso = psp.id and ps1.id_estado = 4
                ) as finalizado
            from casos as psp
            where id = $request->n_casos
            order by id asc"
            );
        endif;

        return response()->json([
            'status' => 200,
            'casos' => $casos,
        ]);
    }

    public function nuevoCasoData()
    {
        $tramite = TipoTramite::where('estado', 1)->get();
        $eleccion = TipoEleccion::where('estado', 1)->get();
        $prioridad = Prioridad::where('estado', 1)->get();
        $ciudad = Ciudad::all();
        $departamento = Departamentos::all();
        $identificacion = TipoIdentificacion::where('estado', 1)->get();
        $estado = Estado::all(); //No se usa
        $recepcion = MedioRecepcion::where('estado', 1)->get();

        return response()->json([
            'tramite' => $tramite,
            'eleccion' => $eleccion,
            'prioridad' => $prioridad,
            'ciudad' => $ciudad,
            'departamento' => $departamento,
            'identificacion' => $identificacion,
            'recepcion' => $recepcion,
            'estado' => $estado, //No se usa
        ]);
    }

    public function ciudadxdepartamento($id)
    {
        $ciudad = Ciudad::where('id_departamento', $id)->get();
        return $ciudad;
    }

    public function guardarCaso(Request $request)
    {
        // return $request->all();
        $rules = [
            'id_tipo_tramite' => 'required',
            'fecha_eleccion' => 'required|date',
            'id_tipo_eleccion' => 'required',
            'id_prioridad' => 'required',
            'fecha_recibido' => 'required|date',
            'id_medio_recepcion' => 'required',
            'correo_notificacion' => 'required|email',
            'informante_anonimo' => 'required|in:Si,No',
            'id_departamento' => 'required',
            'id_ciudad' => 'required',
            'direccion' => 'required',
            'barrio' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'puesto_votacion' => 'required',
            'mesa_votacion' => 'required',
            'asunto' => 'required',
            'hechos' => 'required',
            'nombres_solicitante' => 'required',
            'id_tipo_identificacion' => 'required',
            'numero_identificacion' => 'required',
            'id_departamento_recidencia' => 'required',
            'id_ciudad_recidencia' => 'required',
            'direccion_recidencia' => 'required',
            'telefono' => 'required',
            // 'id_estado' => 'required',
            // 'id_asesor_asignado' => 'required',
            // 'fecha_gestion' => 'required|date',
            // 'fecha_respuesta' => 'required|date',
            // 'gestion' => 'required'
        ];
        // return response()->json(['request' => $r]);
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }

        $caso = new Caso();
        $caso->id_tramite = $request->id_tipo_tramite;
        $caso->fecha_eleccion = $request->fecha_eleccion;
        $caso->id_eleccion = $request->id_tipo_eleccion;
        $caso->id_prioridad = $request->id_prioridad;
        $caso->fecha_recibido = $request->fecha_recibido;
        $caso->id_recepcion = $request->id_medio_recepcion;
        $caso->correo_notificacion = $request->correo_notificacion;
        $caso->informante_anonimo = $request->informante_anonimo;
        $caso->id_departamento = $request->id_departamento;
        $caso->id_municipio = $request->id_ciudad;
        $caso->direccion = $request->direccion;
        $caso->barrio = $request->barrio;
        $caso->fecha_inicio = $request->fecha_inicio;
        $caso->fecha_fin = $request->fecha_fin;
        $caso->puesto_votacion = $request->puesto_votacion;
        $caso->mesa_votacion = $request->mesa_votacion;
        $caso->asunto = $request->asunto;
        $caso->hechos = $request->hechos;
        $caso->nombres_solicitante = $request->nombres_solicitante;
        $caso->id_identificacion = $request->id_tipo_identificacion;
        $caso->num_identificacion = $request->numero_identificacion;
        $caso->id_departamento_residencia = $request->id_departamento_recidencia;
        $caso->id_municipio_residencia = $request->id_ciudad_recidencia;
        $caso->direccion_residencia = $request->direccion_recidencia;
        $caso->telefono = $request->telefono;
        $caso->id_estado = 1;
        $caso->save();

        if ($caso) {
            return response()->json(
                [
                    'status' => 200,
                    'msg' => 'Los datos han sido guardados exitosamente',
                    'url' => '/listado-casos',
                    'id' => $caso->id
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 500,
                    'msg' => 'Ingrese de forma correcta todos los campos',
                ]
            );
        }
    }

    public function magistradoxdepartamento($id)
    {
        $magistrados = Magistrado::where('tribunal_id',$id)->where('estado',1)->get();
        return response()->json([
            'magistrados' => $magistrados,
        ]);
    }
}
