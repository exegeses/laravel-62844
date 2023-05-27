<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/marcas', function ()
{
    return view('marcas');
})->middleware(['auth'])->name('marcas');

Route::get('/categorias', function ()
{
    return view('categorias');
})->middleware(['auth'])->name('categorias');

Route::get('/productos', function ()
{
    return view('productos');
})->middleware(['auth'])->name('productos');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
