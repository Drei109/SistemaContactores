<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function Listar()
    {
        DB::statement("SET lc_time_names = 'es_PE';");
            $data = DB::select("SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
                                f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,
                                CASE f.estado
                                    WHEN 1 THEN 'Encendido'
                                    ELSE 'Apagado'
                                END AS estado,
                                CASE 
                                    WHEN t.horainicio <= (TIME(f.fecha_encendido) - INTERVAL 5 MINUTE) THEN 'Abrió tarde'
                                    WHEN t.horainicio >= (TIME(f.fecha_encendido) + INTERVAL 5 MINUTE) THEN 'Abrió temprano'
                                    WHEN f.fecha_encendido IS NULL THEN 'No Abrió'
                                    ELSE 'Abrió a tiempo'
                                END AS mensaje_hora_inicio,
                                CASE 
                                    WHEN t.horafin <= (TIME(f.fecha_apagado) - INTERVAL 5 MINUTE) THEN 'Cerró tarde'
                                    WHEN t.horafin >= (TIME(f.fecha_apagado) + INTERVAL 5 MINUTE) THEN 'Cerró temprano'
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
                                    SELECT pvm.cc_id, r.fecha_encendido, r.fecha_apagado, r.estado, r.MAC, r.tipo_id
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
                                WHERE dpv.destinatario_id = 2
                                ORDER BY usuario_id;");
        return response()->json(['data' => $data]);
    }
}
