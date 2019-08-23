<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinatarioEmail extends Model
{
    protected $table = 'destinatario_horas_envios';
    public $timestamps = false;
    protected $fillable = [
		'destinatario_id', 'hora_envio'
    ];
}
