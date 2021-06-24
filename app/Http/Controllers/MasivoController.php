<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CasosImpor;
use App\Models\Caso;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Departamentos;
use App\Models\MedioRecepcion;
use App\Models\Prioridad;
use App\Models\TipoEleccion;
use App\Models\TipoIdentificacion;
use App\Models\TipoTramite;

class MasivoController extends Controller
{
    function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function import(Request $request)
    {
        $rows = Excel::toArray(new CasosImpor, $request->file('archivo'));
        $data = $rows[0];

        $error = array();
        $exito = array();
        $i = 0;
        $d = 0;
        // return sizeof($data);
        for ($x = 1; $x < sizeof($data); $x++) {
            $tipo_tramite = TipoTramite::where('nombre', $data[$x][1])->first();
            if (empty($tipo_tramite)) {
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el tipo de trámite";
                $i++;
                continue;
            }


            $tipo_tramite = $tipo_tramite['id'];
            // return $tipo_tramite;
            $tipo_eleccion = TipoEleccion::where('nombre', $data[$x][3])->first();
            if (empty($tipo_eleccion)) :
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el tipo de elección";
                $i++;
                continue;
            endif;

            $tipo_eleccion = $tipo_eleccion['id'];
            $prioridad = Prioridad::where('nombre', $data[$x][4])->first();
            if (empty($prioridad)) :
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe la prioridad";
                $i++;
                continue;
            endif;
            $prioridad = $prioridad['id'];

            $medio = MedioRecepcion::where('nombre',$data[$x][7])->first();
            if (empty($medio)) :
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el medio de recepción";
                $i++;
                continue;
            endif;

            $medio = $medio['id'];

            $departamento = Departamentos::where('nombre',$data[$x][10])->first();
            if(empty($departamento)):
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el departamento";
                $i++;
                continue;
            endif;
            $departamento = $departamento['id'];

            $ciudad = Ciudad::where('nombre',$data[$x][11])->first();
            if(empty($ciudad)):
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe la ciudad";
                $i++;
                continue;
            endif;
            $ciudad = $ciudad['id'];

            $tipo_identificacion = TipoIdentificacion::where('nombre',$data[$x][22])->first();
            if(empty($tipo_identificacion)):
                // $error[$i] = $data[$x];
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el tipo de identificación";
                $i++;
                continue;
            endif;
            // return '01';

            $tipo_identificacion = $tipo_identificacion['id'];

            $dep_residencia = Departamentos::where('nombre',$data[$x][24])->first();
            if(empty($dep_residencia)):
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe el departamento de residencia";
                $i++;
                continue;
            endif;

            $dep_residencia = $dep_residencia['id'];

            $ciu_residencia = Ciudad::where('nombre',$data[$x][25])->first();
            if(empty($ciu_residencia)):
                $error[$i]['linea'] = $x;
                $error[$i]['message'] = "No existe la ciudad de residencia";
                $i++;
                continue;
            endif;

            $ciu_residencia = $ciu_residencia['id'];

            $caso = new Caso();
            $caso->id_tramite = $tipo_tramite;
            $caso->fecha_eleccion = date_format(date_create($data[$x][2]), 'Y-m-d'); //2
            $caso->id_eleccion = $tipo_eleccion;
            $caso->id_prioridad = $prioridad;
            $caso->fecha_recibido = date_format(date_create($data[$x][6]), 'Y-m-d');
            $caso->id_recepcion = $medio;
            $caso->correo_notificacion = $data[$x][8];
            $caso->informante_anonimo = $data[$x][9];
            $caso->id_departamento = $departamento;
            $caso->id_municipio = $ciudad;
            $caso->direccion = $data[$x][12];
            $caso->barrio = $data[$x][13];
            $caso->fecha_inicio = date_format(date_create($data[$x][14]), 'Y-m-d'); //14
            $caso->fecha_fin = date_format(date_create($data[$x][15]), 'Y-m-d'); //15
            $caso->puesto_votacion = $data[$x][16];
            $caso->mesa_votacion = $data[$x][17];
            $caso->asunto = $data[$x][19];
            $caso->hechos = $data[$x][20];
            $caso->nombres_solicitante = $data[$x][21];
            $caso->id_identificacion = $tipo_identificacion;
            $caso->num_identificacion = $data[$x][23];
            $caso->id_departamento_residencia = $dep_residencia;
            $caso->id_municipio_residencia = $ciu_residencia;
            $caso->direccion_residencia = $data[$x][26];
            $caso->telefono = $data[$x][27];
            $caso->id_estado = 1;
            // $caso->estado_pro = 1;
            $caso->id_asesor_asignado = null;
            $caso->gestion = null;
            $caso->fecha_gestion = null;
            $caso->fecha_respuesta = null;
            $caso->observacion_asignacion = null;
            $caso->respuesta = null;
            $caso->link_soporte = $data[$x][18];
            $caso->entidades_informadas= $data[$x][28];
            $caso->abono_asunto_anterior = $data[$x][5];
            $caso->save();
            // return $caso;
            // return '1';
        }

        // return 'false';

        // return response()->json([
        //     'error' => $error,
        // ]);
        return view('ReporteErrores')->with('error', $error);
    }
}
