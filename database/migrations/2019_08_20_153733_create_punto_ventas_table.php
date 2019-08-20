<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_venta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idEmpresa')->nullable();
            $table->unsignedInteger('idUbigeo')->nullable();
            $table->string('nombre',50)->nullable();
            $table->unsignedInteger('ZonaComercial')->nullable();
            $table->string('cc_id',50)->nullable();
            $table->string('unit_ids',50)->nullable();

            $table->foreign('idEmpresa')->references('id')->on('empresa')->onDelete('no action')->onUpdate('no action');
            $table->foreign('idUbigeo')->references('id')->on('ubigeo')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punto_ventas');
    }
}
