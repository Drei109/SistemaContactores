<?php

namespace App\Http\Controllers\Auth;

use App\ValidarApi;
use App\UsuarioPuntoVenta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'password');

        // $validar_api = new ValidarApi();
        // $respuesta_api = $validar_api->ValidarLoginTokenApi($request->input('name'), $request->input('password'));
        // $respuesta_api = (string) $respuesta_api;
        // $respuesta = json_decode($respuesta_api, true);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if ($user->hasRole('Usuario')) {
                //UsuarioPuntoVenta::ActualizarLocales($respuesta['result']['locales'], $user->id);
                return redirect()->intended('/');
            }
            return redirect()->intended('/Reportes');
        }
        // else {
        //     if ($respuesta['http_code'] == 202) {
        //         app('App\Http\Controllers\UserController')->store($request);
        //         Auth::attempt($credentials);
        //         $user = auth()->user();
        //         $user->assignRole("Usuario");

        //         UsuarioPuntoVenta::ActualizarLocales($respuesta['result']['locales'], $user->id);

        //         return redirect()->intended('/');
        //     }
        //     return redirect('login');
        // }
    }
}
