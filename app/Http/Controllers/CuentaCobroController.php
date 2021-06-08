<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Sorteo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CuentaCobroController extends Controller
{
    public function table(Request $r)
    {
        return response()->json([
            'table' => CuentaCobro::where('estado',1)->with('tribunal','magistrado')->orderBy('id','DESC')->get()           
        ]);
    }
    public function tableMagistrado(Request $r)
    {
        $table = CuentaCobro::where('estado',1)
        ->where(function ($query) use ($r) {
            if (isset($r['tribunal_id'])) {
                if (!empty($r['tribunal_id']))
                    $query->orwhere("cuentas_cobro.id_tribunal", "=" , $r['tribunal_id']);
            }
        })
        ->where(function ($query) use ($r) {
            if (isset($r['fecha_inicio'])) {
                if (!empty($r['fecha_inicio']))
                    $query->orwhere("cuentas_cobro.fecha_inicio", ">=" , $r['fecha_inicio']);
            }
        })
        ->where(function ($query) use ($r) {
            if (isset($r['fecha_fin'])) {
                if (!empty($r['fecha_fin']))
                    $query->orwhere("cuentas_cobro.fecha_fin", "<=" , $r['fecha_fin']);
            }
        })
        ->where(function ($query) use ($r) {
            if (isset($r['valor_honorarios'])) {
                if (!empty($r['valor_honorarios']))
                    $query->orwhere("cuetas_cobro.valor_honorarios", "like", "%".$r['valor_honorarios']."%");
            }
        })
        ->where('id_magistrado',Auth::user()->id)
        ->with('tribunal','magistrado')
        ->orderBy('id','DESC')
        ->get();


        return response()->json([
            'table' => $table           
        ]);
    }

	public function save()
	{
        
        $data =  request()->all();
        if (isset($data['id_magistrado'])) {
            $data['id_magistrado'] = $data['id_magistrado'];
        }else {
            $data['id_magistrado'] = Auth::user()->id;
        }
        $date=request()->fecha_inicio;
        $rules = [
            'id_tribunal'=>'required|',
            'fecha_inicio'=>'required|',
            'fecha_fin'=>"required|after:$date",
            'total_pagar'=>'required|',
            'neto_pagar'=>'required|',
        ];
        $messages = [
            'id_tribunal.required'=>'El tribunal es requerido',
            'fecha_inicio.required'=>'La fecha de inicio es requerida',
            'fecha_inicio.after'=>'La fecha de inicio debe ser mayor a hoy',
            'fecha_fin.required'=>'La fecha final es requerido',
            'fecha_fin.after'=>'La fecha final debe ser mayor a la inicial',
            'total_pagar.required'=>'Total a pagar es requerido',
            'neto_pagar.required'=>'Neto a pagar es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        if (CuentaCobro::insert($data)) {
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

	public function edit()
	{
        $date=request()->fecha_inicio;
        $rules = [
            'id_tribunal'=>'required|',
            'fecha_inicio'=>'required|',
            'fecha_fin'=>"required|after:$date",
            'total_pagar'=>'required|',
            'neto_pagar'=>'required|',
        ];
        $messages = [
            'id_tribunal.required'=>'El tribunal es requerido',
            'fecha_inicio.required'=>'La fecha de inicio es requerida',
            'fecha_inicio.after'=>'La fecha de inicio debe ser mayor a hoy',
            'fecha_fin.required'=>'La fecha final es requerido',
            'fecha_fin.after'=>'La fecha final debe ser mayor a la inicial',
            'total_pagar.required'=>'Total a pagar es requerido',
            'neto_pagar.required'=>'Neto a pagar es requerido',
        ];
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }

        if (CuentaCobro::find(request()->id)->update(request()->except('id'))) {
            return response()->json([
                'code' =>200,
                'msg' => 'Cuenta de cobro actualizada'
            ]);
        }

    }
}
