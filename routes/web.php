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

Route::get('/', function () {
    return view('productos');
});

Route::prefix('productos')->group(function () {
    Route::post('consultarProductos', 'ProductosController@consultarProductos');
    Route::post('consultarEstados', 'ProductosController@consultarEstados');
    Route::post('editarProducto', 'ProductosController@editarProducto');
    Route::post('crearProducto', 'ProductosController@crearProducto');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');