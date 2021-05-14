<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tribunal', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->foreignId('dep_id')->nullable()->constrained('departamentos');
            $table->foreignId('ciu_id')->nullable()->constrained('ciudades');
            $table->foreignId('estado')->nullable()->constrained('estado');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
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
        Schema::dropIfExists('tribunal');
    }
}
