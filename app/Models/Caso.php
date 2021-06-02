<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CasoSeguimiento;
use Illuminate\Support\Facades\DB;


class Caso extends Model
{
    use HasFactory;
    protected $table = 'casos';

    protected $fillable = ['id', 'created_at', 'updated_at'];

    /*public $caso;

    public function __construct()
    {
        $this->caso = new Caso;
    }*/

    public function caso() {
        return $this->hasMany(CasoSeguimiento::class, 'id_caso', 'id');
    }

    public function getListOfCasos($otherUser = null){

        $casos = Caso::with('caso')
        ->join('departamentos', 'casos.id_departamento', '=', 'departamentos.id')
        ->join('ciudades', 'casos.id_municipio', '=', 'ciudades.id')
        ->join("tipo_tramite", "tipo_tramite.id", '=', "casos.id_tramite" )
        ->join("prioridad", "prioridad.id", '=', "casos.id_prioridad" )
        ->join("estado", "estado.id", '=', "casos.id_estado")
        ->select('casos.*', 'departamentos.nombre AS departamento_nombre', 'ciudades.nombre AS ciudad_nombre', 'tipo_tramite.nombre AS tramite', 'prioridad.nombre AS prioridad', 'estado.nombre AS estado', 'casos.id_asesor_asignado AS asesor_asignado')
        ->where(function ($query) use ($otherUser) {
            if (isset($otherUser))
                if (!empty($otherUser)) {
                    $query->where('casos.id_asesor_asignado', '=', $otherUser);
                }
        })
        ->orderBy('casos.id', 'asc')->paginate(10);

        return $casos;
    }

    public function searchListOfCasos($filtro){

        $casos = Caso::select('casos.*', 'departamentos.nombre AS departamento_nombre', 'ciudades.nombre AS ciudad_nombre', 'tipo_tramite.nombre AS tramite', 'prioridad.nombre AS prioridad', 'estado.nombre AS estado', 'casos.id_asesor_asignado AS asesor_asignado')
            ->join('departamentos', 'casos.id_departamento', '=', 'departamentos.id')
            ->join('ciudades', 'casos.id_municipio', '=', 'ciudades.id')
            ->join("tipo_tramite", "tipo_tramite.id", '=', "casos.id_tramite" )
            ->join("prioridad", "prioridad.id", '=', "casos.id_prioridad" )
            ->join("estado", "estado.id", '=', "casos.id_estado")
            //->where('casos.'.$filtro, '=', $id_filtro )
            //->where('casos.id_tramite', '=', $id_filtro )->orderBy('id', 'desc')->paginate(10);
            ->where(function ($query) use ($filtro) {
                if (isset($filtro))
                    if (!empty($filtro)) {

                        foreach ($filtro as $k => $v) {
                            $query->where('casos.'.($k), '=', $v);
                        }
                    }
            })
            ->orderBy('id', 'desc')->paginate(10);

        return $casos;
    }

    public function getWithLogOfCasos($id){

        $casos = Caso::with('caso')
        ->join('departamentos', 'casos.id_departamento', '=', 'departamentos.id')
        ->join('ciudades', 'casos.id_municipio', '=', 'ciudades.id')
        ->join("tipo_tramite", "tipo_tramite.id", '=', "casos.id_tramite" )
        ->join("tipo_eleccion", "tipo_eleccion.id", '=', "casos.id_eleccion" )
        ->join("medio_recepcion", "medio_recepcion.id", '=', "casos.id_recepcion" )
        ->join("prioridad", "prioridad.id", '=', "casos.id_prioridad" )
        ->join("tipo_identificacion", "tipo_identificacion.id", '=', "casos.id_identificacion" )
        ->join("estado", "estado.id", '=', "casos.id_estado")
        ->select('casos.*', 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad', 'estado.nombre AS estado', 'tipo_tramite.nombre AS tramite', 'tipo_eleccion.nombre AS eleccion', 'medio_recepcion.nombre AS recepcion', 'prioridad.nombre AS prioridad', 'tipo_identificacion.nombre AS identification', 'departamentos.nombre AS departamento_residencia', 'ciudades.nombre AS municipio_residencia')
        ->where([
            ['casos.id', '=', $id]
        ])->first();

        return $casos;
    }

    public function getWithLogOfCasosOld($id){

        $casos = Caso::with('caso')
        ->leftjoin( DB::raw('(select * from  casos_seguimientos where casos_seguimientos.id_caso='.(!empty($id)?$id:0).') as casos_seguimientos'), 'casos_seguimientos.id_caso', 'casos.id')

        ->join('departamentos', function ($join)  {
            $join->on('departamentos.id', '=', 'casos.id_departamento');
            $join->on('departamentos.id', '=', 'casos.id_departamento_residencia');
        })
        ->join('ciudades', function ($join) {
            $join->on('ciudades.id_departamento', '=', 'casos.id_municipio');
            $join->on('ciudades.id_departamento', '=', 'casos.id_municipio_residencia');
        })
        ->join("estado", "estado.id", '=', "casos.id_estado")

        ->join("tipo_tramite", "tipo_tramite.id", '=', "casos.id_tramite" )
        ->join("tipo_eleccion", "tipo_eleccion.id", '=', "casos.id_eleccion" )
        ->join("medio_recepcion", "medio_recepcion.id", '=', "casos.id_recepcion" )
        ->join("prioridad", "prioridad.id", '=', "casos.id_prioridad" )
        ->join("tipo_identificacion", "tipo_identificacion.id", '=', "casos.id_identificacion" )
        ->select('casos.*', 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad', 'estado.nombre AS estado', 'tipo_tramite.nombre AS tramite', 'tipo_eleccion.nombre AS eleccion', 'medio_recepcion.nombre AS recepcion', 'prioridad.nombre AS prioridad', 'tipo_identificacion.nombre AS identification', 'departamentos.nombre AS departamento_residencia', 'ciudades.nombre AS municipio_residencia')
        //'casos_seguimientos.id_estado AS seguimiento_estado'
        //->where("casos.id",$id)
        ->where([
            ['casos.id', '=', $id]
        ])->first();

        return $casos;
    }
}
