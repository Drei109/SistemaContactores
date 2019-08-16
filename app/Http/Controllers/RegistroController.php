<?php

namespace App\Http\Controllers;

use App\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    
    public function Index()
    {
        $registros = Registro::all();
        return response()->json($registros);
    }

    public function Buscar($local_id, $fecha_encendido, $fecha_apagado)
    {
        if(isset($local_id) && !isset($fecha_encendido) && !isset($fecha_apagado)){
            $registros = 
            DB::select(" SELECT r.registro_id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE r.local_id = ?
            ORDER BY r.fecha_encendido ASC",[$local_id]);
        }elseif(isset($local_id) && isset($fecha_encendido) && isset($fecha_apagado)){
            $registros = 
            DB::select("SELECT r.registro_id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE r.local_id = :local_id 
            AND fecha_encendido BETWEEN :fecha_encendido 
            AND :fecha_apagado ORDER BY r.local_id DESC");
        }elseif(!isset($local_id) && isset($fecha_encendido) && isset($fecha_apagado)){
            $registros = 
            DB::select("SELECT r.registro_id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE fecha_encendido BETWEEN :fecha_encendido 
            AND :fecha_apagado ORDER BY r.fecha_encendido ASC");
        }
        return response()->json($registros);
    }

    public function Guardar(Request $request)
    {
        $registros = new Registro();
        $registros->local_id = $request['local_id'];
        $registros->tipo = $request['tipo'];
        $registros->fecha_encendido = $request['fecha_encendido'];
        $fecha_actual = date("Y-m-d H:i:s", strtotime("+0 day"));

        $existenRegistros = DB::statement("SELECT COUNT(*) FROM registro r WHERE
        r.local_id=". $registros->local_id ." AND DATE(r.fecha_encendido) = DATE('". $registros->fecha_encendido. "')"); 

        if($existenRegistros > 0){
            DB::update("UPDATE  registro SET tipo=? WHERE local_id =? AND DATE(fecha_encendido) = DATE(?)",
             [$registros->tipo, $registros->local_id, $registros->fecha_encendido]);
            return "Actualizado";
        }else{
            $registros->save();
            return "Creado";
        }
    }

    
    public function Actualizar(Request $request)
    {
        $registros = new Registro();
        $registros->local_id = $request['local_id'];
        $registros->tipo = $request['tipo'];
        $registros->fecha_apagado = $request['fecha_apagado'];

        DB::update("UPDATE registro 
        SET tipo=?,fecha_apagado= ? 
        WHERE local_id = ? 
        AND DATE(fecha_encendido) = DATE(?)",
        [$registros->tipo,$registros->fecha_apagado,$registros->local_id,$registros->fecha_apagado]);

        return "Actualizado";
    }

    
    public function edit(Registro $registro)
    {
        //
    }

    
    public function update(Request $request, Registro $registro)
    {
        //
    }

    
    public function destroy(Registro $registro)
    {
        //
    }
}
