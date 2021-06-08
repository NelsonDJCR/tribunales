<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComisionRequest;
use App\Models\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComisionController extends Controller
{
    public function store()
    {
        $rules = [
            'consepto'=>'required|',
            'valor_honorarios'=>'required|integer',
            'numero_dias'=>'required|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }        
        if (Comision::insert(request()->all())) {
            return response()->json([
                'code' =>200,
                'msg' => 'Comisión agregada con éxito'
            ]);
        }

    }

	public function listar()
	{
		return response()->json([
            'table' =>Comision::where('cuentas_cobro_id',request()->id)->where('state',1)->orderBy('id','DESC')->get()
        ]);
	}   

	public function delete()
	{
		$x = Comision::find(request()->id);
        $x->state = 0;
        $x->save();

	}

	public function edit()
	{   
        $rules = [
            'consepto'=>'required|',
            'valor_honorarios'=>'required|integer',
            'numero_dias'=>'required|integer',
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['code' => 406, 'msg' => $validator->errors()->first()]);
        }
        Comision::find(request()->id)->update(request()->all());
        return response()->json([
            'code' =>200,
            'msg' => 's'
        ]);
        #       ::find(request()->id)->update(request()->all());
	}

	public function dataEdit()
	{
          
		return response()->json([
            'data' =>Comision::find(request()->id)
        ]);
	}
}
