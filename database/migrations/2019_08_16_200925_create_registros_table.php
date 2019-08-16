<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('local_id');
            $table->smallInteger('tipo');
            $table->dateTime('fecha_encendido');
            $table->dateTime('fecha_apagado')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
