<?php

namespace App\Http\Controllers;

use App\Funciones;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function DashboardView()
    {
        if (Auth::check()) {
            return view('Inicio.DashBoardView');
        }
        return redirect('login');
    }

}
