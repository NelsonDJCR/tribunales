<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class SorteoDepartamentoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $departamentos = array(
            array(
                'departamentos_id'          => 5,
            ),
            array(
                'departamentos_id'          => 8,
            ),
            array(
                'departamentos_id'          => 13,
            ),
            array(
                'departamentos_id'          => 15,
            ),
            array(
                'departamentos_id'          => 17,
            ),
            array(
                'departamentos_id'          => 18,
            ),

            array(
                'departamentos_id'          => 19,
            ),
            array(
                'departamentos_id'          => 20,
            ),
            array(
                'departamentos_id'          => 23,
            ),
            array(
                'departamentos_id'          => 25,
            ),
            array(
                'departamentos_id'          => 27,
            ),
            array(
                'departamentos_id'          => 41,
            ),
            array(
                'departamentos_id'          => 44,
            ),
            array(
                'departamentos_id'          => 47,
            ),
            array(
                'departamentos_id'          => 50,
            ),
            array(
                'departamentos_id'          => 52,
            ),
            array(
                'departamentos_id'          => 54,
            ),
            array(
                'departamentos_id'          => 63,
            ),
            array(
                'departamentos_id'          => 66,
            ),
            array(
                'departamentos_id'          => 68,
            ),
            array(
                'departamentos_id'          => 70,
            ),
            array(
                'departamentos_id'          => 73,
            ),
            array(
                'departamentos_id'          => 76,
            ),
            array(
                'departamentos_id'          => 81,
            ),
            array(
                'departamentos_id'          => 85,
            ),
            array(
                'departamentos_id'          => 86,
            ),
            array(
                'departamentos_id'          => 88,
            ),
            array(
                'departamentos_id'          => 91,
            ),
            array(
                'departamentos_id'          => 94,
            ),
            array(
                'departamentos_id'          => 95,
            ),
            array(
                'departamentos_id'          => 97,
            ),
            array(
                'departamentos_id'          => 99,
            ),
           
        );
                 

        foreach($departamentos as $departamento)
        {
            DB::connection('dinamico')->table('sorteo_departamentos')->insert($departamento);
    
        }
      
    }
}
