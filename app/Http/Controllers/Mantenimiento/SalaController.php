<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sala;
use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class SalaController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['role:Admin|Tecnico']);
    }

    public function Index()
    {
        app('auth')->user()->hasPermissionTo('Puede Ver Salas');
        return view('mantenimiento.salas.index');
    }

    public function Listar()
    {
        $lista = "";
        $mensaje_error = "Listar";
        $estado = true;
        try {
            $lista = Sala::all();
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function Nuevo()
    {
        return view('mantenimiento.salas.nuevo');    
    }

    public function Guardar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Guardo Correctamente";

        $Salas = new Sala();
        $Salas->nombre = $request->input('nombre');
        $Salas->direccion = $request->input('direccion');

        $data = $request->input('nombre');
        try {
            $Salas = $Salas->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'sala' => $Salas, 'mensaje' => $mensaje_error]);
    }

    public function Eliminar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Eliminó Correctamente";
        
        $id_array = $request->all();
        foreach ($id_array as $id) {
            try {
                $Sala = Sala::findOrFail($id);
                $Sala->delete();
            } catch(QueryException $ex){
                $mensaje_error = $ex->errorInfo;
                $respuesta = false;
            }
        }
        return response()->json(['respuesta' => $respuesta,'mensaje' => $mensaje_error]);
    }

    public function Editar($id)
    {
        return view('mantenimiento.salas.editar',['id'=> $id]);
    }

    public function Ver($id)
    {
        $respuesta = true;
        $mensaje_error = "Se Visualizó Correctamente";

        try {
            $sala = Sala::findOrFail($id);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'sala' => $sala, 'mensaje' => $mensaje_error]);
    }
    

    public function Actualizar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";

        try {
            $sala = Sala::findOrFail($request->id);
            $sala->nombre = $request->input('nombre');
            $sala->direccion = $request->input('direccion');
            $sala->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'sala' => $sala, 'mensaje' => $mensaje_error]);
    }
    
}
