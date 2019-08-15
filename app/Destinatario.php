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
}
