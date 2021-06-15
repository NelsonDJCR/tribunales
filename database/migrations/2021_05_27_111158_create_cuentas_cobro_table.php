<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasCobroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_cobro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tribunal')->nullable()->constrained('tribunal');
            $table->foreignId('id_magistrado')->nullable()->constrained('magistrados');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('valor_honorarios')->nullable();
            $table->integer('numero_dias')->nullable();
            $table->float('valor_bruto')->nullable();
            $table->float('valor_factura')->nullable();
            $table->float('total_pagar');
            $table->float('rete_fuente')->nullable();
            $table->float('rete_iva')->nullable();
            $table->float('rete_ica')->nullable();
            $table->float('neto_pagar');
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
        Schema::dropIfExists('cuentas_cobro');
    }
}
