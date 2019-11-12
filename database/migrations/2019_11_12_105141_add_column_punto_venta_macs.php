<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPuntoVentaMacs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('punto_venta_macs', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('punto_venta_macs', function (Blueprint $table) {
            $table->dropColumn('tipo_id');
        });
    }
}
