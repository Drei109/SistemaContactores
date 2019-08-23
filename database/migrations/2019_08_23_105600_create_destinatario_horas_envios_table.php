<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinatarioHorasEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinatario_horas_envios', function (Blueprint $table) {
            $table->increments('id');
            $table  ->  unsignedBigInteger('destinatario_id');
            $table  ->  time('hora_envio');
            $table  ->  foreign('destinatario_id')
                    ->  references('id')->on('destinatarios')
                    ->  onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinatario_horas_envios');
    }
}
