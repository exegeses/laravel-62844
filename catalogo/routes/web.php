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


#########################
use App\Http\Controllers\CategoriaController;
#### CRUD de categorias
Route::get('/categorias', [ CategoriaController::class, 'index']);
