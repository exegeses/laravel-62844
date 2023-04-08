<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
    Route::metodo( 'peticion', acción );
 */
Route::get('/nombre', function()
{
    return 'resultado de proceso de petición "nombre"';
});
Route::get('/saludo', function ()
{
    return view('bienvenida');
});
