<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tema');
            $table->text('descripcion');
            $table->foreignId('dep_id')->nullable()->constrained('departamentos');
            $table->foreignId('ciu_id')->nullable()->constrained('ciudades');
            $table->foreignId('id_magistrado')->nullable()->constrained('magistrados');
            $table->foreignId('id_tipo_archivo')->nullable()->constrained('tipo_archivo');
            $table->integer('token');
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
        Schema::dropIfExists('actividades');
    }
}
