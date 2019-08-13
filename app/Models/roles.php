<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Roles extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id_rol';

    public $timestamps = false;

    public $fillable = ['nombre', 'descripcion','estado'];


    public static function RolesListar_Todo()
    {
        //$listar = Roles::all();
        $listar = DB::table('roles')
            ->select('id_rol','nombre','descripcion','estado')
            ->orderBy('id_rol','desc')
            ->get();
        return $listar;
    }

    public static function RolesListar_Activos()
    {
        $listar = DB::table('roles')
            ->where('estado', 1)
            ->get();
        return $listar;
    }

    public static function RolesListar_InActivos()
    {
        $listar = DB::table('roles')
            ->where('estado', 0)
            ->get();
        return $listar;
    }

    public static function GuardarRoles($request)
    {
        $Roles = new Roles();
        $Roles->nombre = $request->input('nombre');
        $Roles->descripcion = $request->input('descripcion');
        $Roles->estado = 1;
        $Roles->save();
        return $Roles;
    }

    public static function EditarRoles($request)
    {
        $id_rol = $request['id_rol'];
        $Roles = Roles::findorfail($id_rol);
        $Roles->nombre = $request['nombre'];
        $Roles->descripcion = $request['descripcion'];
        $Roles->estado = $request['estado'];
        $Roles->save();
        return $Roles;
    }
    
    public static function EditarEstadoRoles($request)
    {
        $id_rol = $request['id_rol'];
        $Roles = Roles::findorfail($id_rol);
        $Roles->estado = $request['estado'];
        $Roles->save();
        return $Roles;
    }

    public static function EliminarRoles($request)
    {
        $id_rol = $request['id_rol'];
        $Roles = Roles::findorfail($id_rol);
        $Roles->delete();
        return $Roles;
    }
}
