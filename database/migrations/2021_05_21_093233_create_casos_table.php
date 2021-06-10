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

            $table->date('fecha_recibido')->nullable();
            $table->date('fecha_eleccion')->nullable();

            $table->string('direccion', 255)->nullable();
            $table->string('barrio', 255)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('puesto_votacion', 255)->nullable();
            $table->string('mesa_votacion', 50)->nullable();
            $table->string('correo_notificacion', 50)->nullable();
            $table->string('asunto', 255)->nullable();
            $table->string('hechos', 5000)->nullable();

            $table->tinyInteger('id_identificacion')->unsigned()->nullable();
            $table->tinyInteger('id_departamento_residencia')->unsigned();
            $table->tinyInteger('id_municipio_residencia')->unsigned();
            $table->tinyInteger('informante_anonimo')->unsigned();

            $table->string('nombres_solicitante', 50);
            $table->string('apellidos_solicitante', 50);
            $table->string('num_identificacion', 15);
            $table->string('direccion_residencia', 255);
            $table->string('barrio_residencia', 255);
            $table->string('telefono', 20);
            $table->string('observacion_asignacion',599)->nullable();

            $table->string('entidades_informadas', 255);

            $table->bigInteger('id_asesor_asignado')->unsigned();
            $table->string('gestion', 5000);
            $table->date('fecha_gestion');

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
