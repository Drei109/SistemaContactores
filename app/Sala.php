<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'salas';
    public $timestamps = false;

    protected $fillable = [
		'nombre', 'direccion'
    ];

    public function destinatarios()
    {
        return $this->belongsToMany('App\Destinatario', 'destinatario_salas')->withPivot('id');
    }
}
