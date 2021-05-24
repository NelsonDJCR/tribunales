<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Caso;
//use Log;

class CasosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        // if ($buscar=='') {
            $casos = Caso::with('caso')->orderBy('id', 'desc')->paginate(10);
            //Log::info($casos);
            // $casos = Caso::join('casos_seguimientos', 'casos_seguimientos.id_caso','=','casos.id')
            // ->select('casos.*','casos_seguimientos.id_caso')
            // ->orderBy('id', 'desc')->paginate(10);
            // var_dump("sin buscando");
            // print_r($buscar);
        // }else{
        //     $casos = Caso::join('casos_seguimientos','casos.id','=','casos_seguimientos.id_caso')
        //     ->select('casos.*','casos_seguimientos.id_caso')
            /*->where('casos.'.$criterio, 'like', '%'. $buscar . '%')*/
            // ->orderBy('id', 'desc')->paginate(10);
        // }
        return response()->json([
            'pagination' => [
                'total'        => $casos->total(),
                'current_page' => $casos->currentPage(),
                'per_page'     => $casos->perPage(),
                'last_page'    => $casos->lastPage(),
                'from'         => $casos->firstItem(),
                'to'           => $casos->lastItem(),
            ],
            'casos' => $casos
        ]);
        /*return response()->json([
            'casos' => $casos,
            'status' => 200
          ],200);*/
        /*$casos->map(function($caso) {
            $data = collect($caso);
            //$data->put('owner', $caso->user);
            return $data->all();
        });
        return response()->json([
            'pagination' => [
                'total'        => $casos->total(),
                'current_page' => $casos->currentPage(),
                'per_page'     => $casos->perPage(),
                'last_page'    => $casos->lastPage(),
                'from'         => $casos->firstItem(),
                'to'           => $casos->lastItem(),
            ],
            'casos' => $casos,
            'status' => 200
        ]);*/
        // $result = array('success'=>true,'casos'=>$casos);

        // return Response()->json($result);
    }



    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
