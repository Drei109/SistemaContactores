<?php

namespace App\Http\Controllers;

use App\Funciones;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class InicioController extends Controller
{
    public function DashboardView()
    {
        return view('Inicio.DashBoardView');
    }

}
