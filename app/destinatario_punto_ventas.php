<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class destinatario_punto_ventas extends Model
{
    protected $table = 'destinatario_punto_ventas';
    public $timestamps = false;
    protected $fillable = [
		'destinatario_id', 'punto_venta_id'
    ];
}
