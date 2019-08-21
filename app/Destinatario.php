<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    protected $table = 'destinatarios';
    public $timestamps = false;
    protected $fillable = [
		'nombre', 'correo'
    ];

    public function salas()
    {
        return $this->belongsToMany('App\Sala', 'destinatario_salas')->withPivot('id');
    }

    public function punto_venta()
    {
        return $this->belongsToMany('App\punto_venta', 'destinatario_punto_ventas')->withPivot('id');
    }
}
