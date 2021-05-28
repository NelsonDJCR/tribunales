<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Sorteo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuentaCobroController extends Controller
{
    public function table(Request $r)
    {
        return response()->json([
            'table' => CuentaCobro::where('estado',1)->with('tribunal','magistrado')->get()           
        ]);
    }

	public function save()
	{
        $date=request()->fecha_inicio;
        $rules = [
            'id_tribunal'=>'required|',
            'id_magistrado'=>'required|',
            'fecha_inicio'=>'required|after:today',
            'fecha_fin'=>"required|after:$date",
            'valor_honorarios'=>"required|",
            'numero_dias'=>'required|',
            'valor_bruto'=>'required|',
            'valor_factura'=>'required|',
            'total_pagar'=>'required|',
            'rete_fuente'=>'required|',
            'rete_iva'=>'required|',
            'rete_ica'=>'required|',
            'neto_pagar'=>'required|',
        ];
        $messages = [
            'id_tribunal.required'=>'El tribunal es requerido',
            'id_magistrado.required'=>'El magistrado es requerido',
            'fecha_inicio.required'=>'La fecha de inicio es requerida',
            'fecha_inicio.after'=>'La fecha de inicio debe ser mayor a hoy',
            'fecha_fin.required'=>'La fecha final es requerido',
            'fecha_fin.after'=>'La fecha final debe ser mayor a la inicial',
            'valor_honorarios.required'=>'Valor honorario es requerido',
            'numero_dias.required'=>'Números de días es requerido',
            'valor_bruto.required'=>'Valor bruto es requerido',
            'valor_factura.required'=>'Valor factura es requerido',
            'total_pagar.required'=>'Total a pagar es requerido',
            'rete_fuente.required'=>'Rete fuente es requerido',
            'rete_iva.required'=>'Rete iva es requerido',
            'rete_ica.required'=>'Rete ica  es requerido',
            'neto_pagar.required'=>'Neto a pagar es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        if (CuentaCobro::insert(request()->all())) {
            return response()->json([
                'code' =>200,
                'msg' => 'Datos insertados correctamente'
            ]);
        }
	}

	public function record()
	{
        
		return response()->json([
            'data' =>CuentaCobro::where('id',request()->id)->with('magistrado', 'tribunal')->first(),
        ]);
	}
}
