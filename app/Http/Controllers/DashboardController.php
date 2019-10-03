<?php

namespace App\Http\Controllers;

use App\Models\Repository\RegistrosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function Listar($id)
    {
        DB::statement("SET lc_time_names = 'es_PE';");
        $data = RegistrosRepository::RegistrosPorUsuario($id);
        return response()->json(['data' => $data]);
    }

    public function SeguimientoLocales($id)
    {
        DB::statement("SET lc_time_names = 'es_PE';");
        $data = RegistrosRepository::SeguimientoLocalesPorUsuario($id);
        $arregloLabels = [];
        $arregloRegistros = [];
        $arregloFechas = [];
        foreach ($data as $value) {
            array_push($arregloLabels, $value->nombre);
            array_push($arregloFechas, $value->fecha);
        }

        $arregloFechas = array_values(array_unique($arregloFechas));
        $arregloLabels = array_unique($arregloLabels);
        foreach ($arregloLabels as $value) {
            $object = (object) [
                'nombre' => $value,
                'data' => []
            ];
            array_push($arregloRegistros, $object);
        }
        foreach ($data as $value) {
            for ($i = 0; $i < count($arregloLabels); $i++) {
                if ($arregloRegistros[$i]->nombre == $value->nombre) {
                    array_push($arregloRegistros[$i]->data, $value->hora_encendido);
                }
            }
        }

        return response()->json(['data' => $arregloRegistros, 'fechas' => $arregloFechas]);
    }
}
