<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::group(['prefix' => 'auth'], function () {
    Route::post('login-user', 'API\LoginController@login');
    Route::post('registro', 'API\LoginController@registro');
    Route::get('prestamo-imprimir-pdf','API\PrestamoController@imprimirDocumento')->name('prestamos.imprimir-pdf');
//});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout-user', 'API\LoginController@logout');
    Route::apiResource('user','API\UserController');
    Route::apiResource('roles','API\RoleController');
    Route::apiResource('permisos','API\PermisoController');
    Route::apiResource('menus','API\MenuController');
    Route::apiResource('tipo-documentos','API\TipoDocumentoController');
    Route::apiResource('tipo-cuotas','API\TipoCuotaController');
    Route::apiresource('valoraciones','API\ValoracionController');
    Route::apiResource('tasa-intereses','API\TasaInteresController');
    Route::apiResource('monedas','API\MonedaController');
    Route::apiResource('medio-pagos','API\MedioPagoController');
    Route::apiResource('entidad-financieras','API\EntidadFinancieraController');
    Route::apiResource('tipo-movimientos','API\TipoMovimientoController');
    Route::apiResource('estado-operaciones','API\EstadoOperacionController');
    Route::apiResource('prestamos','API\PrestamoController');
    Route::apiResource('clientes','API\ClienteController');
    Route::apiResource('forma-pagos','API\FormaPagoController');

    //RUTAS ADMIN
    require __DIR__.'/rutasAdmin.php';

    //RUTAS PERSONAL
    require __DIR__.'/rutasPersonal.php';
});
