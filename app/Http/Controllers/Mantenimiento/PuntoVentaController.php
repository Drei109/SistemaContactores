<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\punto_venta;
use App\ubigeo;
use Illuminate\Http\Request;
use App\Sala;
use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\DB;
use App\ApiApuestaTotal\ValidarApi;

class PuntoVentaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        return view('Mantenimiento.PuntoVenta.index');
    }

    public function Listar()
    {
        $lista = "";
        $mensaje_error = "Listar";
        $estado = true;
        try {
            $lista = DB::select("SELECT 
            pv.id,
            pv.nombre,
            e.razonSocial,
            pv.cc_id,
            (SELECT u.nombre FROM ubigeo u
            WHERE u.id = pv.idUbigeo) Ubigeo,
            pv.ZonaComercial
            FROM punto_venta pv
            LEFT JOIN empresa e ON e.id = pv.idEmpresa");
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function ListarBusqueda(Request $request)
    {
        $lista = "";
        $mensaje_error = "Listar";
        $estado = true;
        $term = $request->input('query');

        try {
            $lista = DB::select("SELECT 
            pv.id,
            pv.nombre,
            e.razonSocial,
            pv.cc_id,
            (SELECT u.nombre FROM ubigeo u
            WHERE u.id = pv.idUbigeo) Ubigeo,
            pv.ZonaComercial
            FROM punto_venta pv
            LEFT JOIN empresa e ON e.id = pv.idEmpresa
            WHERE nombre LIKE '%" . $term . "%' 
            OR cc_id LIKE '%". $term ."%'");
        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }

    public function Nuevo()
    {
        app('auth')->user()->hasPermissionTo('Crear Puntos de Venta');
        return view('Mantenimiento.Salas.nuevo');    
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
        return view('Mantenimiento.PuntoVenta.editar',['id'=> $id]);
    }

    public function Ver($id)
    {
        $respuesta = true;
        $mensaje_error = "Se Visualizó Correctamente";

        try {
            $registro = DB::table('punto_venta')->where('cc_id', $id)->first();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'registro' => $registro, 'mensaje' => $mensaje_error]);
    }
    

    public function Actualizar(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";

        try {
            $registro = punto_venta::findOrFail($request->id);
            $registro->nombre = $request->input('nombre');
            $registro->cc_id = $request->input('cc_id');
            $registro->save();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
            $respuesta = false;
        }
        return response()->json(['respuesta' => $respuesta,'registro' => $registro, 'mensaje' => $mensaje_error]);
    }

    public function SincronizarPuntoVentaAPI()
    {
        $mensaje_error = "Sincronizado correctamente";
        $validar_api = new ValidarApi();
        $respuesta_api = $validar_api->ListaTiendasTokenApi();
        $respuesta_api = (string)$respuesta_api;
        $resp = json_decode($respuesta_api, true);
        $http_code = $resp['http_code'];
        if ($http_code == 200) {
            foreach ($resp['result'] as $data) {
                $data_unit_ids = $data['unit_ids'];
                $unit_ids = "";
                $ultimo_unit_id = "";
                for ($i = 0; $i < count($data_unit_ids); $i++) {
                    $data_ultimo_indice = count($data_unit_ids) - 1;
                    if ($data_ultimo_indice == $i) {
                        $unit_ids .= $data_unit_ids[$i];
                        $ultimo_unit_id = $data_unit_ids[$i];
                    } else {
                        $unit_ids .= $data_unit_ids[$i] . ",";
                        $ultimo_unit_id = $data_unit_ids[$i];
                    }
                }
                $idUbigeo = ubigeo::ObtenerDepartamento($ultimo_unit_id);
                $idZonaComercial = ubigeo::ObtenerZonaComercial($idUbigeo);
                if ($data['cc_id'] != "") {
                    $validar = punto_venta::where('cc_id', $data['cc_id'])->first();
                    if ($validar == null) {
                        $puntoventa = new punto_venta();
                        $puntoventa->nombre = $data['nombre'];
                        $puntoventa->cc_id = $data['cc_id'];
                        $puntoventa->idUbigeo = $idUbigeo;
                        $puntoventa->unit_ids = $unit_ids;
                        $puntoventa->ZonaComercial = $idZonaComercial;
                        $puntoventa->save();
                    } else {
                        $puntoventa = punto_venta::findorfail($validar->id);
                        $puntoventa->nombre = $data['nombre'];
                        $puntoventa->cc_id = $data['cc_id'];
                        $puntoventa->idUbigeo = $idUbigeo;
                        $puntoventa->unit_ids = $unit_ids;
                        $puntoventa->ZonaComercial = $idZonaComercial;
                        $puntoventa->save();
                    }
                }
            }
            $respuesta = true;
        } else {
            $mensaje_error = "El servicio de Sincronización no esta disponible en estos momentos";
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function ListarMacs($id){
        $lista = "";
        $mensaje_error = "Listado realizado correctamente";
        $estado = true;
        try {
            $lista = DB::select('SELECT * FROM punto_venta_macs pvm
            WHERE pvm.cc_id = :id
        ',['id'=> $id]);

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $estado = false;
        }
        return response()->json(['data' => $lista,'estado'=>$estado,'mensaje' => $mensaje_error]);
    }
    
    public function AsignarMacs(Request $request){
        $respuesta = true;
        $mensaje_error = "Se actualizó Correctamente";

        $cc_id = $request->input('id');
        $macs_nuevas = $request->input('data');

        try {
            $deleted = DB::delete('DELETE 
            FROM punto_venta_macs 
            WHERE cc_id = ?', [$cc_id]);

            foreach ($macs_nuevas as &$mac) {
                DB::insert('insert into punto_venta_macs 
                (cc_id, MAC) values (?, ?)', [$cc_id, $mac['MAC']]);
            }

        } catch (QueryException $ex) {
            $mensaje_error = $ex;
            $respuesta = false;
        }

        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
