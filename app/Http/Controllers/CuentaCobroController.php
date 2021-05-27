<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Sorteo;
use Illuminate\Http\Request;

class CuentaCobroController extends Controller
{
    public function table(Request $r)
    {
        return response()->json([
            'table' => CuentaCobro::where('estado',1)->with('tribunal','magistrado')->get()           
        ]);
    }
}
