<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPuntoVenta extends Model
{
    protected $table = 'usuario_punto_ventas';
    public $timestamps = false;

    protected $fillable = [
		'usuario_id', 'punto_venta_id'
    ];

    public static function ActualizarLocales($locales,$id)
    {
      UsuarioPuntoVenta::where('usuario_id',$id)->delete();
      foreach($locales as &$local){
        UsuarioPuntoVenta::create(['punto_venta_id' => $local, 'usuario_id' => $id]);
      }
    }
}
