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

Route::view('/inicio', 'inicio');


/* pasaje de datos a una vista */
Route::get('/datos', function ()
{
    $nombre = 'marcos';
    $marcas = [
                'Adidas', 'Puma', 'Nike',
                'UniQlo', 'Assics', 'Reebok'
            ];
    return view('datos',
                [
                    'nombre'=>$nombre,
                    'numero'=>11,
                    'marcas'=>$marcas
                ]
    );
});

/* formulario */
Route::view('/form', 'formulario');
Route::post('/proceso', function ()
{
    //capturamos dato enviado por el form
    //$nombre = $_POST['nombre'];
    //$nombre = request()->post('nombre');
    //$nombre = request()->input('nombre');
    //$nombre = request()->nombre;
    $nombre = request('nombre');
    return view('proceso', [ 'nombre'=>$nombre ]);
});

/* BASES DE DATOS
    usando RawSQL  + Façade DB
*/
Route::get('/listarRegiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select("SELECT idRegion, regNombre
                                FROM regiones");
    return view('listarRegiones', [ 'regiones'=>$regiones ]);
});

/*####### CRUD de regiones ########*/
Route::get('/regiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select("SELECT idRegion, regNombre
                                FROM regiones");
    return view('regiones',
                    [ 'regiones'=>$regiones ]
                );
});
Route::get('/region/create', function () {
    return view('regionCreate');
});
Route::post('/region/store', function ()
{
    //capturamos dato enviado por el form
    $regNombre = request('regNombre');

    try
    {
        //insertamos dato en tabla regiones
        DB::insert('INSERT INTO regiones
                        ( regNombre )
                      VALUE
                        ( :regNombre )',
                        [ $regNombre ]
                    );
        //redirección con mensaje ok
        return redirect('/regiones')
            ->with([
                'mensaje'=>'Region: '.$regNombre.' agregada correctamente.',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable $th )
    {
        // si hay error, redirección + mensaje error
        return redirect('/regiones')
            ->with([
                'mensaje'=>'No se pudo agregar la región: '.$regNombre,
                'css'=>'danger'
            ]);
    }
});
Route::get('/region/edit/{id}', function ($id)
{
    //obtenemos datos de la region filtrada por su id
    $region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :id',
                                    [ $id ]
                        );
    //retornamos a la vista del formulario para modificar
    return view('regionEdit', [ 'region'=>$region ]);
});
