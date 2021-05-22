<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagistradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magistrados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('id_tipo_identificacion')->nullable()->constrained('tipo_identificacion');
            $table->string('numero_identificacion');
            $table->foreignId('dep_id')->nullable()->constrained('departamentos');
            $table->foreignId('ciu_id')->nullable()->constrained('ciudades');
            $table->string('direccion');
            $table->string('correo');
            $table->string('telefono');
            $table->foreignId('id_banco')->nullable()->constrained('banco');
            $table->foreignId('id_tipo_cuenta')->nullable()->constrained('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->foreignId('id_tipo_archivo')->nullable()->constrained('tipo_archivo');
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('magistrados');
    }
}
