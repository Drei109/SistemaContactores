<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinatarioSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinatario_salas', function (Blueprint $table) {
            $table  ->  bigIncrements('id');
            $table  ->  unsignedBigInteger('destinatario_id');
            $table  ->  unsignedBigInteger('sala_id');

            $table  ->  foreign('sala_id')
                    ->  references('id')->on('salas')
                    ->  onDelete('cascade');

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
        Schema::dropIfExists('destinatario_salas');
    }
}
