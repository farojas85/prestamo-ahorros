<?php
//RUTAS ROLES
Route::get('role-todos','API\RoleController@todos')->name('roles.todos');
Route::get('role-habilitados','API\RoleController@habilitados')->name('roles.habilitados');
Route::get('role-eliminados','API\RoleController@eliminados')->name('roles.eliminados');
Route::post('role-destroy-temporal','API\RoleController@destroyTemporal')->name('roles.destroy-temporal');
Route::post('role-restaurar','API\RoleController@restaurar')->name('roles.restaurar');
Route::get('role-buscar','API\RoleController@buscarRol')->name('roles.buscar');
Route::get('role-lista','API\RoleController@listar')->name('roles.listas');
Route::get('time-zone','API\RoleController@mostrarFechaTimeZone');

//RUTAS USUARIOS
Route::get('usuario-todos','API\UserController@todos')->name('usuarios.todos');
Route::get('usuario-habilitados','API\UserController@habilitados')->name('usuarios.habilitados');
Route::get('usuario-eliminados','API\UserController@eliminados')->name('usuarios.eliminados');
Route::get('tipo-documento-lista','API\TipoDocumentoController@listar')->name('tipo-documentos.lista');
Route::post('verificar-numero-documento','API\UserController@verificarNumeroDocumento')->name('tipo-documentos.verificar-numero-documento');
Route::get('usuario-mostrar','API\UserController@show')->name('usuario-mostrar');
Route::post('usuario-destroy-temporal','API\UserController@destroyTemporal')->name('usuarios.destroy-temporal');
Route::post('usuario-restaurar','API\UserController@restaurar')->name('usuarios.restaurar');
Route::get('usuario-buscar','API\UserController@buscarRol')->name('usuarios.buscar');
Route::get('usuario-lista','API\UserController@listar')->name('usuarios.listas');
Route::get('usuario-cobrador-lista','API\UserController@listarCobradores')->name('usuarios.cobrador-lista');
Route::get('roles-permisos-user','API\UserController@mostrarRolesPermisosUsers')->name('permiso-role.mostrar');
Route::get('usuario-logged','API\UserController@obtenerDatosUsuario')->name('usuario-logged');
Route::get('cobrador-listar','API\UserController@ListarCobradores')->name('cobrador-listar');

//RUTAS PERMISOS
Route::get('permiso-todos','API\PermisoController@todos')->name('permisos.todos');
Route::get('permiso-habilitados','API\PermisoController@habilitados')->name('permisos.habilitados');
Route::get('permiso-eliminados','API\PermisoController@eliminados')->name('permisos.eliminados');
Route::post('permiso-destroy-temporal','API\PermisoController@destroyTemporal')->name('permisos.destroy-temporal');
Route::post('permiso-restaurar','API\PermisoController@restaurar')->name('permisos.restaurar');

//RUTAS PERMISO/ROLES
Route::get('mostrar-modelos','API\PermisoRoleController@mostrarModelos')->name('permiso-role.mostrar-modelos');
Route::get('permiso-roles','API\PermisoRoleController@mostrarRolePermisos')->name('permiso-role.mostrar-role-permisos');
Route::get('mostrar-permisos','API\PermisoRoleController@mostrarPermisos')->name('permiso-role.mostrar-permisos');
Route::post('permiso-role-guardar','API\PermisoRoleController@guardarRolePermission')->name('permiso-role.guardar');

//RUTAS MENÚS
Route::get('menus-padres','API\MenuController@obtenerPadres')->name('menus.obtenerPadres');
Route::get('menu-habilitados','API\MenuController@habilitados')->name('menus.habilitados');
Route::get('menu-todos','API\MenuController@todos')->name('menus.todos');
Route::get('menu-eliminados','API\MenuController@eliminados')->name('menus.eliminados');
Route::post('menu-destroy-temporal','API\MenuController@destroyTemporal')->name('menus.destroy-temporal');
Route::post('menu-restaurar','API\MenuController@restaurar')->name('menus.restaurar');

//RUTAS MENU/ROLES
Route::get('menu-roles','API\MenuRoleController@mostrarRoleMenus')->name('menu-role.mostrar-role-menus');
Route::get('mostrar-menus','API\MenuRoleController@mostrarMenus')->name('menu-role.mostrar-menus');
Route::post('menu-role-guardar','API\MenuRoleController@guardarRoleMenu')->name('menu-role.guardar');

//RUTAS TIPO DOCUMENTOS
Route::get('tipo-documento-todos','API\TipoDocumentoController@todos')->name('tipo-documentos.todos');
Route::get('tipo-documento-habilitados','API\TipoDocumentoController@habilitados')->name('tipo-documentos.habilitados');
Route::get('tipo-documento-eliminados','API\TipoDocumentoController@eliminados')->name('tipo-documentos.eliminados');
Route::post('tipo-documento-destroy-temporal','API\TipoDocumentoController@destroyTemporal')->name('tipo-documentos.destroy-temporal');
Route::post('tipo-documento-restaurar','API\TipoDocumentoController@restaurar')->name('tipo-documentos.restaurar');
Route::get('tipo-documento-lista','API\TipoDocumentoController@listar')->name('tipo-documentos.lista');

