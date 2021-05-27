<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorteoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorteo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('id_magistrado')->nullable()->constrained('magistrados');
            $table->foreignId('id_tribunal')->nullable()->constrained('tribunal');
            $table->foreignId('id_tipo_eleccion')->nullable()->constrained('tipo_eleccion');
            $table->date('fecha');
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
        Schema::dropIfExists('sorteo');
    }
}
