<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendNotty;
use App\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\NewMessage;
use App\Models\Repository\RegistrosRepository;

class RegistroController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function Index()
    {
        DB::statement("SET lc_time_names = 'es_PE';");
        $registros = RegistrosRepository::RegistroHoy();
        return response()->json(['data' => $registros]);
    }

    public function Buscar(Request $request)
    {
        $registros = "";
        DB::statement("SET lc_time_names = 'es_PE';");

        //ONLY local_id is SET        
        if ($request->has('local_id') && !$request->has('fecha_encendido') && !$request->has('fecha_apagado')) {
            $registros = RegistrosRepository::RegistrosPorLocal($request->post('local_id'));
        }
        //EVERYTHING is SET
        elseif ($request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')) {
            $registros = RegistrosRepository::RegistrosPorLocalYFecha($request->post('local_id'), $request->post('fecha_encendido'), $request->post('fecha_apagado'));
        }
        //ONLY fecha is SET
        elseif (!$request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')) {
            $registros = RegistrosRepository::RegistrosPorFecha($request->post('fecha_encendido'), $request->post('fecha_apagado'));
        }
        //NOTHING IS SET
        else {
            $registros = RegistrosRepository::Reg;
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
        r.MAC = ? AND DATE (r.fecha_encendido) = DATE(?)", [$registros->MAC, $fecha_actual]);

        if (count($existenRegistros) > 0) {
            $registros = DB::update(
                "UPDATE  registro SET estado=? WHERE MAC =? AND DATE(fecha_encendido) = DATE(?)",
                [$registros->estado, $registros->MAC, $fecha_actual]
            );
            return "Actualizado";
        } else {
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

        DB::update(
            "UPDATE registro 
        SET estado=?,fecha_apagado= ? 
        WHERE MAC = ? 
        AND DATE(fecha_encendido) = DATE(?)",
            [$registros->estado, $registros->fecha_apagado, $registros->MAC, $registros->fecha_apagado]
        );

        if ($registros->estado == 2) {
            $this->alertarEstado($registros);
        }
        return "Actualiza2";
    }

    private function alertarEstado(Registro $registros)
    {
        $query = RegistrosRepository::RegistrosPorMAC($registros->MAC);

        foreach ($query as $q) {
            if ($q->estado === 'Encendido' && ($q->mensaje_hora_inicio === "Abrió tarde" || $q->mensaje_hora_inicio === "Abrió temprano")) {
                $mensaje_alerta = "El local: " . $q->nombre . ' ' . $q->mensaje_hora_inicio;
                event(new NewMessage($q->usuario_id, $mensaje_alerta));
                SendNotty::enviarEmailRegistro($q, $mensaje_alerta);
            } else if ($q->estado === 'Apagado' && ($q->mensaje_hora_fin === "Cerró tarde" || $q->mensaje_hora_fin === "Cerró temprano")) {
                $mensaje_alerta = "El local: " . $q->nombre . ' ' . $q->mensaje_hora_fin;
                event(new NewMessage($q->usuario_id, $mensaje_alerta));
                SendNotty::enviarEmailRegistro($q, $mensaje_alerta);
            }
        }
    }
}
