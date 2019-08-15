<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinatarioSalas extends Model
{
    protected $table = 'destinatarios';
    public $timestamps = false;
    protected $fillable = [
		'destinatario_id', 'sala_id'
    ];
}
