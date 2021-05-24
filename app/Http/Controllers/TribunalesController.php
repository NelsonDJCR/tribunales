<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTribunales;
use App\Models\Banco;
use App\Models\Ciudades;
use App\Models\Departamentos;
use App\Models\Estado;
use App\Models\TipoArchivo;
use App\Models\TipoCuenta;
use App\Models\TipoDocumento;
use App\Models\TipoIdentificacion;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TribunalesController extends Controller
{ 
    public function store(Request $r)
    {
        // php artisan make:request CreateTribunales
        $fileName = time(). '_'. $r->file('archivo')->getClientOriginalname();
        $r->archivo->move(public_path('uploads'), $fileName);
        $ruta =  "uploads/$fileName";
        $data = request()->all();
        $data['archivo']=$ruta;
        if (Tribunal::insert($data)) {
            return response()->json([
                'code' => 200,
                'msg' => 'El tribunal guardado exitosamente'
            ]);
        }
    }

	public function data()
	{  
		return response()->json([
            'departamentos' => Departamentos::all()->where('estado',1),
            'ciudades' => Ciudades::all()->where('estado',1),
            'tipo_documento' => TipoArchivo::all()->where('estado',1),
            'estado' => Estado::all()->where('estado',1),
            'bancos' => Banco::all()->where('estado',1),
            'tipo_cuentas' => TipoCuenta::all()->where('estado',1),
            'tipo_archivos' => TipoArchivo::all()->where('estado',1),
            'tipo_identificacion' => TipoIdentificacion::all()->where('estado',1),

        ]);
	}

	public function listar($table)
	{
        $tabla = DB::table($table)
        ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
        ->join("departamentos", "departamentos.id", "$table.dep_id")
        ->join("ciudades", "ciudades.id", "$table.ciu_id")
        ->get();

        // if ($table == 'tribunal') {
        //     $tabla = DB::table($table)
        //     ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
        //     ->join("departamentos", "departamentos.id", "$table.dep_id")
        //     ->join("ciudades", "ciudades.id", "$table.ciu_id")
        //     ->get();
        // }else if ($table == 'magistrados') {
        //     $tabla = DB::table($table)
        //     ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
        //     ->join("departamentos", "departamentos.id", "$table.dep_id")
        //     ->join("ciudades", "ciudades.id", "$table.ciu_id")
        //     ->join("tipo_cuenta", "tipo_cuenta.id", "$table.id_tipo_cuenta")
        //     ->join("banco", "banco.id", "$table.id_banco")
        //     ->join("tipo_archivo", "tipo_archivo.id", "$table.id_tipo_archivo")
        //     ->get();
        // }



		return response()->json([
            'departments'=>Departamentos::all()->where('estado',1),
            'tabla'=>$tabla
        ]);
	}

	public function estadoInactivar($id,$table,$estado)
	{
        DB::table($table)->where('id', $id)->update(['estado' => $estado]);
        return response()->json([
            'tabla' => DB::table($table)
            ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
            ->join("departamentos", "departamentos.id", "$table.dep_id")
            ->join("ciudades", "ciudades.id", "$table.ciu_id")
            ->get()
        ]);
	}

	public function dataRecord($id,$table)
	{
		return response()->json([
            'formulario' =>DB::table($table)->where('id', $id)->first(),
            'departamentos'=>Departamentos::all()->where('estado',1),
            'ciudades'=>Ciudades::all()->where('estado',1),
            'tipo_archivo'=>TipoArchivo::all()->where('estado',1),
            'bancos' => Banco::all()->where('estado',1),
            'tipo_cuentas' => TipoCuenta::all()->where('estado',1),
            'tipo_archivos' => TipoArchivo::all()->where('estado',1),
            'tipo_identificacion' => TipoIdentificacion::all()->where('estado',1),
        ]);
	}

	public function editar(Request $r)
	{
		 DB::table('tribunal')
              ->where('id', $r->id)
              ->update([
                'nombre' => $r->nombre,
                'direccion' => $r->direccion,
                'dep_id' => $r->dep_id,
                'ciu_id' => $r->ciu_id,
                'fecha_inicio' => $r->fecha_inicio,
                'fecha_final' => $r->fecha_final,
                'tipo_archivo' => $r->tipo_archivo,
               ]);
	}

	public function filtrar(Request $r)
	{
		$post = $r;


        $x = DB::table('tribunal')->select("tribunal.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
            ->leftjoin("departamentos", "departamentos.id", "tribunal.dep_id")
            ->leftjoin("ciudades", "ciudades.id", "tribunal.ciu_id")

            ->where(function ($query) use ($post) {
                if (isset($post['nombre'])) {
                    if (!empty($post['nombre']))
                        $query->orwhere("tribunal.nombre", 'like', "%" . $post['nombre'] . "%"); 
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['dep_id'])) {
                    if (!empty($post['dep_id']))
                        $query->orwhere("tribunal.dep_id", 'like', "%" . $post['dep_id'] . "%");
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_inicio'])) {
                    if (!empty($post['fecha_inicio']))
                    $query->where("tribunal.fecha_inicio", '>=', $post['fecha_inicio']);
                }
            })
            ->where(function ($query) use ($post) {
                if (isset($post['fecha_final'])) {
                    if (!empty($post['fecha_final']))
                    $query->where("tribunal.fecha_final",   '<=',  $post['fecha_final']);
                }
            })
            ->get();
        return response()->json([
            'tabla' => $x
        ]);
	}
}
