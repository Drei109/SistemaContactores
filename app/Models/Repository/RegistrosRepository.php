<?php

namespace App\Models\Repository;

use Illuminate\Support\Facades\DB;

class RegistrosRepository
{
    static $query_primera_parte = "SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
        f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,
        CASE f.estado
        WHEN 1 THEN 'Encendido'
        ELSE 'Apagado'
        END AS estado,
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
        u.name, u.email, u.id AS 'usuario_id'
        FROM
        usuario_punto_ventas upv
        LEFT JOIN users u
        ON u.id = upv.usuario_id
        LEFT JOIN punto_venta pv
        ON upv.punto_venta_id = pv.cc_id
        LEFT JOIN punto_venta_macs pvm                                
        ON pvm.cc_id = pv.cc_id
        LEFT JOIN	
        (
        SELECT pvm.cc_id, r.fecha_encendido, r.fecha_apagado, r.estado, r.MAC, r.tipo_id
        FROM registro r
        LEFT JOIN punto_venta_macs pvm
        ON pvm.MAC = r.MAC";

    static $query_primera_parte_2 = "SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
        f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,
        CASE f.estado
        WHEN 1 THEN 'Encendido'
        ELSE 'Apagado'
        END AS estado,
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
        u.name, u.email, u.id AS 'usuario_id'
        FROM
        usuario_punto_ventas upv
        LEFT JOIN users u
        ON u.id = upv.usuario_id
        LEFT JOIN punto_venta pv
        ON upv.punto_venta_id = pv.cc_id
        LEFT JOIN punto_venta_macs pvm                                
        ON pvm.cc_id = pv.cc_id
        LEFT JOIN	
        (
        SELECT pvm.cc_id, r.fecha_encendido, r.fecha_apagado, r.estado, r.MAC, r.tipo_id
        FROM registro r
        LEFT JOIN punto_venta_macs pvm
        ON pvm.MAC = r.MAC";

    static $query_where_date = " WHERE DATE(r.fecha_encendido) = DATE(NOW()) ";

    static $query_segunda_parte = " ) AS f
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
        ON tps.id = f.tipo_id ";

    static $query_general_destinatario = "SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
        f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,
        CASE f.estado
            WHEN 1 THEN 'Encendido'
            ELSE 'Apagado'
        END AS estado,
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
        ON tps.id = f.tipo_id ";

    public static function RegistrosPorUsuario($id)
    {
        $query_general = self::$query_primera_parte . self::$query_where_date . self::$query_segunda_parte;
        $where = " WHERE u.id = :id ORDER BY usuario_id;";
        $data = DB::select($query_general . $where, ['id' => $id]);
        return $data;
    }

    public static function RegistrosPorMAC($mac)
    {
        $query_general = self::$query_primera_parte . self::$query_where_date . self::$query_segunda_parte;
        $where = " WHERE pvm.MAC = :mac ORDER BY usuario_id;";
        $data = DB::select($query_general . $where, ['mac' => $mac]);
        return $data;
    }

    public static function RegistrosPorLocal($id)
    {
        $query_general = self::$query_primera_parte . self::$query_where_date . self::$query_segunda_parte;
        $where = " WHERE pv.cc_id = :id ORDER BY usuario_id;";
        $data = DB::select($query_general . $where, ['id' => $id]);
        return $data;
    }

    public static function RegistrosPorFechaYUsuario($id, $fecha)
    {
        $where_fecha = " WHERE DATE(r.fecha_encendido) = :fecha";
        $where_usuario = " WHERE u.id = :id ";
        $data = DB::select(
            self::$query_primera_parte_2 . $where_fecha . self::$query_segunda_parte . $where_usuario,
            ['fecha' => $fecha, 'id' => $id]
        );
        return $data;
    }

    public static function RegistrosPorFecha($fecha_inicio, $fecha_fin)
    {
        $where_fecha = " WHERE DATE(r.fecha_encendido) BETWEEN :fecha_inicio AND :fecha_fin ";
        $order_by = " ORDER BY usuario_id;";
        $data = DB::select(
            self::$query_primera_parte . $where_fecha . self::$query_segunda_parte . $order_by,
            ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]
        );
        return $data;
    }

    public static function RegistrosPorLocalYFecha($id, $fecha_inicio, $fecha_fin)
    {
        $where_fecha = " WHERE DATE(r.fecha_encendido) BETWEEN :fecha_inicio AND :fecha_fin ";
        $where_local = " WHERE pv.cc_id = :id ORDER BY usuario_id;";
        $data = DB::select(
            self::$query_primera_parte . $where_fecha . self::$query_segunda_parte . $where_local,
            ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'id' => $id]
        );
        return $data;
    }

    public static function RegistroHoy()
    {
        $query_general = self::$query_primera_parte . self::$query_where_date . self::$query_segunda_parte;
        $data = DB::select($query_general);
        return $data;
    }

    public static function RegistrosPorDestinatario($id)
    {
        $query_general = self::$query_general_destinatario;
        $query_where = ' WHERE dpv.destinatario_id = :id';
        $data = DB::select($query_general . $query_where, ['id' => $id]);
        return $data;
    }

    public static function SeguimientoLocalesPorUsuario($id)
    {
        $query = "SELECT pv.cc_id, pv.nombre, pvm.MAC, d.fecha,
        UNIX_TIMESTAMP(TIME(r.fecha_encendido)) AS 'hora_encendido', 
        UNIX_TIMESTAMP(TIME(r.fecha_apagado)) AS 'hora_apagado', 
        DAYNAME(d.fecha) AS dia, t.horainicio,
        CASE r.estado
          WHEN 1 THEN 'Encendido'
          ELSE 'Apagado'
        END AS estado,
        CASE 
          WHEN t.horainicio <= (TIME(r.fecha_encendido) - INTERVAL 5 MINUTE) THEN 'Abrió tarde'
          WHEN t.horainicio >= (TIME(r.fecha_encendido) + INTERVAL 5 MINUTE) THEN 'Abrió temprano'
          WHEN r.fecha_encendido IS NULL THEN 'No Abrió'
          ELSE 'Abrió a tiempo'
        END AS mensaje_hora_inicio,
        CASE 
          WHEN t.horafin <= (TIME(r.fecha_apagado) - INTERVAL 5 MINUTE) THEN 'Cerró tarde'
          WHEN t.horafin >= (TIME(r.fecha_apagado) + INTERVAL 5 MINUTE) THEN 'Cerró temprano'
          WHEN r.fecha_apagado IS NULL THEN 'No Cerró'
          ELSE 'Cerró a tiempo'
        END AS mensaje_hora_fin
        FROM usuario_punto_ventas upv
        CROSS JOIN
         (
            SELECT @curDate := DATE_SUB(@curDate, INTERVAL 1 day) AS fecha 
            FROM ( 
                    SELECT @curDate := DATE_ADD(DATE(NOW()), INTERVAL 1 day)
                ) sqlvars, ubigeo LIMIT 30
         ) AS d
        LEFT JOIN punto_venta_macs pvm
        ON pvm.cc_id = upv.punto_venta_id
        LEFT JOIN punto_venta pv
        ON pv.cc_id = pvm.cc_id
        LEFT JOIN registro r
        ON pvm.MAC = r.MAC AND
        DATE(r.fecha_encendido) = d.fecha
        LEFT JOIN
        (
          SELECT t.horainicio, t.horafin, pvm.MAC, pvm.cc_id
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
        ON t.cc_id = pvm.cc_id
        WHERE upv.usuario_id = :id
        ORDER BY d.fecha";
        $data = DB::select($query, ['id' => $id]);
        return $data;
    }
}
