<?php

namespace App\Console\Commands;

use App\Events\NewMessage;
use App\Models\Repository\RegistrosRepository;
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
        $registros = RegistrosRepository::RegistroHoy();

        foreach ($registros as $registro) {
            if ($registro->mensaje_hora_inicio === 'Aún no abre') {
                $mensaje_alerta = "El local: " . $registro->nombre . " aún no abre";
                event(new NewMessage($registro->usuario_id, $mensaje_alerta));
                $this->enviarEmail($registro, $mensaje_alerta);
            }
            if ($registro->mensaje_hora_fin === 'Aún no cierra' && $registro->mensaje_hora_inicio !== 'Aún no abre') {
                $mensaje_alerta = "El local: " . $registro->nombre . " aún no cierra";
                event(new NewMessage($registro->usuario_id, $mensaje_alerta));
                $this->enviarEmail($registro, $mensaje_alerta);
            }
        }
    }

    public static function enviarEmail($data, $mensaje_alerta)
    {
        $nombre = $data->name;
        $correo = $data->email;

        $check = ['data' => $data];

        Mail::send('Mail.alerta', ['data' => $data], function ($message) use ($correo, $nombre, $mensaje_alerta) {
            $message->to($correo, $nombre)
                ->subject('Contactores: ' . $mensaje_alerta);
            $message
                ->from('AdmiWebOnline@gmail.com', 'Sistema Contactores - Admin');
        });
        echo "HTML Email Sent. Check your inbox. Notty \n";
    }
}
