<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\ActividadSoporte;
use App\Models\CuentaCobro;
use App\Models\CuentaSoporte;
use App\Models\Documento;
use App\Models\Magistrado;
use App\Models\Sorteo;
use App\Models\TipoArchivo;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CuentaCobroController extends Controller
{
    public function table(Request $r)
    {
        return response()->json([
            'table' => CuentaCobro::where('estado', 1)->with('tribunal', 'magistrado')->orderBy('id', 'DESC')->get()
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

    public function update(Request $request)
    {
        // return $request->all();
        $date = request()->fecha_inicio;
        $rules = [
            'id_tribunal' => 'required|',
            'id_magistrado' => 'required|',
            'fecha_inicio' => 'required|',
            'fecha_fin' => "required|after:$date",
            'total_pagar' => 'required|max:99999999|numeric',
            'neto_pagar' => 'required|max:99999999|numeric',
            'valor_honorarios' => 'required|max:99999999999',
            'numero_dias' => 'required|max:99999999999',
            'valor_bruto' => 'required|max:9999999999|numeric',
            'valor_factura' => 'required|max:9999999999|numeric',
            'rete_iva' => 'required|max:9999999999|numeric',
            'rete_ica' => 'required|max:99999999|numeric',
        ];
        $messages = [
            'id_tribunal.required' => 'El tribunal es requerido',
            'id_magistrado.required' => 'El magistrado es requerido',
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_inicio.after' => 'La fecha de inicio debe ser mayor a hoy',
            'fecha_fin.required' => 'La fecha final es requerido',
            'fecha_fin.after' => 'La fecha final debe ser mayor a la inicial',
            'valor_honorarios.required' => 'Valor honorario es requerido',
            'valor_honorarios.max' => 'El valor de los honorarios debe tener máximo 11 digitos',
            'numero_dias.required' => 'El números de días es requerido',
            'numero_dias.max' => 'El número de días debe tener máximo 11 digitos',
            'valor_bruto.required' => 'Valor bruto es requerido',
            'valor_bruto.max' => 'El valor bruto de los honorarios debe tener máximo 11 digitos',
            'valor_factura.required' => 'Valor factura es requerido',
            'valor_factura' => 'El valor de la factura debe tener máximo 8 digitos',
            'valor_factura.numeric' => 'El valor de la factura debe ser numérico',
            'valor_factura.max' => 'El valor de la factura no puede exceder los 10 dígitos',
            'total_pagar.required' => 'Total a pagar es requerido',
            'rete_fuente.required' => 'Rete fuente es requerido',
            'rete_iva.required' => 'Rete iva es requerido',
            'rete_iva.numeric' => 'El campo Rete IVA debe ser numérico',
            'rete_iva.max' => 'el valor de rete iva debe tener máximo 8 digitos',
            'rete_ica.required' => 'Rete ica  es requerido',
            'rete_ica.max' => 'el valor de rete ica debe tener máximo 8 digitos',
            'rete_ica.numeric' => 'El campo Rete ICA debe ser numérico',
            'neto_pagar.required' => 'Neto a pagar es requerido',
            'neto_pagar.max' => 'El valor neto a pagar debe tener máximo 8 digitos',
            'neto_pagar.numeric' => 'El campo Neto a pagar debe ser numérico',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }


        for ($x = 0; $x < $request->cant_eliminados; $x++) {
            $documento = Documento::find($request["e_id$x"]);
            $documento->estado = '0';
            $documento->save();
        }

        $cuenta = CuentaCobro::find($request->id);
        $cuenta->id_tribunal = $request->id_tribunal;
        $cuenta->id_magistrado = $request->id_magistrado;
        $cuenta->fecha_inicio = $request->fecha_inicio;
        $cuenta->fecha_fin = $request->fecha_fin;
        $cuenta->valor_honorarios = $request->valor_honorarios;
        $cuenta->numero_dias = $request->numero_dias;
        $cuenta->valor_bruto = $request->valor_bruto;
        $cuenta->valor_factura = $request->valor_factura;
        $cuenta->total_pagar = $request->total_pagar;
        $cuenta->rete_fuente = $request->rete_fuente;
        $cuenta->rete_iva = $request->rete_iva;
        $cuenta->rete_ica = $request->rete_ica;
        $cuenta->neto_pagar = $request->neto_pagar;
        $cuenta->save();

        for ($x = 0; $x < $request->cantidad; $x++) {
            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->estado = 1;
                $documento->save();

                $soporte = new CuentaSoporte();
                $soporte->id_cuenta = $cuenta->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }


        return response()->json([
            'status' => 200,
            'msg' => 'Lista de cobro editada con éxito',
        ]);
    }

    public function save(Request $request)
    {
        // return strlen($request->numero_dias);
        // return $request->all();
        $date = request()->fecha_inicio;
        $rules = [
            'id_tribunal' => 'required|',
            'id_magistrado' => 'required|',
            'fecha_inicio' => 'required|',
            'fecha_fin' => "required|after:$date",
            'total_pagar' => 'required|max:8',
            'neto_pagar' => 'required|max:8',
            'valor_honorarios' => 'required|max:11',
            'numero_dias' => 'required|max:11',
            'valor_bruto' => 'required|max:8',
            'valor_factura' => 'required|max:99999999|integer',
            'rete_iva' => 'required|max:8',
            'rete_ica' => 'required|max:8',
            'neto_pagar' => 'required|max:8',
        ];
        $messages = [
            'id_tribunal.required' => 'El tribunal es requerido',
            'id_magistrado.required' => 'El magistrado es requerido',
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_inicio.after' => 'La fecha de inicio debe ser mayor a hoy',
            'fecha_fin.required' => 'La fecha final es requerido',
            'fecha_fin.after' => 'La fecha final debe ser mayor a la inicial',
            'valor_honorarios.required' => 'Valor honorario es requerido',
            'valor_honorarios.max' => 'El valor de los honorarios debe tener máximo 11 digitos',
            'numero_dias.required' => 'El números de días es requerido',
            'numero_dias.max' => 'El número de días debe tener máximo 11 digitos',
            'valor_bruto.required' => 'Valor bruto es requerido',
            'valor_bruto.max' => 'El valor bruto de los honorarios debe tener máximo 11 digitos',
            'valor_factura.required' => 'Valor factura es requerido',
            'valor_factura' => 'El valor de la factura debe tener máximo 8 digitos',
            'valor_factura.integer' => 'El valor de la factura debe ser numérico',
            'total_pagar.required' => 'Total a pagar es requerido',
            'rete_fuente.required' => 'Rete fuente es requerido',
            'rete_iva.required' => 'Rete iva es requerido',
            'rete_iva.max' => 'el valor de rete iva debe tener máximo 8 digitos',
            'rete_ica.required' => 'Rete ica  es requerido',
            'rete_ica.max' => 'el valor de rete ica debe tener máximo 8 digitos',
            'neto_pagar.required' => 'Neto a pagar es requerido',
            'neto_pagar.max' => 'El valor neto a pagar debe tener máximo 8 digitos'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => 406, 'msg' => $validator->errors()->first()]);
        }

        $cuenta = new CuentaCobro();
        $cuenta->id_tribunal = $request->id_tribunal;
        $cuenta->id_magistrado = $request->id_magistrado;
        $cuenta->fecha_inicio = $request->fecha_inicio;
        $cuenta->fecha_fin = $request->fecha_fin;
        $cuenta->valor_honorarios = $request->valor_honorarios;
        $cuenta->numero_dias = $request->numero_dias;
        $cuenta->valor_bruto = $request->valor_bruto;
        $cuenta->valor_factura = $request->valor_factura;
        $cuenta->total_pagar = $request->total_pagar;
        $cuenta->rete_fuente = $request->rete_fuente;
        $cuenta->rete_iva = $request->rete_iva;
        $cuenta->rete_ica = $request->rete_ica;
        $cuenta->neto_pagar = $request->neto_pagar;
        $cuenta->save();

        for ($x = 0; $x < $request->cantidad; $x++) {
            if ($request->hasFile("archivo$x")) :
                $file = $request->file("archivo$x");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $documento = new Documento();
                $documento->id_subserie = 1;
                $documento->id_tipo_documento = $request["tipo_archivo$x"];
                $documento->nombre = $fileName;
                $documento->ruta = 'uploads/' . $fileName;
                $documento->estado = 1;
                $documento->save();

                $soporte = new CuentaSoporte();
                $soporte->id_cuenta = $cuenta->id;
                $soporte->id_documento = $documento->id;
                $soporte->save();

                $request["archivo$x"]->move(public_path('uploads'), $fileName);
            endif;
        }

        return response()->json([
            'status' => 200,
            'msg' => 'Cuenta de cobro agregada con éxito',
        ]);
    }

    public function record(Request $request)
    {
        $documentos = DB::table('cuenta_soporte')
            ->select(
                'documento.id',
                'documento.id_tipo_documento',
                'documento.nombre',
                'documento.ruta',
            )->join('documento', 'documento.id', 'cuenta_soporte.id_documento')
            ->where('documento.estado', '1')
            ->where('id_cuenta', $request->id)->get();
        return response()->json([
            'data' => CuentaCobro::where('id', $request->id)->with('magistrado', 'tribunal')->first(),
            'tipo_archivos' => TipoArchivo::all()->where('estado', 1),
            'tribunales' => Tribunal::where('estado', 1)->get(),
            'documentos' => $documentos,
        ]);
    }

    public function magistradosxtribunal($id)
    {
        $funcionarios = Magistrado::where('tribunal_id', $id)->get();
        return response()->json([
            'funcionarios' => $funcionarios,
        ]);
    }
}
