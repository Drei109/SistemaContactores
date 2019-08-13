<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'InicioController@DashboardView')->name('Dashboard');

#region [Seguridad]
Route::get('Empleados', 'EmpleadoController@EmpleadosVista')->name('Seguridad.Empleados');
Route::get('Usuarios', 'UsuarioController@UsuariosVista')->name('Seguridad.Usuarios');
Route::get('Roles', 'RolesController@RolesVista')->name('Seguridad.Roles');
Route::post('RolesListarJson', 'RolesController@RolesListar');
Route::post('RolesListarActivosJson', 'RolesController@RolesListarActivos');
Route::post('RolesListarInactivosJson', 'RolesController@RolesListarInActivos');
Route::get('RolesNuevo', 'RolesController@RolesNuevoVista');
Route::post('RolesCambiarEstado', 'RolesController@RolesEditarEstado');
Route::post('RolesGuardarNuevo', 'RolesController@RolesInsertar');
Route::get('Permisos', 'PermisosController@PermisosVista')->name('Seguridad.Permisos');
#endregion
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

#region[Salas]
Route::post('Salas/Listar', 'Mantenimiento\SalaController@Listar');
Route::get('Salas/Index', 'Mantenimiento\SalaController@Index');
Route::get('Salas/', 'Mantenimiento\SalaController@Index')->name('Salas.Index');
Route::get('Salas/Nuevo', 'Mantenimiento\SalaController@Nuevo');
Route::post('Salas/Guardar', 'Mantenimiento\SalaController@Guardar');
Route::post('Salas/Eliminar', 'Mantenimiento\SalaController@Eliminar');
Route::get('Salas/Editar/{id}', 'Mantenimiento\SalaController@Editar');
Route::get('Salas/Ver/{id}', 'Mantenimiento\SalaController@Ver');
Route::post('Salas/Actualizar', 'Mantenimiento\SalaController@Actualizar');
#endregion

#region[Destinatarios]
Route::post('Destinatarios/Listar', 'Mantenimiento\DestinatarioController@Listar');
Route::get('Destinatarios/Index', 'Mantenimiento\DestinatarioController@Index');
Route::get('Destinatarios/', 'Mantenimiento\DestinatarioController@Index')->name('Destinarios.Index');
Route::get('Destinatarios/Nuevo', 'Mantenimiento\DestinatarioController@Nuevo');
Route::post('Destinatarios/Guardar', 'Mantenimiento\DestinatarioController@Guardar');
Route::post('Destinatarios/Eliminar', 'Mantenimiento\DestinatarioController@Eliminar');
Route::get('Destinatarios/Editar/{id}', 'Mantenimiento\DestinatarioController@Editar');
Route::get('Destinatarios/Ver/{id}', 'Mantenimiento\DestinatarioController@Ver');
Route::post('Destinatarios/Actualizar', 'Mantenimiento\DestinatarioController@Actualizar');

Route::get('Destinatarios/{id}/Salas', 'Mantenimiento\DestinatarioController@ListarSalas');
Route::post('Destinatarios/{id}/VerSalas', 'Mantenimiento\DestinatarioController@VerSalas');
Route::get('Destinatarios/{id}/Nuevo', 'Mantenimiento\DestinatarioController@NuevaRelacionSala');
Route::get('Destinatarios/{id}/SalasNoAsignadas', 'Mantenimiento\DestinatarioController@ListarSalasNoAsignadas');
#endregion



Route::resource('Users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('Permissions', 'PermissionController');
