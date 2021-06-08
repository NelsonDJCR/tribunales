<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuentas_cobro_id')->constrained('cuentas_cobro');
            $table->string('consepto')->nullable();
            $table->float('valor_honorarios');
            $table->integer('numero_dias');
            $table->float('valor_factura')->nullable();
            $table->float('valor_bruto')->nullable();
            $table->float('total_pagar')->nullable();
            $table->float('retefuente')->nullable();
            $table->float('rete_iva')->nullable();
            $table->float('rete_ica')->nullable();
            $table->float('neto_pagar')->nullable();
            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comisiones');
    }
}
