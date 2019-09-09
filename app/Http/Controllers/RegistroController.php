<?php

namespace App\Http\Controllers;

use App\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function Index()
    {
        DB::statement("SET lc_time_names = 'es_PE';");
        $registros = DB::select("SELECT pvm.cc_id, pv.nombre AS 'punto_venta', r.MAC, 
                                t.descripcion AS 'tipo', r.fecha_encendido, r.fecha_apagado, 
                                DAYNAME(r.fecha_encendido) AS dia, 
                                CASE
                                    WHEN r.estado = 1 THEN 'Encendido'
                                    WHEN r.estado = 2 THEN 'Apagado'
                                END AS estado
                                FROM registro r
                                LEFT JOIN tipos t
                                ON r.tipo_id = t.id
                                LEFT JOIN punto_venta_macs pvm
                                ON pvm.MAC = r.MAC
                                LEFT JOIN punto_venta pv
                                ON pv.cc_id = pvm.cc_id
                                WHERE DATE(r.fecha_encendido) = DATE(NOW());");
        return response()->json(['data' => $registros]);
    }

    public function Buscar(Request $request)
    {
        $registros = "";
        $base_query = "SELECT pvm.cc_id, pv.nombre AS 'punto_venta', r.MAC, 
                        t.descripcion AS 'tipo', r.fecha_encendido, r.fecha_apagado, 
                        DAYNAME(r.fecha_encendido) AS dia, 
                        CASE
                            WHEN r.estado = 1 THEN 'Encendido'
                            WHEN r.estado = 2 THEN 'Apagado'
                        END AS estado
                        FROM registro r
                        LEFT JOIN tipos t
                        ON r.tipo_id = t.id
                        LEFT JOIN punto_venta_macs pvm
                        ON pvm.MAC = r.MAC
                        LEFT JOIN punto_venta pv
                        ON pv.cc_id = pvm.cc_id";

        DB::statement("SET lc_time_names = 'es_PE';");

        //ONLY local_id is SET        
        if($request->has('local_id') && !$request->has('fecha_encendido') && !$request->has('fecha_apagado')){
            $registros = 
            DB::select($base_query . " WHERE pv.cc_id = ?",[$request->post('local_id')]);
        }
        //EVERYTHING is SET
        elseif($request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')){
            $registros = 
            DB::select($base_query . " WHERE pv.cc_id = ? 
                                    AND DATE(r.fecha_encendido) BETWEEN ? AND ?",
                                    [$request->post('local_id'),$request->post('fecha_encendido'),$request->post('fecha_apagado')]);
        }elseif(!$request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')){
            $registros = 
            DB::select($base_query . " WHERE DATE(r.fecha_encendido) BETWEEN ? AND ?",[$request->post('fecha_encendido'),$request->post('fecha_apagado')]);
        }else{
            $registros = 
            DB::select($base_query);
        }
        return response()->json(['data' => $registros]);
    }

    public function Guardar(Request $request)
    {
        $registros = new Registro();
        // $registros->local_id = $request['local_id'];
        $registros->estado = $request['estado'];
        $registros->tipo_id = $request['tipo_id'];
        $registros->MAC = $request['mac'];
        $fecha_actual = date("Y-m-d H:i:s", strtotime("+0 day"));
        $registros->fecha_encendido =  $fecha_actual;

        $existenRegistros = DB::select("SELECT * FROM registro r WHERE
        r.MAC = ? AND DATE (r.fecha_encendido) = DATE(?)",[$registros->MAC, $fecha_actual]); 

        if(count($existenRegistros) > 0){
            DB::update("UPDATE  registro SET estado=? WHERE MAC =? AND DATE(fecha_encendido) = DATE(?)",
             [$registros->estado, $registros->MAC, $fecha_actual]);
            return "Actualizado";
        }else{
            $registros->save();
            return "Creado";
        }
    }

    
    public function Actualizar(Request $request)
    {
        $registros = new Registro();
        $registros->MAC = $request['mac'];
        $registros->estado = $request['estado'];
        $fecha_actual = date("Y-m-d H:i:s", strtotime("+0 day"));
        $registros->fecha_apagado = $fecha_actual;

        DB::update("UPDATE registro 
        SET estado=?,fecha_apagado= ? 
        WHERE MAC = ? 
        AND DATE(fecha_encendido) = DATE(?)",
        [$registros->estado,$registros->fecha_apagado,$registros->MAC,$registros->fecha_apagado]);

        return "Actualiza2";
    }
}
