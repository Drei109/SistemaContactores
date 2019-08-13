<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RolesController extends Controller
{
    public function RolesVista()
    {
        return view('Seguridad.Roles.RolesListarView');
    }

    public function RolesNuevoVista()
    {
        return view('Seguridad.Roles.RolesNuevoView');
    }

    public function RolesListar()
    {
        $lista = "";
        $mensaje_error = "Error Al Listar";
        $estado = true;
        try {
            $lista = Roles::all();
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function RolesListarActivos()
    {
        $lista = "";
        $mensaje_error = "Error Al Listar";
        $estado = true;
        try {
            $lista = Roles::RolesListar_Activos();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function RolesListarInActivos()
    {
        $lista = "";
        $mensaje_error = "Error Al Listar";
        $estado = true;
        try {
            $lista = Roles::RolesListar_InActivos();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function RolesInsertar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Guardo Correctamente";

        $Roles = new Roles();
        $Roles->nombre = $request->input('nombre');
        $Roles->descripcion = $request->input('descripcion');
        $Roles->estado = 1;

        $data = $request->input('nombre');
        try {
            $Roles = $Roles->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'rol' => $Roles, 'mensaje' => $mensaje_error]);
    }

    public function RolesEditar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Modifico Correctamente";
        $Roles = new Roles();
        try {
            $data = [
             'nombre'=>$request->input('nombre'), 
             'descripcion'=>$request->input('descripcion')
            ];
            $Roles = Roles::EditarRoles($data);
         } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'rol' => $Roles,'mensaje' => $mensaje_error]);
    }

    public function RolesEditarEstado(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se Cambio Estado de Registro";
        $Roles = new Roles();
        try {
            $data = [
                'id_rol'=>$request->input('id_rol'), 
                'estado'=>$request->input('estado')
            ];
            //var_dump($data);exit();
            $Roles = Roles::EditarEstadoRoles($data);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'rol' => $Roles,'mensaje' => $mensaje_error]);
    }
}
