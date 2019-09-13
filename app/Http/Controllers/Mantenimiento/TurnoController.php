<?php

namespace App\Http\Controllers\Mantenimiento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        return view('Mantenimiento.Turno.index');
    }

    public function Listar()
    {
        $lista = "";
        $mensaje_error = "Listar";
        $estado = true;
        try {
            $lista = DB::select("SELECT t.idlocal, pv.nombre, t.horainicio, t.horafin, t.diasemana, 
            CASE
                WHEN t.tipo = 'T' THEN 'Trabajo'
                WHEN t.tipo = 'R' THEN 'Refrigerio'
            END AS tipo
            FROM turnos t
            LEFT JOIN punto_venta pv
            ON t.idlocal = pv.cc_id");
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }
}
