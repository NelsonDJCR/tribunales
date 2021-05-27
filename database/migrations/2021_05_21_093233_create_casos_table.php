<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casos', function (Blueprint $table) {

            $table->id();
            // $table->bigInteger('id_tribunal')->nullable();
            $table->foreignId('id_tribunal')->nullable()->constrained('tribunal');
            $table->foreignId('id_eleccion')->nullable()->constrained('tipo_eleccion');
            $table->foreignId('id_tramite')->nullable()->constrained('tipo_tramite');
            $table->foreignId('id_prioridad')->nullable()->constrained('prioridad');

            $table->foreignId('id_recepcion')->nullable()->constrained('medio_recepcion');
            $table->foreignId('id_estado')->nullable()->constrained('estado');
            $table->foreignId('id_departamento')->nullable()->constrained('departamentos');
            $table->foreignId('id_municipio')->nullable()->constrained('ciudades');

            $table->date('fecha_recibido');
            $table->date('fecha_eleccion');

            $table->string('direccion', 255)->nullable();
            $table->string('barrio', 255)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('correo_notificacion', 50)->nullable();
            $table->string('asunto', 255)->nullable();
            $table->string('hechos', 5000)->nullable();

            $table->tinyInteger('id_identificacion')->unsigned();
            $table->tinyInteger('id_departamento_residencia')->unsigned()->nullable();
            $table->tinyInteger('id_municipio_residencia')->unsigned()->nullable();
            $table->tinyInteger('informante_anonimo')->unsigned();

            $table->string('nombres_solicitante', 50)->nullable();
            $table->string('apellidos_solicitante', 50)->nullable();
            $table->string('num_identificacion', 15)->nullable();
            $table->string('direccion_residencia', 255)->nullable();
            $table->string('barrio_residencia', 255)->nullable();
            $table->string('telefono', 20)->nullable();

            $table->string('entidades_informadas', 255)->nullable();

            $table->bigInteger('id_asesor_asignado')->unsigned()->nullable();
            $table->string('gestion', 5000)->nullable();
            $table->date('fecha_gestion')->nullable();

            $table->timestamps();

            /*$table->foreign('id_identificacion')->references('id')->on('tipo_identificacion');
            $table->foreign('id_tribunal')->references('id')->on('tribunal');
            $table->foreign('id_tramite')->references('id')->on('tipo_tramite');
            $table->foreign('id_eleccion')->references('id')->on('tipo_eleccion');
            $table->foreign('id_departamento')->references('id')->on('departamentos');
            $table->foreign('id_municipio')->references('id')->on('ciudades');
            $table->foreign('id_estado')->references('id')->on('estado');
            $table->foreign('id_asesor_asignado')->references('id')->on('casos_seguimientos');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casos');
    }
}
