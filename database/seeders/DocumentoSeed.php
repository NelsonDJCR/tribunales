<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documento = new Documento();
        $documento->nombre = 'Formato_cargue_masivo_casos.xlsx';
        $documento->ruta = 'uploads/'.$documento->nombre;
        $documento->id_subserie = 1;
        $documento->id_tipo_documento = 1;
        $documento->save();
    }
}
