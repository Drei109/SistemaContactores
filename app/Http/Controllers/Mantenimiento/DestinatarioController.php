<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Destinatario;
use App\Sala;
use App\DestinatarioSalas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DestinatarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        return view('Mantenimiento.Destinatario.index');
    }

    public function Listar()
    {
        $lista = "";
        $mensaje_error = "Listar";
        $estado = true;
        try {
            $lista = Destinatario::all();
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function Nuevo()
    {
        return view('Mantenimiento.Destinatario.nuevo');    
    }

    public function Guardar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Guardo Correctamente";

        $destinatario = new Destinatario();
        $destinatario->nombre = $request->input('nombre');
        $destinatario->correo = $request->input('correo');
        $destinatario->correo_hora = $request->input('correo_hora');

        try {
            $destinatario = $destinatario->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'objeto' => $destinatario, 'mensaje' => $mensaje_error]);
    }

    public function Eliminar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Eliminó Correctamente";
        
        $id_array = $request->all();
        foreach ($id_array as $id) {
            try {
                $destinatario = Destinatario::findOrFail($id);
                $destinatario->delete();
            } catch(QueryException $ex){
                $mensaje_error = $ex->errorInfo;
                $respuesta = false;
            }
        }
        return response()->json(['respuesta' => $respuesta,'mensaje' => $mensaje_error]);
    }

    public function Editar($id)
    {
        return view('Mantenimiento.Destinatario.editar',['id'=> $id]);
    }

    public function Ver($id)
    {
        $respuesta = true;
        $mensaje_error = "Se Visualizó Correctamente";

        try {
            $destinatario = Destinatario::findOrFail($id);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'objeto' => $destinatario, 'mensaje' => $mensaje_error]);
    }
    

    public function Actualizar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";

        try {
            $destinatario = Destinatario::findOrFail($request->id);
            $destinatario->nombre = $request->input('nombre');
            $destinatario->correo = $request->input('correo');
            $destinatario->correo_hora = $request->input('correo_hora');
            $destinatario->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'objeto' => $destinatario, 'mensaje' => $mensaje_error]);
    }

    public function ListarSalas($id)
    {
        $destinatario = Destinatario::find($id);
        return view('Mantenimiento.Destinatario.salas',compact('destinatario'));
    }

    public function VerSalas($id)
    {
        $lista = "";
        $mensaje_error = "Listado realizado correctamente";
        $estado = true;
        try {
            $lista = Destinatario::find($id)->salas()->get();
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function NuevaRelacionSala($id)
    {
        $destinatario = Destinatario::find($id);
        return view('Mantenimiento.Destinatario.asignarSala',compact('destinatario'));
    }

    public function ListarSalasNoAsignadas($id)
    {
        $lista = "";
        $mensaje_error = "Listado realizado correctamente";
        $estado = true;
        try {
            $lista = DB::select('SELECT pv.id, pv.cc_id ,pv.nombre AS "nombre", u.nombre AS "ubigeo", (
                SELECT EXISTS( SELECT * 
                FROM destinatario_punto_ventas dpv
                WHERE pv.id = dpv.punto_venta_id
                AND dpv.destinatario_id = :id)) AS "tiene"
                FROM punto_venta pv
                LEFT JOIN ubigeo u
                ON u.id = pv.idUbigeo
        ',['id'=> $id]);

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }
    
    public function ReasignarSalas(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";
        
        try {
            $id = $request->input('id');
            $delete = DB::delete('delete from destinatario_punto_ventas where destinatario_id = ?', [$id]);
            
            $salas_id = $request->input('salas_id');
            foreach ($salas_id as &$sala_relacion) {
                DB::insert('insert into destinatario_punto_ventas (destinatario_id, punto_venta_id) values (?, ?)', [$id, $sala_relacion]);
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'objeto' => $delete, 'mensaje' => $mensaje_error]);
    }

    public function ListarHoras($id){
        $lista = "";
        $mensaje_error = "Listado realizado correctamente";
        $estado = true;
        try {
            $lista = DB::select('SELECT * FROM destinatario_horas_envios dhe
            WHERE dhe.destinatario_id = :id
        ',['id'=> $id]);

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function ReasignarHoras(Request $request){
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";

        $destinatario_id = $request->input('id');
        $horas_nuevas = $request->input('data');

        try {
            $deleted = DB::delete('DELETE 
            FROM destinatario_horas_envios 
            WHERE destinatario_id = ?', [$destinatario_id]);

            foreach ($horas_nuevas as &$horanueva) {
                DB::insert('insert into destinatario_horas_envios 
                (destinatario_id, hora_envio) values (?, ?)', [$destinatario_id, $horanueva['hora_envio']]);
            }

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $respuesta = false;
        }

        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
