<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turnos';
    public $timestamps = false;
    protected $fillable = [
		'idturnoexterno', 'horainicio', 'horafin', 'diasemana', 'idlocal', 'tipo'
    ];
}
