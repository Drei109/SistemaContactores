<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Destinatario;
use App\Sala;
use App\DestinatarioSalas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestinatarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin|Tecnico']);
    }

    public function Index()
    {
        app('auth')->user()->hasPermissionTo('Puede Ver Salas');
        return view('mantenimiento.destinatario.index');
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
        return view('mantenimiento.destinatario.nuevo');    
    }

    public function Guardar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Guardo Correctamente";

        $destinatario = new Destinatario();
        $destinatario->nombre = $request->input('nombre');
        $destinatario->correo = $request->input('correo');

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
        return view('mantenimiento.destinatario.editar',['id'=> $id]);
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
        return view('mantenimiento.destinatario.salas',compact('destinatario'));
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
        return view('mantenimiento.destinatario.asignarSala',compact('destinatario'));
    }

    public function ListarSalasNoAsignadas($id)
    {
        $lista = "";
        $mensaje_error = "Listado realizado correctamente";
        $estado = true;
        try {
            $lista = Sala::whereDoesntHave('destinatarios', function($q) use ($id){
                $q->where('destinatario_id', $id);
            })->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }
    
}
