<?php

namespace App\Console\Commands;

use App\Events\NewMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SendNotty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:Notty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends nottys to specific users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registros = DB::select("SELECT pv.cc_id, pv.nombre, pvm.MAC, tps.descripcion AS tipo, 
                                f.fecha_encendido, f.fecha_apagado, DAYNAME(f.fecha_encendido) AS dia,
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
                                -- ON pvm.MAC = f.MAC
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
                                ORDER BY usuario_id");

        foreach($registros as $registro){
            if($registro->mensaje_hora_inicio === 'Aún no abre'){
                $mensaje_alerta = "El local: " . $registro->nombre . " aún no abre";
                event(new NewMessage($registro->usuario_id, $mensaje_alerta));
                $this->enviarEmail($registro, $mensaje_alerta);
            }
            if($registro->mensaje_hora_fin === 'Aún no cierra' && $registro->mensaje_hora_inicio !== 'Aún no abre'){
                $mensaje_alerta = "El local: " . $registro->nombre . " aún no cierra";
                event(new NewMessage($registro->usuario_id, $mensaje_alerta));
                $this->enviarEmail($registro, $mensaje_alerta);
            }
            
        }
    }

    public static function enviarEmail($data, $mensaje_alerta){
        $nombre = $data->usuario;
        $correo = $data->correo;

        $check = ['data' => $data];
        
        Mail::send('Mail.alerta', ['data' => $data], function($message) use ($correo, $nombre, $mensaje_alerta){
            $message    ->to($correo, $nombre)
                        ->subject('Contactores: ' . $mensaje_alerta);
            $message
                        ->from('AdmiWebOnline@gmail.com','Sistema Contactores - Admin');
        });
        echo "HTML Email Sent. Check your inbox. Notty \n";
    }
}
