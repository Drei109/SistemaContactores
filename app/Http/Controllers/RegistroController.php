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
        return response()->json(['data' => $registros]);
    }

    public function Buscar(Request $request)
    {
        //$local_id, $fecha_encendido, $fecha_apagado
        $registros = "";
        // return response()->json($request);
        if($request->has('local_id') && !$request->has('fecha_encendido') && !$request->has('fecha_apagado')){
            $registros = 
            DB::select(" SELECT r.id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE r.local_id = ?
            ORDER BY r.fecha_encendido ASC",[$request->post('local_id')]);
        }elseif($request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')){
            $registros = 
            DB::select("SELECT r.id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE r.local_id = ? 
            AND fecha_encendido BETWEEN ? 
            AND ? ORDER BY r.local_id DESC",[$request->post('local_id'),$request->post('fecha_encendido'),$request->post('fecha_apagado')]);
        }elseif(!$request->has('local_id') && $request->has('fecha_encendido') && $request->has('fecha_apagado')){
            $registros = 
            DB::select("SELECT r.id, r.local_id, r.tipo, r.fecha_encendido, r.fecha_apagado
            FROM registro r 
            WHERE fecha_encendido BETWEEN ? 
            AND ? ORDER BY r.fecha_encendido ASC",[$request->post('fecha_encendido'),$request->post('fecha_apagado')]);
        }
        return response()->json(['data' => $registros]);
    }

    public function Guardar(Request $request)
    {
        $registros = new Registro();
        $registros->local_id = $request['local_id'];
        $registros->tipo = $request['tipo'];
        $fecha_actual = date("Y-m-d H:i:s", strtotime("+0 day"));
        $registros->fecha_encendido =  $fecha_actual;

        $existenRegistros = DB::select("SELECT * FROM registro r WHERE
        r.local_id = ? AND DATE (r.fecha_encendido) = DATE(?)",[$registros->local_id, $fecha_actual]); 

        //return count($existenRegistros);

        if(count($existenRegistros) > 0){
            DB::update("UPDATE  registro SET tipo=? WHERE local_id =? AND DATE(fecha_encendido) = DATE(?)",
             [$registros->tipo, $registros->local_id, $fecha_actual]);
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
        $fecha_actual = date("Y-m-d H:i:s", strtotime("+0 day"));
        $registros->fecha_apagado = $fecha_actual;

        DB::update("UPDATE registro 
        SET tipo=?,fecha_apagado= ? 
        WHERE local_id = ? 
        AND DATE(fecha_encendido) = DATE(?)",
        [$registros->tipo,$registros->fecha_apagado,$registros->local_id,$registros->fecha_apagado]);

        return "Actualiza2";
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