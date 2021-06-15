<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorteoDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorteo_departamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamentos_id')->constrained('departamentos');
            $table->integer('cantidad')->nullable();
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
        Schema::dropIfExists('sorteo_departamentos');
    }
}
