<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EnviarEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:Emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia emails a los destinatarios';

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
        $today = date('H:i:s');

        $segundos = time();
        $segundos_redondeados_abajo = date('H:i:s', floor($segundos / (30 * 60)) * (30 * 60));
        $segundos_redondeados_arriba = date('H:i:s', (ceil($segundos / (30 * 60)) * (30 * 60)) - 60);
        
        $destinatarios = DB::select("SELECT *
        FROM destinatario_horas_envios dhe
        WHERE dhe.hora_envio BETWEEN ? AND ?",
        [$segundos_redondeados_abajo, $segundos_redondeados_arriba]);

        foreach ($destinatarios as $destinatario) {
            $punto_ventas = DB::select("SELECT r.local_id, pv.nombre, r.fecha_encendido, r.fecha_apagado
            FROM registro r
            LEFT JOIN punto_venta pv
            ON pv.cc_id = r.local_id
            LEFT JOIN destinatario_punto_ventas dpv
            ON pv.id = dpv.punto_venta_id
            WHERE dpv.destinatario_id = ?",
            [$destinatario->id]);

            $data = array('nombre'=> $destinatario->nombre, 'correo'=> $destinatario->correo, 'punto_ventas' => $punto_ventas);
            $this->enviarEmail($data);
        }
    }

    public function enviarEmail($data){
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        Mail::send('Mail.mail', $data, function($message) use ($correo, $nombre){
            $message    ->to($correo, $nombre)
                        ->subject('Contactores');
            $message
                        ->from('AdmiWebOnline@gmail.com','Sistema Contactores - Admin');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
}
