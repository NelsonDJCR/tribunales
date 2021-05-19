<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTribunales;
use App\Models\Ciudades;
use App\Models\Departamentos;
use App\Models\Estado;
use App\Models\TipoArchivo;
use App\Models\TipoDocumento;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TribunalesController extends Controller
{ 
    public function store(Request $r, CreateTribunales $valide)
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
        ]);
	}

	public function listar($table)
	{
		return response()->json([
            'departments'=>Departamentos::all()->where('estado',1),
            'tabla'=>DB::table($table)
            ->select("$table.*", 'departamentos.nombre AS departamento', 'ciudades.nombre AS ciudad')
            ->join("departamentos", "departamentos.id", "$table.dep_id")
            ->join("ciudades", "ciudades.id", "$table.ciu_id")
            ->get()
        ]);
	}

	public function estadoInactivar($id,$tabla,$estado)
	{
        DB::table($tabla)->where('id', $id)->update(['estado' => $estado]);
        return response()->json([
            'tabla' => DB::table($tabla)->get()
        ]);
	}

	public function dataRecord($id,$table)
	{
		return response()->json([
            'datos' =>DB::table($table)->where('id', $id)->first(),
            'departamentos'=>Departamentos::all()->where('estado',1),
            'ciudades'=>Ciudades::all()->where('estado',1),
            'tipo_archivo'=>TipoArchivo::all()->where('estado',1)
        ]);
	}
}
