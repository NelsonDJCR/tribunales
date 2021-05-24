<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasosSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casos_seguimientos', function (Blueprint $table) {

            $table->id();
            $table->foreignId('id_estado')->nullable()->constrained('estado');
            $table->foreignId('id_caso')->nullable()->constrained('casos');
            $table->string('gestion', 5000)->nullable();
            $table->date('fecha_gestion');
            $table->foreignId('id_asesor_asignado')->nullable()->constrained('casos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casos_seguimientos');
    }
}
