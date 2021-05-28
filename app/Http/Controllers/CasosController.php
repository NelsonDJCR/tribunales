<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Caso;
use App\Models\CasoSeguimiento;
use App\Models\Ciudades;
use App\Models\Departamentos;
use App\Models\Estado;
use App\Models\TipoIdentificacion;
use Carbon\Carbon;
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

            $casos = new Caso();
            $casos = $casos->getListOfCasos();

        }


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

    private function validateAssign($request){

        /*$validated = Validator::make($fields, [
            'fname' => 'required',
        ]);*/

        $messages = [
            'caso.required' => 'El nùmero de caso es requerido.',
            'estado_caso.required' => 'No hay estado asignado.',
            'asesor_asignado.required' => 'Se requiere asignar un usario al caso',
        ];

        //$validated = $this->validate($request,[
        //$validated = $request->validate([
        $validated = Validator::make($request->all(), [
            'caso' => 'required',
            'estado_caso' => 'required',
            'asesor_asignado' => 'required'
            //''
        ]);

        return $validated;
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
}
