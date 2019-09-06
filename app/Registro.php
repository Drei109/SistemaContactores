<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registro';
    public $timestamps = false;

    protected $fillable = [
		'local_id', 'tipo_id', 'fecha_encendido', 'fecha_apagado','estado', 'MAC'
    ];
}
