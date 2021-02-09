<?php

//PRÉSTAMOS
Route::get('prestamo-todos','API\PrestamoController@todos')->name('prestamos.todos');
Route::get('prestamo-habilitados','API\PrestamoController@habilitados')->name('prestamos.habilitados');
Route::get('prestamo-eliminados','API\PrestamoController@eliminados')->name('prestamos.eliminados');
Route::post('prestamo-destroy-temporal','API\PrestamoController@destroyTemporal')->name('prestamos.destroy-temporal');
Route::post('prestamo-restaurar','API\PrestamoController@restaurar')->name('prestamos.restaurar');
Route::get('prestamo-tipo-cambio','API\PrestamoController@obtenerTipoCambio')->name('prestamos.tipo-cambio');
Route::get('obtener-interes','API\PrestamoController@obtenerInteres')->name('prestamos.obtener-interes');
//CLIENTES
Route::post('cliente-verificar-documento','API\ClienteController@verificarNumeroDocumento')->name('clientes.verificar-documento');
