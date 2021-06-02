<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTribunales;
use App\Models\Banco;
use App\Models\Ciudades;
use App\Models\Departamentos;
use App\Models\Estado;
use App\Models\Magistrado;
use App\Models\TipoArchivo;
use App\Models\TipoCuenta;
use App\Models\TipoDocumento;
use App\Models\TipoEleccion;
use App\Models\TipoIdentificacion;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TribunalesController extends Controller
{

    
    public function store(Request $r)
    {
        $fechaInicio =  $r->fecha_inicio;
        $rules = [
            'nombre'=>'required|max:20',
            'direccion'=>'required|max:60',
            'dep_id'=>'required',
            'ciu_id'=>'required',
            'fecha_inicio'=>'required|',
            'fecha_final'=>"required|after:$fechaInicio",
        ];
        $messages = [
            'nombre.required'=>'El nombre es requerido',
            'nombre.max'=>'El nombre no puede tener más de 20 carácteres',
            'direccion.required'=> 'La dirección es quequerida ',
            'direccion.max'=> 'La dirección no puede tener más de 60 carácteres',
            'dep_id.required'=>'El departamento es quequerido ',
            'ciu_id.required'=>'La ciudad es quequerida ',
            'fecha_inicio.required'=>'La fecha de inicio es quequerida ',
            'fecha_inicio.after'=>'Ingrese una fecha a partir de hoy',
            'fecha_final.required'=>'La fecha final es quequerida ',
            'fecha_final.after'=>'La fecha final debe que ser mayor a la inicial',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }

        



        if ($r->cantidad == 0) {
            return response()->json([
                'code' =>406,
                'msg' => 'Ingrese un documento',
            ]);
        }

    
        
        // php artisan make:request CreateTribunales
        


        $x = new Tribunal();
        $x->nombre = $r->nombre;
        $x->direccion = $r->direccion;
        $x->dep_id = $r->dep_id;
        $x->ciu_id = $r->ciu_id;
        $x->archivo = '';
        $x->fecha_inicio = $r->fecha_inicio;
        $x->fecha_final = $r->fecha_final;
        $x->save();

        for ($i=0; $i < $r->cantidad ; $i++) { 
            $fileName = time() . '_' . $r["archivos$i"]->getClientOriginalname();
            $r["archivos$i"]->move(public_path('uploads'), $fileName);
            $ruta =  "uploads/$fileName";
        }
        
        return response()->json([
            'code' => 200,
            'msg' => 'El tribunal guardado exitosamente'
        ]);
        
    }

    public function data()
    {
        // return '1';
        return response()->json([
            'departamentos' => Departamentos::all()->where('estado', 1),
            'ciudades' => Ciudades::all()->where('estado', 1),
            'tipo_documento' => TipoArchivo::all()->where('estado', 1),
            'estado' => Estado::all()->where('estado', 1),
            'bancos' => Banco::all()->where('estado', 1),
            'tipo_cuentas' => TipoCuenta::all()->where('estado', 1),
            'tipo_archivos' => TipoArchivo::all()->where('estado', 1),
            'tipo_identificacion' => TipoIdentificacion::all()->where('estado', 1),
            'magistrados' => Magistrado::all()->where('estado', 1),
            'tribunales' => Tribunal::all()->where('estado', 1),

        ]);
    }

    public function listar($table)
    {



        if ($table == 'actividades') {
            $tabla = DB::table($table)
                ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad', 'magistrados.nombre AS magistrado')
                ->join("departamentos", "departamentos.id", "$table.dep_id")
                ->join("ciudades", "ciudades.id", "$table.ciu_id")
                ->join("magistrados", "magistrados.id", "actividades.id_magistrado")
                ->get();
        } else {
            $tabla = DB::table($table)
                ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
                ->join("departamentos", "departamentos.id", "$table.dep_id")
                ->join("ciudades", "ciudades.id", "$table.ciu_id")
                ->get();
        }

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
            'departments' => Departamentos::all()->where('estado', 1),
            'tabla' => $tabla
        ]);
    }
   

    public function estadoInactivar($id, $table, $estado)
    {


        DB::table($table)->where('id', $id)->update(['estado' => $estado]);

        if ($table == 'actividades') {
            return response()->json([
                'tabla' => DB::table($table)
                    ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad', 'magistrados.nombre AS magistrado')
                    ->join("departamentos", "departamentos.id", "$table.dep_id")
                    ->join("ciudades", "ciudades.id", "$table.ciu_id")
                    ->join("magistrados", "magistrados.id", "actividades.id_magistrado")
                    ->get()
            ]);
        } else {
            return response()->json([
                'tabla' => DB::table($table)
                    ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
                    ->join("departamentos", "departamentos.id", "$table.dep_id")
                    ->join("ciudades", "ciudades.id", "$table.ciu_id")
                    ->get()
            ]);
        }
    }

    public function dataRecord($id, $table)
    {
        if ($table == 'actividades') {
            $x = DB::table('actividades')->where('id', $id)->first();
            return response()->json([
                'formulario' => DB::table($table)->where('id', $id)->first(),
                'departamentos' => Departamentos::all()->where('estado', 1),
                'ciudades' => Ciudades::all()->where('estado', 1),
                'tipo_archivo' => TipoArchivo::all()->where('estado', 1),
                'bancos' => Banco::all()->where('estado', 1),
                'tipo_cuentas' => TipoCuenta::all()->where('estado', 1),
                'tipo_archivos' => TipoArchivo::all()->where('estado', 1),
                'tipo_identificacion' => TipoIdentificacion::all()->where('estado', 1),
                'magistrado' => Magistrado::where('id',$x->id_magistrado)->select('magistrados.nombre AS magistrado')->first(),
                
            ]);
        }
        return response()->json([
            'formulario' => DB::table($table)->where('id', $id)->first(),
            'departamentos' => Departamentos::all()->where('estado', 1),
            'ciudades' => Ciudades::all()->where('estado', 1),
            'tipo_archivo' => TipoArchivo::all()->where('estado', 1),
            'bancos' => Banco::all()->where('estado', 1),
            'tipo_cuentas' => TipoCuenta::all()->where('estado', 1),
            'tipo_archivos' => TipoArchivo::all()->where('estado', 1),
            'tipo_identificacion' => TipoIdentificacion::all()->where('estado', 1),
            

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
                        $query->orwhere("tribunal.dep_id", '=', $post['dep_id'] );
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

	public function nuevaArchivo()
	{
		
	}
}
