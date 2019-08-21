<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinatarioPuntoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinatario_punto_ventas', function (Blueprint $table) {
            $table  ->  increments('id');
            $table  ->  unsignedBigInteger('destinatario_id');
            $table  ->  unsignedInteger('punto_venta_id');

            $table  ->  foreign('punto_venta_id')
                    ->  references('id')->on('punto_venta')
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
        Schema::dropIfExists('destinatario_punto_ventas');
    }
}
