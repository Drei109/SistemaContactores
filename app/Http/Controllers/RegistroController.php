<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendNotty;
use App\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\NewMessage;

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
            $registros = DB::update("UPDATE  registro SET estado=? WHERE MAC =? AND DATE(fecha_encendido) = DATE(?)",
            [$registros->estado, $registros->MAC, $fecha_actual]);
            return "Actualizado";
        }else{
            $registros->save();
            $this->alertarEstado($registros);
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

        $this->alertarEstado($registros);
        return "Actualiza2";
    }

    private function alertarEstado(Registro $registros){
        $query = DB::select("SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
                f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,t.horainicio,
                f.estado,
                CASE 
                    WHEN t.horainicio <= (TIME(f.fecha_encendido) - INTERVAL 5 MINUTE) THEN 'Abrió tarde'
                    WHEN t.horainicio >= (TIME(f.fecha_encendido) + INTERVAL 5 MINUTE) THEN 'Abrió temprano'
                    WHEN f.fecha_encendido IS NULL AND (TIME(t.horainicio) + INTERVAL 5 MINUTE) <= TIME(NOW()) THEN 'Aún no abre'
                    WHEN f.fecha_encendido IS NULL THEN 'No Abrió'
                    ELSE 'Abrió a tiempo'
                END AS mensaje_hora_inicio,
                CASE 
                    WHEN t.horafin <= (TIME(f.fecha_apagado) - INTERVAL 5 MINUTE) THEN 'Cerró tarde'
                    WHEN t.horafin >= (TIME(f.fecha_apagado) + INTERVAL 5 MINUTE) THEN 'Cerró temprano'
                    WHEN (TIME(t.horafin) + INTERVAL 5 MINUTE) <= TIME(NOW()) THEN 'Aún no cierra'
                    WHEN f.fecha_apagado IS NULL THEN 'No Cerró'
                    ELSE 'Cerró a tiempo'
                END AS mensaje_hora_fin,
                d.correo, d.nombre AS usuario, d.id AS usuario_id
                FROM
                destinatario_punto_ventas dpv
                LEFT JOIN destinatarios d
                ON d.id = dpv.destinatario_id
                LEFT JOIN punto_venta pv
                ON dpv.punto_venta_id = pv.id
                LEFT JOIN punto_venta_macs pvm
                ON pvm.cc_id = pv.cc_id
                LEFT JOIN	
                (
                    SELECT pvm.cc_id, r.fecha_encendido, r.fecha_apagado, r.estado, r.MAC, r.tipo_id, r.id
                    FROM registro r
                    LEFT JOIN punto_venta_macs pvm
                    ON pvm.MAC = r.MAC
                    WHERE DATE(r.fecha_encendido) = DATE(NOW())
                ) AS f
                ON f.MAC = pvm.MAC
                LEFT JOIN
                (
                    SELECT t.horainicio, t.horafin, pvm.MAC
                    FROM turnos t
                    LEFT JOIN punto_venta_macs pvm
                    ON t.idlocal = pvm.cc_id
                    WHERE 
                    DAYOFWEEK(NOW()) = CASE t.diasemana
                        WHEN 'Do' THEN 1
                        WHEN 'Lu' THEN 2
                        WHEN 'Ma' THEN 3
                        WHEN 'Mi' THEN 4
                        WHEN 'Ju' THEN 5
                        WHEN 'Vi' THEN 6
                        WHEN 'Sa' THEN 7
                        END
                ) AS t
                ON t.MAC = pvm.MAC
                LEFT JOIN tipos tps
                ON tps.id = f.tipo_id 
                WHERE pvm.MAC = ?", [$registros->MAC]);

        foreach($query as $q){
            if($q->estado === 1 && ($q->mensaje_hora_inicio === "Abrió tarde" || $q->mensaje_hora_inicio === "Abrió temprano" )){
                $mensaje_alerta = "El local: " . $q->nombre . $q->mensaje_hora_inicio;
                event(new NewMessage($q->usuario_id,$mensaje_alerta));
                SendNotty::enviarEmail($q,$mensaje_alerta);
            }
            
            else if($q->estado === 2 && ($q->mensaje_hora_fin === "Cerró tarde" || $q->mensaje_hora_fin === "Cerró temprano")){
                $mensaje_alerta = "El local: " . $q->nombre . $q->mensaje_hora_fin;
                event(new NewMessage($q->usuario_id,"El local: " . $q->mensaje_hora_fin));
                SendNotty::enviarEmail($q,$mensaje_alerta);
            }
        }
    }
}
