<?php

namespace App;

use App\ApiApuestaTotal\ValidarApi;
use DB;
use Illuminate\Database\Eloquent\Model;

class ubigeo extends Model
{
    protected $table = 'ubigeo';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public $fillable = ['cod_depa', 'cod_prov', 'cod_dist', 'nombre', 'estado'];

    public static function UbigeoPaisListarJson()
    {
        $listar = DB::table('ubigeo')
            ->where('cod_prov', '00')
            ->where('cod_dist', '00')
            ->get();
        return $listar;
    }

    public static function ObtenerUbigeoJson($idUbigeo)
    {
        $ubigeo = DB::table('ubigeo')->where([
            ['id', '=', $idUbigeo],
            ['cod_prov', '=', 0],
            ['cod_dist', '=', 0]
        ])->first();
        return $ubigeo;
    }

    public static function ObtenerDepartamento($unit_id)
    {
        static $counter = 1;
        $valor = new ValidarApi();

        if($counter >= 2){
            usleep(700000);
            $counter = 1;
        }

        // if($counter >= 20){
        //     usleep(5000000);
        //     $counter = 1;
        // }
        
        $resultado = $valor->consultarLocal($unit_id);
        $counter++;

        $departamento = $resultado['result']['ubigeo_id'];
        if (strlen($departamento) > 2) {
            $departamento = substr($departamento, 0, 2);
        }
        $idUbigeo = Ubigeo::ObtenerIdUbigeoDepartamento($departamento);
        if($idUbigeo != null){
            return $idUbigeo->id;
        }
        return $departamento;
    }

    public static function ObtenerIdUbigeoDepartamento($idDepartamento){
        $data = DB::table('ubigeo')
            ->where('cod_prov','00')
            ->where('cod_dist','00')
            ->where('cod_depa',$idDepartamento)
            ->first();
        return $data;
    }

    public static function ObtenerZonaComercial($idDepartamento)
    {

        $zona = 0;
        $ubigeo = Ubigeo::ObtenerUbigeoJson($idDepartamento);

        switch ($ubigeo->nombre) {
            case (strtoupper($ubigeo->nombre) == 'ANCASH' || strtoupper($ubigeo->nombre) == 'CAJAMARCA' || strtoupper($ubigeo->nombre) == 'LA LIBERTAD' ||
                strtoupper($ubigeo->nombre) == 'LAMBAYEQUE' || strtoupper($ubigeo->nombre) == 'PIURA' || strtoupper($ubigeo->nombre) == 'TUMBES'):
                $zona = 1;
                break;
            case (strtoupper($ubigeo->nombre) == 'AMAZONAS' || strtoupper($ubigeo->nombre) == 'LORETO' || strtoupper($ubigeo->nombre) == 'SAN MARTIN' ||
                strtoupper($ubigeo->nombre) == 'UCAYALI'):
                $zona = 2;
                break;
            case (strtoupper($ubigeo->nombre) == 'CALLAO' || strtoupper($ubigeo->nombre) == 'HUANUCO' || strtoupper($ubigeo->nombre) == 'JUNIN' ||
                strtoupper($ubigeo->nombre) == 'LIMA'):
                $zona = 3;
                break;
            case (strtoupper($ubigeo->nombre) == 'AREQUIPA' || strtoupper($ubigeo->nombre) == 'AYACUCHO' || strtoupper($ubigeo->nombre) == 'CUSCO' ||
                strtoupper($ubigeo->nombre) == 'ICA' || strtoupper($ubigeo->nombre) == 'MOQUEGUA' || strtoupper($ubigeo->nombre) == 'PUNO' || strtoupper($ubigeo->nombre) == 'TACNA'):
                $zona = 4;
                break;
        }
        return $zona;

    }
}