//RUTAS TIPO CUOTAS
Route::get('tipo-cuota-todos','API\TipoCuotaController@todos')->name('tipo-cuotas.todos');
Route::get('tipo-cuota-habilitados','API\TipoCuotaController@habilitados')->name('tipo-cuotas.habilitados');
Route::get('tipo-cuota-eliminados','API\TipoCuotaController@eliminados')->name('tipo-cuotas.eliminados');
Route::post('tipo-cuota-destroy-temporal','API\TipoCuotaController@destroyTemporal')->name('tipo-cuotas.destroy-temporal');
Route::post('tipo-cuota-restaurar','API\TipoCuotaController@restaurar')->name('tipo-cuotas.restaurar');

//RUTAS VALORACIONES
Route::get('valoracion-todos','API\ValoracionController@todos')->name('valoraciones.todos');
Route::get('valoracion-habilitados','API\ValoracionController@habilitados')->name('valoraciones.habilitados');
Route::get('valoracion-eliminados','API\ValoracionController@eliminados')->name('valoraciones.eliminados');
Route::post('valoracion-destroy-temporal','API\ValoracionController@destroyTemporal')->name('valoraciones.destroy-temporal');
Route::post('valoracion-restaurar','API\ValoracionController@restaurar')->name('valoraciones.restaurar');

//TASA INTERESES
Route::get('tasa-interes-todos','API\TasaInteresController@todos')->name('tasa-intereses.todos');
Route::get('tasa-interes-habilitados','API\TasaInteresController@habilitados')->name('tasa-intereses.habilitados');
Route::get('tasa-interes-eliminados','API\TasaInteresController@eliminados')->name('tasa-intereses.eliminados');
// Route::post('valoracion-destroy-temporal','API\ValoracionController@destroyTemporal')->name('valoraciones.destroy-temporal');
// Route::post('valoracion-restaurar','API\ValoracionController@restaurar')->name('valoraciones.restaurar');

//MONEDAS
Route::get('moneda-todos','API\MonedaController@todos')->name('monedas.todos');
Route::get('moneda-habilitados','API\MonedaController@habilitados')->name('moneras.habilitados');
Route::get('moneda-eliminados','API\MonedaController@eliminados')->name('monedas.eliminados');
Route::post('moneda-destroy-temporal','API\MonedaController@destroyTemporal')->name('monedas.destroy-temporal');
Route::post('moneda-restaurar','API\MonedaController@restaurar')->name('monedas.restaurar');

//MEDIO PAGOS
Route::get('medio-pago-todos','API\MedioPagoController@todos')->name('medio-pagos.todos');
Route::get('medio-pago-habilitados','API\MedioPagoController@habilitados')->name('moneras.habilitados');
Route::get('medio-pago-eliminados','API\MedioPagoController@eliminados')->name('medio-pagos.eliminados');
Route::post('medio-pago-destroy-temporal','API\MedioPagoController@destroyTemporal')->name('medio-pagos.destroy-temporal');
Route::post('medio-pago-restaurar','API\MedioPagoController@restaurar')->name('medio-pagos.restaurar');

//MEDIO PAGOS
Route::get('entidad-financiera-todos','API\EntidadFinancieraController@todos')->name('entidad-financieras.todos');
Route::get('entidad-financiera-habilitados','API\EntidadFinancieraController@habilitados')->name('moneras.habilitados');
Route::get('entidad-financiera-eliminados','API\EntidadFinancieraController@eliminados')->name('entidad-financieras.eliminados');
Route::post('entidad-financiera-destroy-temporal','API\EntidadFinancieraController@destroyTemporal')->name('entidad-financieras.destroy-temporal');
Route::post('entidad-financiera-restaurar','API\EntidadFinancieraController@restaurar')->name('entidad-financieras.restaurar');

//TIPO MOVIMIENTOS
Route::get('tipo-movimiento-todos','API\TipoMovimientoController@todos')->name('tipo-movimientos.todos');
Route::get('tipo-movimiento-habilitados','API\TipoMovimientoController@habilitados')->name('tipo-movimientos.habilitados');
Route::get('tipo-movimiento-eliminados','API\TipoMovimientoController@eliminados')->name('tipo-movimientos.eliminados');
Route::post('tipo-movimiento-destroy-temporal','API\TipoMovimientoController@destroyTemporal')->name('tipo-movimientos.destroy-temporal');
Route::post('tipo-movimiento-restaurar','API\TipoMovimientoController@restaurar')->name('tipo-movimientos.restaurar');

//ESTADO OPERACIONES
Route::get('estado-operacion-todos','API\EstadoOPeracionController@todos')->name('estado-operacionss.todos');
Route::get('estado-operacion-habilitados','API\EstadoOPeracionController@habilitados')->name('estado-operaciones.habilitados');
Route::get('estado-operacion-eliminados','API\EstadoOPeracionController@eliminados')->name('estado-operaciones.eliminados');
Route::post('estado-operacion-destroy-temporal','API\EstadoOPeracionController@destroyTemporal')->name('estado-operaciones.destroy-temporal');
Route::post('estado-operacion-restaurar','API\EstadoOPeracionController@restaurar')->name('estado-operaciones.restaurar');
