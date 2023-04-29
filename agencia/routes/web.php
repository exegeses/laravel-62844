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
    /* raw SQL
    $region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :id',
                                    [ $id ]
                        );
    */
    $region = DB::table('regiones')
                    ->where('idRegion', $id)
                    ->first();
    //retornamos a la vista del formulario para modificar
    return view('regionEdit', [ 'region'=>$region ]);
});
Route::put('/region/update', function ()
{
    $regNombre = request('regNombre');
    $idRegion = request('idRegion');
    try {
      /* raw SQL
        DB::update('UPDATE regiones
                        SET regNombre = :regNombre
                      WHERE idRegion = :id',
                        [ $regNombre, $idRegion ]
                    );
      */
        DB::table('regiones')
                ->where('idRegion', $idRegion)
                ->update([ 'regNombre'=>$regNombre ]);
        //redirección con mensaje ok
        return redirect('/regiones')
            ->with([
                'mensaje'=>'Region: '.$regNombre.' modificada correctamente.',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable $th )
    {
        // si hay error, redirección + mensaje error
        return redirect('/regiones')
            ->with([
                'mensaje'=>'No se pudo modificar la región: '.$regNombre,
                'css'=>'danger'
            ]);
    }
});
Route::get('/region/delete/{id}', function ($id)
{
    ### chequeo de destinos relacionado a la región
    $cantidad = DB::table('destinos')
                    ->where('idRegion', $id)->count();
    if( $cantidad ){
        return redirect('/regiones')
            ->with([
                'mensaje'=>'No se eliminar la región porque tiene destinos relacionados.',
                'css'=>'danger'
            ]);
    }

    //obtenemos datos de la región a eliminar
    $region = DB::table('regiones')
                    ->where('idRegion', $id)
                    ->first();
    return view('regionDelete', [ 'region'=>$region ]);
});
Route::delete('/region/destroy', function ()
{
    $regNombre = request('regNombre');
    $idRegion = request('idRegion');
    try {
        DB::table('regiones')
                ->where('idRegion', $idRegion)
                ->delete();
        //redirección con mensaje ok
        return redirect('/regiones')
            ->with([
                'mensaje'=>'Region: '.$regNombre.' eliminada correctamente.',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable $th )
    {
        // si hay error, redirección + mensaje error
        return redirect('/regiones')
            ->with([
                'mensaje'=>'No se pudo eliminar la región: '.$regNombre,
                'css'=>'danger'
            ]);
    }
});

/*####### CRUD de destinos ########*/
Route::get('/destinos', function ()
{
    //obtenemos listado de destinos
    /* $destinos = DB::select('SELECT idDestino, destNombre, regNombre, destPrecio
                                FROM destinos
                                JOIN regiones
                                  ON destinos.idRegion = regiones.idRegion');
    */
    $destinos = DB::table('destinos as d')
                    ->join('regiones as r', 'd.idRegion', '=', 'r.idRegion')
                    ->get();
    return view('destinos', [ 'destinos'=>$destinos ]);
});
Route::get('/destino/create', function ()
{

});
