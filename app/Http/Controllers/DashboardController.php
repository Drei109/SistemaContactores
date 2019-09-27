<?php

namespace App\Http\Controllers;

use App\Models\Repository\RegistrosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function Listar($id)
    {
        DB::statement("SET lc_time_names = 'es_PE';");
        $data = RegistrosRepository::RegistrosPorUsuario($id);
        return response()->json(['data' => $data]);
    }
}
