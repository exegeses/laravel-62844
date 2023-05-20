<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/inicio', 'inicio');

#########################
#### CRUD de marcas
//Route::metodo('petición', [controlador::class, 'metodo']);
use App\Http\Controllers\MarcaController;
Route::get('/marcas', [ MarcaController::class, 'index' ]);
Route::get('/marca/create', [ MarcaController::class, 'create' ]);
Route::post('/marca/store', [ MarcaController::class, 'store' ]);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ]);
Route::put('/marca/update', [ MarcaController::class, 'update' ]);
Route::get('/marca/delete/{id}', [ MarcaController::class, 'confirmarBaja' ]);
Route::delete('/marca/destroy', [ MarcaController::class, 'destroy' ]);

#########################
use App\Http\Controllers\CategoriaController;
#### CRUD de categorias
Route::get('/categorias', [ CategoriaController::class, 'index']);

#########################
#### CRUD de productos
use App\Http\Controllers\ProductoController;
Route::get('/productos', [ ProductoController::class, 'index' ]);
Route::get('/producto/create', [ ProductoController::class, 'create' ]);
Route::post('/producto/store', [ ProductoController::class, 'store' ]);
Route::get('/producto/edit/{id}', [ ProductoController::class, 'edit' ]);
Route::put('/producto/update', [ ProductoController::class, 'update' ]);
Route::get('/producto/delete/{id}', [ ProductoController::class, 'delete' ]);
Route::delete('/producto/destroy', [ ProductoController::class, 'destroy' ]);
