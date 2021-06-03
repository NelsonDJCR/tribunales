<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMagistrados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magistrados', function (Blueprint $table) {
            $table->string('cargo');
            $table->foreignId('tribunal_id')->nullable()->constrained('tribunal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magistrados', function (Blueprint $table) {
            $table->dropColumn('cargo');
            $table->dropForeign(['tribunal_id']);
            $table->dropColumn('tribunal_id');
        });
    }
}
